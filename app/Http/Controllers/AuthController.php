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
            return redirect()->route('index');
        } else {
            return view('pages.login');
        }
    }

    public function registerStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:5',
            'email'    => 'required|email|unique:users',
            'name'     => 'required',
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        $user = User::create([
            'password' => bcrypt($request->password),
            'email'    => $request->email,
            'name'     => $request->name,
            'role'     => 'ADMIN',
            'status'     => 'active',
            'jabatan'     => '1',
            'atasan_langsung'     => '1',
            'atasan_atasan_langsung'     => '1',
        ]);

        return redirect()->route('login');
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

        return redirect()->route('index')->withCookie($cookie);
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
