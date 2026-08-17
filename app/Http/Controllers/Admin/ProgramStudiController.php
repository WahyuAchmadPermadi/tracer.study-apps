<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProgramStudiController extends Controller
{
    public function index()
    {
        $programStudis = ProgramStudi::query()->orderBy('nama_program_studi')->paginate(10);

        return view('admin.program_studi.index', compact('programStudis'));
    }

    public function create()
    {
        return view('admin.program_studi.create');
    }

    public function store(Request $request)
    {
        ProgramStudi::create($this->validatedData($request));

        return redirect()->route('program-studi.index')->with('success', 'Program studi berhasil ditambahkan.');
    }

    public function edit(ProgramStudi $programStudi)
    {
        return view('admin.program_studi.edit', compact('programStudi'));
    }

    public function update(Request $request, ProgramStudi $programStudi)
    {
        $programStudi->update($this->validatedData($request, $programStudi));

        return redirect()->route('program-studi.index')->with('success', 'Program studi berhasil diperbarui.');
    }

    public function toggle(ProgramStudi $programStudi)
    {
        $programStudi->update([
            'status' => $programStudi->status === 'Aktif' ? 'Nonaktif' : 'Aktif',
        ]);

        return redirect()->route('program-studi.index')->with('success', 'Status program studi berhasil diperbarui.');
    }

    private function validatedData(Request $request, ?ProgramStudi $programStudi = null): array
    {
        return $request->validate([
            'kode_program_studi' => ['required', 'string', 'max:20', Rule::unique('program_studis')->ignore($programStudi)],
            'nama_program_studi' => ['required', 'string', 'max:100', Rule::unique('program_studis')->ignore($programStudi)],
            'status' => ['required', Rule::in(['Aktif', 'Nonaktif'])],
        ]);
    }
}
