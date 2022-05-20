<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {

    public function login(Request $request)
    {
        if(session('id')) {
            return redirect('dashboard');
        }

        if($request->has('_token')) {
            if($request->_token == csrf_token()) {
                $data = User::where('username', $request->username)->first();
                if($data) {
                    if(Hash::check($request->password, $data->password)) {
                        session([
                            'id'       => $data->id,
                            'name'     => $data->name,
                            'username' => $data->username
                        ]);

                        return redirect('dashboard');
                    } else {
                        return redirect()->back()->with(['failed' => 'Akun tidak terdaftar']);
                    }
                } else {
                    return redirect()->back()->with(['failed' => 'Akun tidak terdaftar']);
                }
            }
        }

        return view('login');
    }

    public function register(Request $request)
    {
        if(session('id')) {
            return redirect('dashboard');
        }

        if($request->has('_token')) {
            if($request->_token == csrf_token()) {
                $validation = Validator::make($request->all(), [
                    'name'     => 'required',
                    'username' => 'required|min:5|unique:users,username',
                    'password' => 'required'
                ], [
                    'name.required'     => 'Nama tidak boleh kosong',
                    'username.required' => 'Username tidak boleh kosong',
                    'username.min'      => 'Username minimal 5 karakter',
                    'username.unique'   => 'Username telah dipakai',
                    'password.required' => 'Password tidak boleh kosong'
                ]);

                if($validation->fails()) {
                    return redirect()->back()->withErrors($validation)->withInput();
                } else {
                    $query = User::create([
                        'name'     => $request->name,
                        'username' => $request->username,
                        'password' => Hash::make($request->password)
                    ]);

                    if($query) {
                        return redirect('/')->with(['success' => 'Anda telah terdaftar, silahkan login.']);
                    } else {
                        return redirect()->back()->with(['error' => 'Gagal mendaftar']);
                    }
                }
            }
        }

        return view('register');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }

}
