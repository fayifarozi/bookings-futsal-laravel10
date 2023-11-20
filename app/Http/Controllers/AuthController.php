<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function index(){
        // dd(Hash::make('123'));
        return view('login');
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = auth()->attempt($request->only('email', 'password'));
        
        if ($credentials) {
            $user = auth()->user();
            if($user->level == 'admin' || $user->level == 'employee' ){
                session()->put('level', auth()->user()->level);
                session()->put('name', auth()->user()->name);
                session()->put('id', auth()->user()->user_id);
                session()->put('img', auth()->user()->image);
                $toastMessage = [
                    'type' => 'success',
                    'message' => 'Login Success'
                ];
                Session::flash('toast', $toastMessage);
                return redirect()->route('dasboard');
            }else{
                $toastMessage = [
                    'type' => 'error',
                    'message' => 'Anda tidak terdaftar'
                ];
                Session::flash('toast', $toastMessage);
                return back();
            }
        }else{
            $toastMessage = [
                'type' => 'error',
                'message' => 'E-mail atau Kata Sandi Anda Salah'
            ];
            Session::flash('toast', $toastMessage);
            return back();
        }
    }
    public function logout(Request $request){
        Session::flush();
        return redirect()->route('login');
    }
}