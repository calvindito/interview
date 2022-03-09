<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {

    public function login(Request $request)
    {
        if(session('email')) {
            return redirect()->back();
        }

        if($request->_token == csrf_token()) {
            $account = User::where('email', $request->email)->first();
            if($account) {
                if(Hash::check($request->password, $account->password)) {
                    session([
                        'name'  => $account->name,
                        'email' => $account->email
                    ]);

                    return redirect('dashboard');
                }
            } else {
                return redirect()->back()->with(['failed' => 'Invalid account']);
            }
        } else {
            $data = [
                'title'   => 'Login',
                'content' => 'login'
            ];

            return view('layouts.index', ['data' => $data]);
        }
    }

    public function logout()
    {
        if(!session('email')) {
            return redirect('login');
        }

        session()->flush();
        return redirect('/')->with(['logout' => 'Telah berhasil logout']);
    }

}
