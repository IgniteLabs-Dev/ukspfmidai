<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function indexRegister()
    {
        return view('pages.auth.register');
    }
    public function indexLogin(Request $request)
    {
        $token = $request->bearerToken() ?? $request->cookie('token');

        if ($token) {
            return redirect()->route('dashboard');
        } else {
            return view('pages.login');
        }
    }


    public function loginStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/login')->with('error', 'NIP dan password wajib di isi');
        }

        $credentials = $request->only('nip', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {

                return redirect('/login')->with('error', 'NIP dan password tidak sesuai');
            }
        } catch (JWTException $e) {

            return redirect('/login')->with('error', 'Silahkan ulang kembali');
        }

        $cookie = $this->getCookieWithToken($token);

        return redirect()->route('dashboard')->withCookie($cookie);
    }

    public function logout(Request $request)
    {
        $cookie = Cookie::forget('token');
        return redirect('/')->withCookie($cookie);
    }



    protected function getCookieWithToken($token)
    {
        return cookie(
            'token',
            $token,
            15760,
            null,
            null,
            false,
            true,
            false,
            'Strict'
        );
    }
}
