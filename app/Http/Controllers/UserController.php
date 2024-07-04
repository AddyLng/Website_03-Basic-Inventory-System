<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class UserController extends Controller //functions are located
{
    public function index(){
        return 'Hello from UserController'; 
    }

    public function login(){
        if(View::exists('user.login')){
            return view('user.login');
        }else{
            return abort(404);
            // return response()->view('errors.404');
        }
    }

    public function process(Request $request){
        $validated = $request->validate([
            "email" => ['required', 'email'],
            "password" => 'required'
        ]);

        if(auth()->attempt($validated)){
            $request->session()->regenerateToken();

            return redirect('/')->with('message', 'Welcome back!');
        }

        return back()->withErrors(['email' => 'Login Failed'])->onlyInput('email');

    }

    public function register(){
        return view('user.register');
    }

    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'Logout Sucessful');
    }

    public function store(Request $request){
        $validated = $request->validate([
            "name" => ['required', 'min:4'],
            "email" => ['required', 'email', Rule::unique('users', 'email')],
            "password" => 'required|confirmed|min:6'
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        auth()->login($user);
    }

    public function show($id){

        $data = ["data" => "data from database"]; //manually pulls a data from a certain location
        return view('user') ->with('data', $data)
                            ->with('age', 33)
                            ->with('name', 'Jake the Dog') // view(user, $data) returns to view php??
                            ->with('email', 'jakethedog@gmail.com')
                            ->with('id', $id);
                           //->with() manually directs/inputs a data from the return view
    }
}
