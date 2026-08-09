<?php

namespace App\Imports;

use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AlumniImport implements OnEachRow, WithHeadingRow
{
    public int $inserted = 0;
    public int $updated = 0;
    public int $failed = 0;
    public int $skipped = 0;

    public array $errors = [];
    
    public function onRow(Row $row)
    {
        $data = $row->toArray();

        try {

            // cek nim kosong
            if (empty($data['nim'])) {

                $this->skipped++;

                return;
            }

            // VALIDASI DATA
            $validator = Validator::make($data, [
                'nim' => 'required',
                'nama' => 'required',
                'tanggal_lahir' => 'required',
                'kode_program_studi' => ['nullable', Rule::in(array_keys(Alumni::PROGRAM_STUDIS))],
                'program_studi' => 'required_without:kode_program_studi',
                'tahun_lulus' => 'required|numeric',
                'email' => 'required|email',
                'no_hp' => 'required',
            ],
            [
                'required' => ':attribute wajib diisi.',
                'numeric'  => ':attribute harus berupa angka.',
                'email'    => ':attribute harus berupa email yang valid.',
            ],
            [
                'nim' => 'NIM',
                'nama' => 'Nama',
                'tanggal_lahir' => 'Tanggal lahir',
                'kode_program_studi' => 'Kode program studi',
                'program_studi' => 'Program studi',
                'tahun_lulus' => 'Tahun lulus',
                'email' => 'Email',
                'no_hp' => 'Nomor HP',
            ]);

            if ($validator->fails()) {

                $this->failed++;

                $this->errors[] = [
                    'baris' => $row->getIndex(),
                    'nim' => $data['nim'] ?? '-',
                    'pesan' => implode(', ', $validator->errors()->all()),
                ];

                return;
            }

        $programStudi = Alumni::resolveProgramStudi(
            $data['kode_program_studi'] ?? null,
            $data['program_studi'] ?? null
        );

        // cari alumni berdasarkan nim
        $alumni = Alumni::where('nim', $data['nim'])->first();

        // konversi tanggal
        if (is_numeric($data['tanggal_lahir'])) {
            $tanggalLahir = Carbon::instance(
                Date::excelToDateTimeObject($data['tanggal_lahir'])
            )->format('Y-m-d');
        } else {
            $tanggalLahir = Carbon::parse($data['tanggal_lahir'])
                ->format('Y-m-d');
        }

        // siapkan data yang akan disimpan
        $alumniData = [
            'nama' => $data['nama'],
            'tanggal_lahir' => $tanggalLahir,
            ...$programStudi,
            'tahun_lulus' => $data['tahun_lulus'],
            'email' => $data['email'],
            'no_hp' => $data['no_hp'],
        ];

        if ($alumni) {

            // UPDATE
            $alumni->update($alumniData);

            $this->updated++;

        } else {

            // INSERT
            Alumni::create([
                'nim' => $data['nim'],
                ...$alumniData,
            ]);

            $this->inserted++;
        }

        } catch (\Exception $e) {

            $this->failed++;

            $this->errors[] = [
                'baris' => $row->getIndex(),
                'nim' => $data['nim'] ?? '-',
                'pesan' => $e->getMessage(),
            ];
        }
    }
}
