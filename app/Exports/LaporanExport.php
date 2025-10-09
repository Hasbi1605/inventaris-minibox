<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $data;
    protected $type;
    protected $periode;

    public function __construct($data, $type, $periode)
    {
        $this->data = $data;
        $this->type = $type;
        $this->periode = $periode;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        switch ($this->type) {
            case 'gaji-kapster':
                return [
                    'No',
                    'Nama Kapster',
                    'Cabang',
                    'Total Transaksi',
                    'Nilai Transaksi',
                    'Persentase Komisi',
                    'Gaji Komisi',
                    'Total Gaji'
                ];
            case 'keuangan':
                return [
                    'No',
                    'Tanggal',
                    'Jenis',
                    'Kategori',
                    'Deskripsi',
                    'Debit',
                    'Kredit',
                    'Saldo'
                ];
            case 'cabang':
                return [
                    'No',
                    'Nama Cabang',
                    'Total Transaksi',
                    'Total Pendapatan',
                    'Total Pengeluaran',
                    'Laba Bersih',
                    'Persentase Kontribusi'
                ];
            case 'layanan':
                return [
                    'No',
                    'Nama Layanan',
                    'Kategori',
                    'Jumlah Transaksi',
                    'Total Pendapatan',
                    'Rata-rata per Transaksi'
                ];
            default:
                return ['Data'];
        }
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        // Convert object to array if needed
        if (is_object($row)) {
            $row = (array) $row;
        }

        switch ($this->type) {
            case 'gaji-kapster':
                return [
                    $no,
                    $row['nama_kapster'] ?? $row->nama_kapster ?? '-',
                    $row['cabang'] ?? $row->cabang ?? '-',
                    $row['total_transaksi'] ?? $row->total_transaksi ?? 0,
                    'Rp ' . number_format($row['nilai_transaksi'] ?? $row->nilai_transaksi ?? 0, 0, ',', '.'),
                    ($row['persentase_komisi'] ?? $row->persentase_komisi ?? 0) . '%',
                    'Rp ' . number_format($row['gaji_komisi'] ?? $row->gaji_komisi ?? 0, 0, ',', '.'),
                    'Rp ' . number_format($row['total_gaji'] ?? $row->total_gaji ?? 0, 0, ',', '.')
                ];
            case 'keuangan':
                $debit = $row['debit'] ?? $row->debit ?? 0;
                $kredit = $row['kredit'] ?? $row->kredit ?? 0;
                return [
                    $no,
                    $row['tanggal'] ?? $row->tanggal ?? '-',
                    $row['jenis'] ?? $row->jenis ?? '-',
                    $row['kategori'] ?? $row->kategori ?? '-',
                    $row['deskripsi'] ?? $row->deskripsi ?? '-',
                    $debit ? 'Rp ' . number_format($debit, 0, ',', '.') : '-',
                    $kredit ? 'Rp ' . number_format($kredit, 0, ',', '.') : '-',
                    'Rp ' . number_format($row['saldo'] ?? $row->saldo ?? 0, 0, ',', '.')
                ];
            case 'cabang':
                return [
                    $no,
                    $row['nama_cabang'] ?? $row->nama_cabang ?? '-',
                    $row['total_transaksi'] ?? $row->total_transaksi ?? 0,
                    'Rp ' . number_format($row['total_pendapatan'] ?? $row->total_pendapatan ?? 0, 0, ',', '.'),
                    'Rp ' . number_format($row['total_pengeluaran'] ?? $row->total_pengeluaran ?? 0, 0, ',', '.'),
                    'Rp ' . number_format($row['laba_bersih'] ?? $row->laba_bersih ?? 0, 0, ',', '.'),
                    ($row['persentase_kontribusi'] ?? $row->persentase_kontribusi ?? 0) . '%'
                ];
            case 'layanan':
                return [
                    $no,
                    $row['nama_layanan'] ?? $row->nama_layanan ?? '-',
                    $row['kategori'] ?? $row->kategori ?? '-',
                    $row['jumlah_transaksi'] ?? $row->jumlah_transaksi ?? 0,
                    'Rp ' . number_format($row['total_pendapatan'] ?? $row->total_pendapatan ?? 0, 0, ',', '.'),
                    'Rp ' . number_format($row['rata_rata'] ?? $row->rata_rata ?? 0, 0, ',', '.')
                ];
            default:
                return [$row];
        }
    }

    public function styles(Worksheet $sheet)
    {
        // Style untuk header
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563eb'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Auto size columns
        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Border untuk semua data
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ]);

        return $sheet;
    }

    public function title(): string
    {
        $titles = [
            'gaji-kapster' => 'Gaji & Komisi Kapster',
            'keuangan' => 'Laporan Keuangan',
            'cabang' => 'Laporan Per Cabang',
            'layanan' => 'Laporan Layanan',
        ];

        return $titles[$this->type] ?? 'Laporan';
    }
}
