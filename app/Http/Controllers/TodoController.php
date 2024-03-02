<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function registerAccount(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email:dns',
            'username' => 'required|min:4|max:8',
            'password' => 'required|min:4',
            'name' => 'required|min:3'
        ]);

        // Input data ke db
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Redirect kemana setelah berhasil tambah data + dikirim pemberintahuan
        return redirect('/')->with('success', 'Berhasil menambahkan akun! silahkan login');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required',
        ], [
            'username.exists' => "This username doesn't exists"
        ]);

        $user = $request->only('username', 'password');
        if (Auth::attempt($user)) {
            return redirect()->route('todo.index');
        } else {
            return redirect('/')->with('fail', "Gagal login, periksa dan coba lagi!");
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data pada table todos melalui model Todo
        // Data yang diambil merupakan data yang telah di filter berdasarkan user_id (data yang berhasil diambil merupakan data todo yang dibuat oleh id yang sama dengan id user yang loginnya
        $todos = Todo::where('user_id', '=', Auth::user()->id)->get();

        return view('todos.index', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan halaman input form tambah data
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi form
        $request->validate([
            'title' => 'required|min:3',
            'date' => 'required',
            'description' => 'required|min:3'
        ]);

        // Kirim data ke database yang table todos : model Todo
        // Yang ' ' = nama column
        // Yang $request-> = value name di input
        // Kenapa kirim 5 data padahal di input ada 3 inputan? Kalau dicek di table todos itu kan ada 6 column yang harus diisi, salah satunya column done_date yang nullable, kalu nullable itu gausa diisi gpp jadi ga diisi dulu
        // user_id ngambil id dari fitur auth (history login), supaya tau itu todo punya siapa
        // Colomn status kan boolean, jadi kalo status si todo belum dikerjain = 0
        Todo::create([
            'title' => $request->title,
            'date' => $request->date,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            'status' => 0,
        ]);

        // Kalau berhasil tambah ke db, bakal diarahin ke halaman dashboard dengan menampilkan pemberitahuan
        return redirect()->route('todo.index')->with('addTodo', 'Berhasil menambahkan data Todo!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        //
    }
}
