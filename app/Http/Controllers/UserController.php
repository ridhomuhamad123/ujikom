<?php

namespace App\Http\Controllers;

use App\Models\detail_sales;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function loginpage()
    {
        return view('welcome');
    }

        public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ],[
            'email.required' => 'silahkan isi email',
            'password.required' => 'silahkan isi password',
        ]);

        $cekLogin = [
            'email' => $request->email,
            'password'=>$request->password,
        ];

        if(Auth::attempt($cekLogin)){
            // $role = Auth::user();
            // if ($role->role == 'admin') {
            //     return redirect()->route('dashboard.admin');
            // }
            // if ($role->role == 'petugas') {
            //     return redirect()->route('dashboard.petugas');
            // }
            return redirect()->route('dashboard')->with('success', 'login succes');
        }else {
            return redirect()->back()->withErrors(['login_failed' => 'Proses login gagal, silakan coba lagi dengan data yang benar!'])->withInput();
        };
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('logout', 'Anda telah berhasil logout!');
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

        public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,petugas',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email',
            'role'     => 'required|in:admin,petugas',
            'password' => 'nullable|string|min:6'
        ]);

        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui');
    }

    public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
}

}