<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kuesioner;

class KuesionerController extends Controller
{
    public function index()
    {
        $kuesioners = Kuesioner::orderBy('urutan')
                        ->orderBy('kategori')
                        ->get();

        return view(
            'admin.kuesioner.index',
            compact('kuesioners')
        );
    }//

    public function create()
    {
        return view('admin.kuesioner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|max:100',
            'pertanyaan' => 'required',
            'jenis_jawaban' => 'required',
            'urutan' => 'required|integer|min:1',
        ]);

        $pilihan = null;

        if (in_array($request->jenis_jawaban, ['radio', 'checkbox', 'select'])) {

            $pilihan = array_filter(
                array_map('trim', explode("\n", $request->pilihan))
            );
        }

        Kuesioner::create([
            'kategori'       => $request->kategori,
            'pertanyaan'     => $request->pertanyaan,
            'jenis_jawaban'  => $request->jenis_jawaban,
            'pilihan'        => $pilihan,
            'urutan'         => $request->urutan,
            'aktif'          => $request->has('aktif'),
        ]);

        return redirect()
            ->route('kuesioner.index')
            ->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kuesioner = Kuesioner::findOrFail($id);

        return view('admin.kuesioner.edit', compact('kuesioner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori' => 'required|max:100',
            'pertanyaan' => 'required',
            'jenis_jawaban' => 'required',
            'urutan' => 'required|integer|min:1',
        ]);

        $kuesioner = Kuesioner::findOrFail($id);

        $pilihan = null;

        if (in_array($request->jenis_jawaban, ['radio', 'checkbox', 'select'])) {
            $pilihan = array_filter(
                array_map('trim', explode("\n", $request->pilihan))
            );
        }

        $kuesioner->update([
            'kategori' => $request->kategori,
            'pertanyaan' => $request->pertanyaan,
            'jenis_jawaban' => $request->jenis_jawaban,
            'pilihan' => $pilihan,
            'urutan' => $request->urutan,
            'aktif' => $request->has('aktif'),
        ]);

        return redirect()
            ->route('kuesioner.index')
            ->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kuesioner = Kuesioner::findOrFail($id);

        $kuesioner->delete();

        return redirect()
            ->route('kuesioner.index')
            ->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
