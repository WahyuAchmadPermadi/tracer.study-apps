@extends('layouts.app')

@section('title', 'Program Studi')

@section('content')
<div class="card shadow"><div class="card-header bg-success text-white"><h5 class="mb-0">Edit Program Studi</h5></div><div class="card-body">
    <form method="POST" action="{{ route('program-studi.update', $programStudi) }}">@csrf @method('PUT')
        @include('admin.program_studi.form')
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('program-studi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div></div>
@endsection
