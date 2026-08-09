<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AlumniImport;
use App\Exports\AlumniTemplateExport;

class ImportController extends Controller
{
    public function index()
    {
        return view('admin.import.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $import = new AlumniImport();

        Excel::import($import, $request->file('file'));

        return redirect('/admin/import')->with([
            'success'   => 'Import selesai.',
            'inserted'  => $import->inserted,
            'updated'   => $import->updated,
            'failed'    => $import->failed,
            'skipped'   => $import->skipped,
            'errors'    => $import->errors,
        ]);
    }

    public function downloadTemplate()
    {
        return Excel::download(
            new AlumniTemplateExport(),
            'Template_Import_Alumni.xlsx'
        );
    }
}