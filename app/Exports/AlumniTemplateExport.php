<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AlumniTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'nim',
            'nama',
            'tanggal_lahir',
            'kode_program_studi',
            'program_studi',
            'tahun_lulus',
            'email',
            'no_hp',
        ];
    }

    public function array(): array
    {
        return [
            [
                'T0123456',
                'Nama Alumni',
                '2002-01-15',
                '57201',
                'Sistem Informasi',
                '2024',
                'alumni@email.com',
                '081234567890',
            ],
        ];
    }
}
