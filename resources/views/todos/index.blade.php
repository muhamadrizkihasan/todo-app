@extends('layout')

@section('content')
    @if (Session::get('notAllowed'))
        <div class="alert alert-danger">
            {{ Session::get('notAllowed') }}
        </div>
    @endif
    @if (Session::get('successDelete'))
        <div class="alert alert-warning">
            {{ Session::get('successDelete') }}
        </div>
    @endif
    @if (Session::get('addTodo'))
        <div class="alert alert-success">
            {{ Session::get('addTodo') }}
        </div>
    @endif
    <div class="container mt-5">
        <table class="table table-success table-striped table-bordered">
            <tr>
                <td>No</td>
                <td>Kegiatan</td>
                <td>Deskripsi</td>
                <td>Batas Waktu</td>
                <td>Status</td>
                <td>Aksi</td>
            </tr>
            @php
                $no = 1;
            @endphp
            @foreach ($todos as $todo)
                <tr>
                    {{-- tiap di looping, $no bakal ditambah 1 --}}
                    <td>{{ $no++ }}</td>
                    <td>{{ $todo['title'] }}</td>
                    <td>{{ $todo['description'] }}</td>
                    {{-- Carbon : package date pada laravel, nntinya si date yg 2022-11-22 formatnya jadi 22 November, 2022 --}}
                    <td>{{ \Carbon\Carbon::parse($todo['date'])->format('j F, Y') }}</td>
                    {{-- konsep ternary, if statusnya 1 nampilin teks complated kalo 0 nampilin teks on-process . status tuh boolean kan? cmn antara 1 atau 0 --}}
                    <td>{{ $todo['status'] == 1 ? 'Complated' : 'On-Process' }}</td>
                    <td class="d-flex">
                        {{-- Karena path {id} merupakan path dinamis, jadi kita harus isi path dinamis tersebut. Karena kita mengisinya dengan data dinamis/data dari database jadi buat isi nya pake kurung kurawal dua kali --}}
                        <div class="me-2">
                            <a href="{{ route('todo.edit', $todo['id']) }}" class="btn btn-primary">Edit</a>
                        </div>
                        {{-- Fitur delete harus menggunakan form lagi. tombol hapusnya disimpan di tag button type submit. kenapa pake form? karena kita kan mau ubah  (hapus itu masuk ke ubah data kan?), nah kalo mau ubah ubah data di database itu harus pake form --}}
                        <form action="{{ route('todo.destroy', $todo['id']) }}" method="POST" class="me-2">
                            @csrf
                            {{-- Menimpa method="POST", karena di route nya menggunakan method delete --}}
                            @method('DELETE')
                            <button type="submit" class="btn btn-warning">Hapus</button>
                        </form>
                        {{-- Button hanya ditampilkan untuk todo yang statusnya masih 0 (on-progress) --}}
                        @if ($todo['status'] == 0)
                            <form action="/complated/{{ $todo['id'] }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-success">Completed</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
