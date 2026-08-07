<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\jadwal_bimbingan;
use App\Models\penilaian_bimbingan;
use App\Models\hasil_bimbingan;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AktivitasExport;

class MonitoringController extends Controller
{
    /**
     * Tampilkan halaman utama Monitoring
     */
    public function index()
    {
        $bulanSekarang = Carbon::now()->month;
        $tahunSekarang = Carbon::now()->year;

        // Hitung metrik
        $jadwalBulanIni = jadwal_bimbingan::whereMonth('tanggal_jadwal', $bulanSekarang)
                            ->whereYear('tanggal_jadwal', $tahunSekarang)
                            ->get();
        $jumlahBimbingan = $jadwalBulanIni->count();

        // Tingkat kehadiran berdasarkan jumlah jadwal bulan ini yang sudah selesai (ada hasil bimbingan)
        $jadwalSelesai = jadwal_bimbingan::whereMonth('tanggal_jadwal', $bulanSekarang)
                            ->whereYear('tanggal_jadwal', $tahunSekarang)
                            ->has('hasil_bimbingan')
                            ->count();
        $tingkatKehadiran = $jumlahBimbingan > 0 ? min(round(($jadwalSelesai / $jumlahBimbingan) * 100), 100) : 0;

        // Rata-rata skor bulan ini dari penilaian_bimbingan
        $penilaianBulanIni = penilaian_bimbingan::whereMonth('created_at', $bulanSekarang)
                                ->whereYear('created_at', $tahunSekarang)
                                ->avg('nilai_perkembangan');
        $rataSkor = $penilaianBulanIni ?? 0;

        // Belum ditinjau: jadwal yang statusnya menunggu (0)
        $belumDitinjau = jadwal_bimbingan::where('status_jadwal', 0)->count();

        // Data chart: sesi per bulan
        $sesiPerBulan = [
            'Jan' => jadwal_bimbingan::whereMonth('tanggal_jadwal', 1)->whereYear('tanggal_jadwal', $tahunSekarang)->count(),
            'Feb' => jadwal_bimbingan::whereMonth('tanggal_jadwal', 2)->whereYear('tanggal_jadwal', $tahunSekarang)->count(),
            'Mar' => jadwal_bimbingan::whereMonth('tanggal_jadwal', 3)->whereYear('tanggal_jadwal', $tahunSekarang)->count(),
            'Apr' => jadwal_bimbingan::whereMonth('tanggal_jadwal', 4)->whereYear('tanggal_jadwal', $tahunSekarang)->count(),
            'Mei' => jadwal_bimbingan::whereMonth('tanggal_jadwal', 5)->whereYear('tanggal_jadwal', $tahunSekarang)->count(),
            'Jun' => jadwal_bimbingan::whereMonth('tanggal_jadwal', 6)->whereYear('tanggal_jadwal', $tahunSekarang)->count(),
            'Jul' => jadwal_bimbingan::whereMonth('tanggal_jadwal', 7)->whereYear('tanggal_jadwal', $tahunSekarang)->count(),
            'Ags' => jadwal_bimbingan::whereMonth('tanggal_jadwal', 8)->whereYear('tanggal_jadwal', $tahunSekarang)->count(),
            'Sep' => jadwal_bimbingan::whereMonth('tanggal_jadwal', 9)->whereYear('tanggal_jadwal', $tahunSekarang)->count(),
            'Okt' => jadwal_bimbingan::whereMonth('tanggal_jadwal', 10)->whereYear('tanggal_jadwal', $tahunSekarang)->count(),
            'Nov' => jadwal_bimbingan::whereMonth('tanggal_jadwal', 11)->whereYear('tanggal_jadwal', $tahunSekarang)->count(),
            'Des' => jadwal_bimbingan::whereMonth('tanggal_jadwal', 12)->whereYear('tanggal_jadwal', $tahunSekarang)->count(),
        ];

        // Aktivitas terbaru: ambil 3 jadwal terakhir
        $terbaru = jadwal_bimbingan::with(['mahasiswa.pengguna', 'dosenPA.pengguna'])->orderBy('created_at', 'desc')->take(3)->get();
        $aktivitasTerbaru = [];
        foreach($terbaru as $item) {
            $statusText = $item->status_jadwal == 1 ? 'disetujui' : ($item->status_jadwal == 2 ? 'ditolak' : 'menunggu');
            $statusColor = $item->status_jadwal == 1 ? 'text-[#16A34A]' : ($item->status_jadwal == 2 ? 'text-[#DC2626]' : 'text-[#F59E0B]');
            $aktivitasTerbaru[] = (object) [
                'dot' => 'bg-[#2653EB]',
                'judul' => 'Jadwal bimbingan',
                'sorot' => $statusText,
                'sorot_color' => $statusColor,
                'keterangan' => ($item->dosenPA->pengguna->nama ?? 'Dosen') . ' - ' . ($item->mahasiswa->pengguna->nama ?? 'Mhs') . ' &bull; ' . $item->created_at->diffForHumans(),
            ];
        }

        $ringkasan = [
            'jumlahBimbingan' => $jumlahBimbingan,
            'tingkatKehadiran' => $tingkatKehadiran,
            'rataSkor' => $rataSkor,
            'belumDitinjau' => $belumDitinjau,
        ];

        return view('pages.operator.monitoring.index', [
            'periode' => Carbon::now()->translatedFormat('F Y'),
            'ringkasan' => $ringkasan,
            'sesiPerBulan' => $sesiPerBulan,
            'aktivitasTerbaru' => $aktivitasTerbaru,
        ]);
    }

    public function jadwal()
    {
        $jadwals = jadwal_bimbingan::with(['mahasiswa.pengguna', 'dosenPA.pengguna'])->orderBy('tanggal_jadwal', 'desc')->get();
        
        $mappedJadwals = $jadwals->map(function($j) {
            return (object) [
                'topik' => $j->topik_diskusi ?? 'Bimbingan',
                'dosen' => $j->dosenPA->pengguna->nama ?? '-',
                'mahasiswa' => $j->mahasiswa->pengguna->nama ?? '-',
                'tanggal' => Carbon::parse($j->tanggal_jadwal)->translatedFormat('d F Y'),
                'waktu' => Carbon::parse($j->jam_jadwal)->format('H:i') . ' - Selesai',
                'tipe' => $j->tipe ?? 'Tatap Muka',
                'status_jadwal' => $j->status_jadwal
            ];
        });

        return view('pages.operator.monitoring.jadwal', [
            'jadwals' => $mappedJadwals
        ]);
    }

    public function hasil()
    {
        $hasils = hasil_bimbingan::with(['jadwal_bimbingan.mahasiswa.pengguna', 'jadwal_bimbingan.dosenPA.pengguna'])->orderBy('created_at', 'desc')->get();
        
        $mappedHasils = $hasils->map(function($h) {
            return (object) [
                'id_hasil' => $h->id_hasil,
                'topik' => $h->jadwal_bimbingan->topik_diskusi ?? 'Hasil Bimbingan',
                'dosen' => $h->jadwal_bimbingan->dosenPA->pengguna->nama ?? '-',
                'mahasiswa' => $h->jadwal_bimbingan->mahasiswa->pengguna->nama ?? '-',
                'tanggal' => Carbon::parse($h->created_at)->translatedFormat('d F Y'),
                'catatan_bimbingan' => $h->catatan_bimbingan,
                'arahan_akademik' => $h->arahan_akademik,
            ];
        });

        return view('pages.operator.monitoring.hasil', [
            'hasils' => $mappedHasils
        ]);
    }

    public function penilaian()
    {
        $penilaians = penilaian_bimbingan::with(['hasilBimbingan.jadwal_bimbingan.mahasiswa.pengguna', 'hasilBimbingan.jadwal_bimbingan.dosenPA.pengguna'])->orderBy('created_at', 'desc')->get();
        
        $mappedPenilaians = $penilaians->map(function($p) {
            $jadwal = $p->hasilBimbingan->jadwal_bimbingan ?? null;
            return (object) [
                'id_perkembangan' => $p->id_perkembangan,
                'topik' => $jadwal->topik_diskusi ?? 'Penilaian Bimbingan',
                'dosen' => $jadwal->dosenPA->pengguna->nama ?? '-',
                'mahasiswa' => $jadwal->mahasiswa->pengguna->nama ?? '-',
                'tanggal' => Carbon::parse($p->created_at)->translatedFormat('d F Y'),
                'skor_keaktifan' => $p->skor_keaktifan,
                'skor_pemahaman' => $p->skor_pemahaman,
                'nilai_perkembangan' => $p->nilai_perkembangan,
            ];
        });

        return view('pages.operator.monitoring.penilaian', [
            'penilaians' => $mappedPenilaians
        ]);
    }

    public function exportAktivitas(Request $request)
    {
        $request->validate([
            'dari' => 'required|date',
            'sampai' => 'required|date|after_or_equal:dari',
        ]);

        $dari = Carbon::parse($request->query('dari'));
        $sampai = Carbon::parse($request->query('sampai'));

        if ($dari->year !== $sampai->year) {
            return back()->with('error_export', 'Periode yang dipilih hanya bisa di tahun yang sama.');
        }

        return Excel::download(new AktivitasExport($dari->format('Y-m-d'), $sampai->format('Y-m-d')), 'log_aktivitas_monitoring_'.Carbon::now()->format('Y-m-d_H-i-s').'.xlsx');
    }
}
