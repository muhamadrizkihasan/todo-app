@extends('layout')

@section('content')
    @if (Session::get('notAllowed'))
        <div class="alert alert-danger">
            {{ Session::get('notAllowed') }}
        </div>
    @endif
    <div class="container mt-5">
        <div class="table table-success table-striped table-bordered">
            <tr>
                <td>No</td>
                <td>Kegiatan</td>
                <td>Deskripsi</td>
                <td>Batas Waktu</td>
                <td>Status</td>
                <td>Aksi</td>
            </tr>
            <tr></tr>
        </div>
    </div>
@endsection
