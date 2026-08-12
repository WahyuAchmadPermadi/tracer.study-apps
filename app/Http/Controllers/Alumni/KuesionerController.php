<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Alumni;
use App\Models\JawabanTracer;

class KuesionerController extends Controller
{
    /**
     * Membuat / mengambil draft jawaban tracer
     */
    private function jawabanTracer()
    {
        $alumni = Alumni::findOrFail(session('alumni_nim'));

        return JawabanTracer::firstOrCreate(
            ['nim' => $alumni->nim],
            [
                'whatsapp' => $alumni->no_hp,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN 1
    |--------------------------------------------------------------------------
    */

    public function halaman1()
    {
        $alumni = Alumni::findOrFail(session('alumni_nim'));
        $jawaban = $this->jawabanTracer();

        return view('alumni.kuesioner.halaman1', compact('alumni', 'jawaban'));
    }

    public function simpanHalaman1(Request $request)
    {
        $request->validate([
            'whatsapp' => 'required',
            'nik'      => 'required|digits:16',
            'npwp'     => 'nullable',
        ]);

        $this->jawabanTracer()->update([
            'whatsapp' => $request->whatsapp,
            'nik'      => $request->nik,
            'npwp'     => $request->npwp,
        ]);

        return redirect()->route('kuesioner.halaman2');
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN 2
    |--------------------------------------------------------------------------
    */

    public function halaman2()
    {
        $alumni = Alumni::findOrFail(session('alumni_nim'));
        $jawaban = $this->jawabanTracer();

        return view('alumni.kuesioner.halaman2', compact('alumni', 'jawaban'));
    }
    public function simpanHalaman2(Request $request)
    {
        $request->validate([
            'status' => 'required',
        ]);
    
        $data = [
            'status' => $request->status,
        ];
    
        // Jika melanjutkan pendidikan,
        // data pekerjaan tidak diperlukan.
        if ($request->status === 'Melanjutkan Pendidikan') {
    
            $data['mulai_mencari_kerja'] = null;
            $data['pekerjaan_pertama'] = null;
            $data['pendapatan'] = null;
    
            $this->jawabanTracer()->update($data);
    
            return redirect()->route('kuesioner.halaman4');
        }
    
        // Untuk status selain melanjutkan pendidikan,
        // simpan data pekerjaan seperti biasa.
        $data['mulai_mencari_kerja'] = $request->mulai_mencari_kerja
            ? $request->mulai_mencari_kerja . '-01'
            : null;
    
        $data['pekerjaan_pertama'] = $request->pekerjaan_pertama
            ? $request->pekerjaan_pertama . '-01'
            : null;
    
        $data['pendapatan'] = $request->pendapatan;
    
        $this->jawabanTracer()->update($data);
    
        return redirect()->route('kuesioner.halaman3');
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN 3
    |--------------------------------------------------------------------------
    */

    public function halaman3()
    {
        $alumni = Alumni::findOrFail(session('alumni_nim'));
        $jawaban = $this->jawabanTracer();

        return view('alumni.kuesioner.halaman3', compact('alumni', 'jawaban'));
    }

    public function simpanHalaman3(Request $request)
    {
        $this->jawabanTracer()->update($request->only([
            'jenis_perusahaan',
            'nama_perusahaan',
            'jabatan',
            'provinsi',
            'kabupaten',
            'tingkat_tempat_kerja',
        ]));

        return redirect()->route('kuesioner.halaman4');
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN 4
    |--------------------------------------------------------------------------
    */

    public function halaman4()
    {
        $alumni = Alumni::findOrFail(session('alumni_nim'));
        $jawaban = $this->jawabanTracer();

        return view('alumni.kuesioner.halaman4', compact('alumni', 'jawaban'));
    }

    public function simpanHalaman4(Request $request)
    {
        $data = $request->only([
            'studi_lanjut',
            'sumber_biaya',
            'nama_pt',
            'program_studi_lanjut',
            'tanggal_masuk',
            'hubungan_bidang',
            'tingkat_pendidikan',
        ]);
    
        // Input type="month" menghasilkan YYYY-MM,
        // sedangkan database DATE membutuhkan YYYY-MM-DD.
        if (!empty($data['tanggal_masuk'])) {
            $data['tanggal_masuk'] .= '-01';
        }
    
        $this->jawabanTracer()->update($data);
    
        return redirect()->route('kuesioner.halaman5');
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN 5
    |--------------------------------------------------------------------------
    */

    public function halaman5()
    {
        $alumni = Alumni::findOrFail(session('alumni_nim'));
        $jawaban = $this->jawabanTracer();

        return view('alumni.kuesioner.halaman5', compact('alumni', 'jawaban'));
    }

    public function simpanHalaman5(Request $request)
    {
        $this->jawabanTracer()->update($request->only([
            'etika_lulus',
            'etika_kerja',
            'keahlian_bidang_lulus',
            'keahlian_bidang_kerja',
            'bahasa_inggris_lulus',
            'bahasa_inggris_kerja',
            'teknologi_informasi_lulus',
            'teknologi_informasi_kerja',
            'komunikasi_lulus',
            'komunikasi_kerja',
            'kerjasama_tim_lulus',
            'kerjasama_tim_kerja',
            'pengembangan_diri_lulus',
            'pengembangan_diri_kerja',
        ]));

        return redirect()->route('kuesioner.halaman6');
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN 6
    |--------------------------------------------------------------------------
    */

    public function halaman6()
    {
        $alumni = Alumni::findOrFail(session('alumni_nim'));
        $jawaban = $this->jawabanTracer();

        return view('alumni.kuesioner.halaman6', compact('alumni', 'jawaban'));
    }

    public function simpanHalaman6(Request $request)
    {
        $this->jawabanTracer()->update($request->only([
            'perkuliahan',
            'demonstrasi',
            'proyek_riset',
            'magang',
            'praktikum',
            'kerja_lapangan',
            'diskusi',
        ]));

        return redirect()->route('kuesioner.halaman7');
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN 7
    |--------------------------------------------------------------------------
    */

    public function halaman7()
    {
        $alumni = Alumni::findOrFail(session('alumni_nim'));
        $jawaban = $this->jawabanTracer();

        return view('alumni.kuesioner.halaman7', compact('alumni', 'jawaban'));
    }

    public function simpanHalaman7(Request $request)
    {
        $this->jawabanTracer()->update([
            'cara_mencari'     => $request->cara_mencari,
            'jumlah_lamaran'   => $request->jumlah_lamaran,
            'jumlah_respon'    => $request->jumlah_respon,
            'jumlah_wawancara' => $request->jumlah_wawancara,
            'aktif_mencari'    => $request->aktif_mencari,
            'alasan'           => $request->alasan,
        ]);

        return redirect()->route('kuesioner.halaman8');
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN 8
    |--------------------------------------------------------------------------
    */

    public function halaman8()
    {
        $alumni = Alumni::findOrFail(session('alumni_nim'));
        $jawaban = $this->jawabanTracer();

        return view('alumni.kuesioner.halaman8', compact('alumni', 'jawaban'));
    }

    /*
    |--------------------------------------------------------------------------
    | SUBMIT
    |--------------------------------------------------------------------------
    */

    public function submit()
    {
        $jawaban = $this->jawabanTracer();

        $jawaban->update([
            'submitted_at' => now(),
        ]);

        return redirect()
            ->route('alumni.dashboard')
            ->with('success', 'Terima kasih, kuesioner berhasil dikirim.');
    }
}
