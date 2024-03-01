@extends('layout')

@section('content')

    <form action="{{route('todo.store')}}" method="post" style="max-width: 500px; margin: auto;">
        {{-- mengirim data ke controller yg ditampung oleh Request $request --}}
        @csrf
        <div class="d-flex flex-column">
            <label>Title</label>
            <input type="text" name="title">
        </div>
        <div class="d-flex flex-column">
            <label>Date</label>
            <input type="date" name="date">
        </div>
        <div class="d-flex flex-column">
            <label>Description</label>
            <textarea name="description" cols="30" rows="10"></textarea>
        </div>
        <button type="submit">Kirim</button>
    </form>
@endsection