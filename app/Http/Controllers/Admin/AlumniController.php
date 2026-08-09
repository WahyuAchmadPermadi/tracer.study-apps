<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Alumni;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $alumnis = Alumni::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nim', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.alumni.index', compact('alumnis', 'search'));
    }

    public function create()
    {
        $programStudis = Alumni::PROGRAM_STUDIS;

        return view('admin.alumni.create', compact('programStudis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:alumnis,nim',
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'kode_program_studi' => ['required', Rule::in(array_keys(Alumni::PROGRAM_STUDIS))],
            'tahun_lulus' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
        ]);

        Alumni::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            ...Alumni::resolveProgramStudi($request->kode_program_studi),
            'tahun_lulus' => $request->tahun_lulus,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

        return redirect('/admin/alumni')
                ->with('success', 'Data alumni berhasil ditambahkan.');
    }

    public function edit($nim)
    {
        $alumni = Alumni::findOrFail($nim);
        $programStudis = Alumni::PROGRAM_STUDIS;

        return view('admin.alumni.edit', compact('alumni', 'programStudis'));
    }//

    public function update(Request $request, $nim)
    {
        $request->validate([
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'kode_program_studi' => ['required', Rule::in(array_keys(Alumni::PROGRAM_STUDIS))],
            'tahun_lulus' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
        ]);

        $alumni = Alumni::findOrFail($nim);

        $alumni->update([
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            ...Alumni::resolveProgramStudi($request->kode_program_studi),
            'tahun_lulus' => $request->tahun_lulus,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

        return redirect('/admin/alumni')
            ->with('success', 'Data alumni berhasil diupdate.');
    }

    public function destroy($nim)
    {
        $alumni = Alumni::findOrFail($nim);

        $alumni->delete();

        return redirect('/admin/alumni')
                ->with('success', 'Data alumni berhasil dihapus.');
    }
}
