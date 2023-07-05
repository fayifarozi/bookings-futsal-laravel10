<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(){
        return view('login');
    }
    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = User::where('email','=',$request->email)->first();
        if(auth()->attempt(array('email' => $request->email, 'password'=> $request->password))){
            if(auth()->user()->level=='admin'){
                // dd(auth()->user()->level=='admin');
                session()->put('level', auth()->user()->level);
                session()->put('name', auth()->user()->name);
                session()->put('id', auth()->user()->user_id);
                session()->put('img', auth()->user()->image);
                $toastMessage = [
                    'type' => 'Success',
                    'message' => 'Login Success'
                ];
                Session::flash('toast', $toastMessage);
                return redirect()->route('dasboard');
            }else{
                $toastMessage = [
                    'type' => 'error',
                    'message' => 'E-mail atau Kata Sandi Anda Salah'
                ];
                Session::flash('toast', $toastMessage);
                // return redirect(route('fields'));
                return back();
            }
        }else{
            $toastMessage = [
                'type' => 'error',
                'message' => 'Anda tidak terdaftar'
            ];
            Session::flash('toast', $toastMessage);
            return back();
        }
    }
    public function logout(Request $request){
        // dd('nnansdoanosd'); 
        Session::flush();
        return redirect()->route('login');
    }
}