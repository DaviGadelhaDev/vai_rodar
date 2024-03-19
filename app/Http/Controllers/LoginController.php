<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function store(LoginRequest $request)
    {
        $request->validated();

        $credentials = $request->only('email', 'password');
        $user_authenticate = Auth::attempt($credentials);

        if(!$user_authenticate){
            Log::warning('Erro ao logar no sistema', ['email' => $request->email]);
            return back()->with('error', 'Usuário e/ou senha inválidos');
        }

        Log::info('logou no sistema', ['email' => $request->email]);
        return redirect()->route('dashboard.index');
    }

    public function create()
    {
        return view('login.create');
    }

    public function storeNewUser(LoginUserRequest $request)
    {
        $request->validated();

        try{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            Log::info('Conta cadastrada', ['email' => $request->email]);
            return redirect()->route('login.index')->with('success', 'Conta cadastrada com sucesso');
        }
       
        catch(Exception $e){
            Log::warning('Erro ao cadastrar novo usuário', ['error' => $e->getMessage()]);
            return back()->with('error', 'Erro ao cadastrar nova conta');
        }
    }

   public function destroy()
   {
    Auth::logout();
    return redirect()->route('login.index');
   }
}
