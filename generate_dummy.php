<?php

$dosen_csv = fopen(__DIR__ . '/public/dummy_dosen.csv', 'w');
fputcsv($dosen_csv, ['nip', 'nama', 'email', 'nomor_telepon', 'program_studi']);
for ($i = 1; $i <= 5; $i++) {
    $nip = '1122330' . $i;
    fputcsv($dosen_csv, [$nip, 'Dosen ' . $i, 'dosen' . $i . '@example.com', '0812000000' . $i, 'Teknik Informatika']);
}
fclose($dosen_csv);

$mhs_csv = fopen(__DIR__ . '/public/dummy_mahasiswa.csv', 'w');
fputcsv($mhs_csv, ['nim', 'nama', 'email', 'nomor_telepon', 'program_studi', 'semester', 'nip']);
for ($i = 1; $i <= 20; $i++) {
    $nim = '1091100' . str_pad($i, 2, '0', STR_PAD_LEFT);
    $dosen_nip = '1122330' . rand(1, 5);
    fputcsv($mhs_csv, [$nim, 'Mahasiswa ' . $i, 'mhs' . $i . '@student.example.com', '0857000000' . str_pad($i, 2, '0', STR_PAD_LEFT), 'Teknik Informatika', rand(1, 8), $dosen_nip]);
}
fclose($mhs_csv);

echo "CSVs created successfully.\n";
