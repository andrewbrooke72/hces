<?php

namespace HCES\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Flysystem\Exception;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.welcome.index');
    }

    public function authenticate(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required',
                'password' => 'required',
            ]);
            $data = $request->all();
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect()->intended(route('home.index'));
            } else {
                $request->session()->flash('status_error', 'Failed to login! Username and password does not match!');
                return redirect()->back();
            }
        } catch (Exception $exception) {
            $request->session()->flash('exception', $exception->getMessage());
            return redirect()->back();
        }
    }

    public function unauthenticate()
    {
        Auth::logout();
        return redirect('/');
    }
}
