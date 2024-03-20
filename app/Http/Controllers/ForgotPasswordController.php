<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('login.forgotPassword');
    }

    public function storePassword(Request $request)
    {
         $request->validate([
            'email' =>'required|email',
        ], [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Necessário enviar e-mail válido.'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            Log::warning('Tentativa recuperar senha com e-mail não cadastrado.', ['email' => $request->email]);
            return back()->withInput()->with('error', 'E-mail não encontrado!');
        }
        
        try{
            // Salvar o token recuperar senha e enviar e-mail
            $status = Password::sendResetLink(
                $request->only('email')
            );
            
            Log::info('Recuperar senha', ['resposta' => $status, 'email' => $request->email]);
            return redirect()->route('login.index')->with('success', 'Enviado e-mail com instruções para recuperar a senha.');
        } 
        catch (Exception $e){
            Log::warning('Erro recuperar senha.', ['error' => $e->getMessage(), 'email' => $request->email]);
            return back()->withInput()->with('error', 'Erro: Tente mais tarde!');
        }
    }

    public function showResetPassword(Request $request)
    {
        return view('login.resetPassword', ['token' => $request->token]);
    }

    public function submitResetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ], 
        [
            'email.required' => 'E-mail é obrigatório.',
            'email.email' => 'E-mail inválido.',
            'password.required' => 'Senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo :min caracteres.',
            'password.confirmed' => 'O campo senha de confirmação não confere.'
        ]);

        try{
           $status = Password::reset(
            $request->only('email', 'password', 'confirm_password', 'token'),
            function (User $user, string $password){
                //forceFill força a inserção da informação mesmo que não esteja na model
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);
                $user->save();
            }
        );
        Log::info('Senha atualizada', ['resposta' => $status, 'email' => $request->email]);
        return $status === Password::PASSWORD_RESET ? redirect()->route('login.index')->with('success', 'Senha atualizada!!') : back()->with(['error' => 'Erro ao atualizar a senha!!']);
        }
        catch(Exception $e){
            Log::warning('Erro ao atualizar senha', ['email' => $request->email, 'erro' => $e->getMessage()]);
            return back()->with('error', 'Erro ao atualizar senha!!');
        }
    }
}
