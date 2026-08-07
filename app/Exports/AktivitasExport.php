<?php

namespace App\Exports;

use App\Models\jadwal_bimbingan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AktivitasExport implements FromCollection, WithHeadings, WithMapping
{
    protected $dari;
    protected $sampai;

    public function __construct($dari = null, $sampai = null)
    {
        $this->dari = $dari;
        $this->sampai = $sampai;
    }

    public function collection()
    {
        $query = jadwal_bimbingan::with(['mahasiswa.pengguna', 'dosenPA.pengguna']);

        if ($this->dari && $this->sampai) {
            $query->whereDate('created_at', '>=', $this->dari)
                  ->whereDate('created_at', '<=', $this->sampai);
        }

        return $query->orderBy('created_at', 'desc')
            ->get();
    }

    public function map($item): array
    {
        $statusText = $item->status_jadwal == 1 ? 'Disetujui' : ($item->status_jadwal == 2 ? 'Ditolak' : 'Menunggu');
        
        return [
            $item->id_jadwal,
            'Jadwal Bimbingan',
            $item->dosenPA->pengguna->nama ?? 'Tidak Diketahui',
            $item->mahasiswa->pengguna->nama ?? 'Tidak Diketahui',
            $item->tanggal_jadwal,
            $item->jam_jadwal,
            $item->topik_diskusi ?? '-',
            $item->tipe ?? 'Tatap Muka',
            $statusText,
            $item->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function headings(): array
    {
        return [
            'ID Jadwal',
            'Jenis Aktivitas',
            'Nama Dosen',
            'Nama Mahasiswa',
            'Tanggal',
            'Jam',
            'Topik',
            'Tipe Bimbingan',
            'Status',
            'Dibuat Pada',
        ];
    }
}
