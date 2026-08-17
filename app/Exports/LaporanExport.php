<?php

namespace App\Exports;

use App\Models\Alumni;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromArray, WithStyles, WithEvents
{
    protected $tahun;
    protected $prodi;
    protected $status;
    protected $idPeriode;

    protected $headerRow = 1;
    protected $dataRow = 1;
    protected $lastRow = 1;
    protected $lastColumn = 'A';

    public function __construct(
        $tahun = null,
        $prodi = null,
        $status = null,
        $idPeriode = null
    ) {
        $this->tahun = $tahun;
        $this->prodi = $prodi;
        $this->status = $status;
        $this->idPeriode = $idPeriode;
    }

    public function array(): array
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY ALUMNI + JAWABAN TRACER
        |--------------------------------------------------------------------------
        */

        $jawabanScope = function ($query) {
            if ($this->idPeriode) {
                $query->where('id_periode', $this->idPeriode);
            }
        };
        $query = Alumni::with(['jawabanTracer' => $jawabanScope]);

        if ($this->tahun) {
            $query->where('tahun_lulus', $this->tahun);
        }

        if ($this->prodi) {
            $query->where('program_studi', $this->prodi);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($this->status === 'sudah') {

            $query->whereHas('jawabanTracer', function ($q) {
                $q->whereNotNull('submitted_at');
                if ($this->idPeriode) $q->where('id_periode', $this->idPeriode);
            });

        } elseif ($this->status === 'belum') {

            $query->where(function ($q) {

                $q->whereDoesntHave('jawabanTracer')

                  ->orWhereHas('jawabanTracer', function ($sub) {
                      $sub->whereNull('submitted_at');
                      if ($this->idPeriode) $sub->where('id_periode', $this->idPeriode);
                  });

            });
        }

        $alumni = $query
            ->orderBy('program_studi')
            ->orderBy('nama')
            ->get();

        $rows = [];

        /*
        |--------------------------------------------------------------------------
        | JUDUL
        |--------------------------------------------------------------------------
        */

        $rows[] = [
            'UNIVERSITAS NAHDLATUL ULAMA KALIMANTAN BARAT'
        ];

        $rows[] = [
            'LAPORAN HASIL TRACER STUDY'
        ];

        $rows[] = [''];

        $rows[] = [
            'Tanggal Cetak : ' .
            Carbon::now()->translatedFormat('d F Y')
        ];

        $rows[] = [''];

        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $rows[] = ['FILTER'];

        $rows[] = [
            'Tahun Lulus : ' . ($this->tahun ?: 'Semua')
        ];

        $rows[] = [
            'Program Studi : ' . ($this->prodi ?: 'Semua')
        ];

        $rows[] = [
            'Status : ' . $this->getFilterStatus()
        ];

        $rows[] = [
            'Jumlah Data : ' . $alumni->count() . ' Alumni'
        ];

        $rows[] = [''];

        /*
        |--------------------------------------------------------------------------
        | HEADER EXCEL
        |--------------------------------------------------------------------------
        */

        $header = [
            'No',
            'NIM',
            'Nama',
            'Program Studi',
            'Tahun Lulus',
            'Email',
            'No HP',
            'WhatsApp',
            'Status Pengisian',

            'Status Saat Ini',
            'Mulai Mencari Kerja',
            'Pekerjaan Pertama',
            'Pendapatan',

            'Jenis Perusahaan',
            'Nama Perusahaan',
            'Jabatan',
            'Provinsi',
            'Kabupaten',
            'Tingkat Tempat Kerja',

            'Studi Lanjut',
            'Sumber Biaya',
            'Nama Perguruan Tinggi',
            'Program Studi Lanjut',
            'Tanggal Masuk',

            'Hubungan Bidang',
            'Tingkat Pendidikan',

            'Etika Lulus',
            'Etika Kerja',

            'Perkuliahan',
            'Demonstrasi',
            'Proyek Riset',
            'Magang',
            'Praktikum',
            'Kerja Lapangan',
            'Diskusi',

            'Cara Mencari Kerja',
            'Jumlah Lamaran',
            'Jumlah Respon',
            'Jumlah Wawancara',
            'Aktif Mencari',
            'Alasan',

            'Tanggal Submit',
        ];

        $rows[] = $header;

        $this->headerRow = count($rows);
        $this->dataRow = $this->headerRow + 1;

        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $no = 1;

        foreach ($alumni as $item) {

            $jawaban = $item->jawabanTracer;

            $sudahMengisi =
                $jawaban &&
                $jawaban->submitted_at !== null;

            $rows[] = [

                $no++,

                (string) $item->nim,

                $item->nama,

                $item->program_studi,

                $item->tahun_lulus,

                $item->email ?? '',

                (string) ($item->no_hp ?? ''),

                $jawaban->whatsapp ?? '',

                $sudahMengisi
                    ? 'Sudah Mengisi'
                    : 'Belum Mengisi',

                $jawaban->status ?? '',

                $this->formatTanggal($jawaban->mulai_mencari_kerja ?? null),

                $this->formatTanggal($jawaban->pekerjaan_pertama ?? null),

                $jawaban->pendapatan ?? '',

                $jawaban->jenis_perusahaan ?? '',

                $jawaban->nama_perusahaan ?? '',

                $jawaban->jabatan ?? '',

                $jawaban->provinsi ?? '',

                $jawaban->kabupaten ?? '',

                $jawaban->tingkat_tempat_kerja ?? '',

                $jawaban->studi_lanjut ?? '',

                $jawaban->sumber_biaya ?? '',

                $jawaban->nama_pt ?? '',

                $jawaban->program_studi_lanjut ?? '',

                $this->formatTanggal($jawaban->tanggal_masuk ?? null),

                $jawaban->hubungan_bidang ?? '',

                $jawaban->tingkat_pendidikan ?? '',

                $jawaban->etika_lulus ?? '',

                $jawaban->etika_kerja ?? '',

                $jawaban->perkuliahan ?? '',

                $jawaban->demonstrasi ?? '',

                $jawaban->proyek_riset ?? '',

                $jawaban->magang ?? '',

                $jawaban->praktikum ?? '',

                $jawaban->kerja_lapangan ?? '',

                $jawaban->diskusi ?? '',

                $jawaban->cara_mencari ?? '',

                $jawaban->jumlah_lamaran ?? '',

                $jawaban->jumlah_respon ?? '',

                $jawaban->jumlah_wawancara ?? '',

                $jawaban->aktif_mencari ?? '',

                $jawaban->alasan ?? '',

                $jawaban && $jawaban->submitted_at
                    ? Carbon::parse($jawaban->submitted_at)
                        ->format('d-m-Y H:i')
                    : '',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | POSISI TERAKHIR
        |--------------------------------------------------------------------------
        */

        $this->lastRow = count($rows);

        $this->lastColumn =
            Coordinate::stringFromColumnIndex(
                count($header)
            );

        return $rows;
    }

    /*
    |--------------------------------------------------------------------------
    | STYLE
    |--------------------------------------------------------------------------
    */

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->applyFromArray([

            'font' => [
                'bold' => true,
                'size' => 16,
            ],

            'alignment' => [
                'horizontal' =>
                    Alignment::HORIZONTAL_CENTER,
            ],

        ]);

        $sheet->getStyle('A2')->applyFromArray([

            'font' => [
                'bold' => true,
                'size' => 14,
            ],

            'alignment' => [
                'horizontal' =>
                    Alignment::HORIZONTAL_CENTER,
            ],

        ]);

        $sheet->getStyle('A6')
            ->getFont()
            ->setBold(true);

        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        $sheet->getStyle(
            "A{$this->headerRow}:{$this->lastColumn}{$this->headerRow}"
        )->applyFromArray([

            'font' => [
                'bold' => true,

                'color' => [
                    'rgb' => 'FFFFFF',
                ],
            ],

            'fill' => [
                'fillType' => Fill::FILL_SOLID,

                'startColor' => [
                    'rgb' => '1F4E78',
                ],
            ],

            'alignment' => [

                'horizontal' =>
                    Alignment::HORIZONTAL_CENTER,

                'vertical' =>
                    Alignment::VERTICAL_CENTER,

                'wrapText' => true,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | BORDER
        |--------------------------------------------------------------------------
        */

        if ($this->lastRow >= $this->headerRow) {

            $sheet->getStyle(
                "A{$this->headerRow}:{$this->lastColumn}{$this->lastRow}"
            )->applyFromArray([

                'borders' => [

                    'allBorders' => [

                        'borderStyle' =>
                            Border::BORDER_THIN,
                    ],
                ],
            ]);
        }

        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | EVENTS
    |--------------------------------------------------------------------------
    */

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                /*
                |--------------------------------------------------------------
                | MERGE JUDUL
                |--------------------------------------------------------------
                */

                $sheet->mergeCells(
                    "A1:{$this->lastColumn}1"
                );

                $sheet->mergeCells(
                    "A2:{$this->lastColumn}2"
                );

                /*
                |--------------------------------------------------------------
                | TINGGI BARIS
                |--------------------------------------------------------------
                */

                $sheet->getRowDimension(1)
                    ->setRowHeight(24);

                $sheet->getRowDimension(2)
                    ->setRowHeight(22);

                $sheet->getRowDimension(
                    $this->headerRow
                )->setRowHeight(50);

                /*
                |--------------------------------------------------------------
                | FREEZE HEADER
                |--------------------------------------------------------------
                */

                $sheet->freezePane(
                    'A' . $this->dataRow
                );

                /*
                |--------------------------------------------------------------
                | AUTO FILTER
                |--------------------------------------------------------------
                */

                if ($this->lastRow >= $this->headerRow) {

                    $sheet->setAutoFilter(
                        "A{$this->headerRow}:{$this->lastColumn}{$this->lastRow}"
                    );
                }

                /*
                |--------------------------------------------------------------
                | WIDTH
                |--------------------------------------------------------------
                */

                $jumlahKolom =
                    Coordinate::columnIndexFromString(
                        $this->lastColumn
                    );

                for ($i = 1; $i <= $jumlahKolom; $i++) {

                    $column =
                        Coordinate::stringFromColumnIndex($i);

                    if ($i <= 9) {

                        $sheet->getColumnDimension($column)
                            ->setAutoSize(true);

                    } else {

                        $sheet->getColumnDimension($column)
                            ->setAutoSize(false);

                        $sheet->getColumnDimension($column)
                            ->setWidth(22);
                    }
                }

                /*
                |--------------------------------------------------------------
                | WRAP TEXT
                |--------------------------------------------------------------
                */

                if ($this->lastRow >= $this->headerRow) {

                    $sheet->getStyle(
                        "A{$this->headerRow}:{$this->lastColumn}{$this->lastRow}"
                    )
                    ->getAlignment()
                    ->setWrapText(true);
                }

                /*
                |--------------------------------------------------------------
                | ALIGNMENT HEADER
                |--------------------------------------------------------------
                */

                $sheet->getStyle(
                    "A{$this->headerRow}:{$this->lastColumn}{$this->headerRow}"
                )
                ->getAlignment()
                ->setHorizontal(
                    Alignment::HORIZONTAL_CENTER
                );

                $sheet->getStyle(
                    "A{$this->headerRow}:{$this->lastColumn}{$this->headerRow}"
                )
                ->getAlignment()
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                );

                /*
                |--------------------------------------------------------------
                | FONT DATA
                |--------------------------------------------------------------
                */

                if ($this->lastRow >= $this->dataRow) {

                    $sheet->getStyle(
                        "A{$this->dataRow}:{$this->lastColumn}{$this->lastRow}"
                    )
                    ->getFont()
                    ->setSize(10);
                }
            },
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER STATUS
    |--------------------------------------------------------------------------
    */

    protected function getFilterStatus(): string
    {
        return match ($this->status) {

            'sudah' => 'Sudah Mengisi',

            'belum' => 'Belum Mengisi',

            default => 'Semua',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER TANGGAL
    |--------------------------------------------------------------------------
    */

    protected function formatTanggal($tanggal): string
    {
        if (!$tanggal) {
            return '';
        }

        try {

            return Carbon::parse($tanggal)
                ->format('d-m-Y');

        } catch (\Exception $e) {

            return (string) $tanggal;
        }
    }
}
