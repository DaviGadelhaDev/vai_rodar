<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Pegar os registros
        $users = User::orderBy('created_at')->paginate(10);

        return view('user.index', ['users' => $users]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUser(UserRequest $request)
    {
        $request->validated();

        // Marca o ponto inicial de uma transação
        DB::beginTransaction();
        try{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            Log::info('Usuário cadastrado', [['id' => $user->id, $user]]);

            //Operação realizada com sucesso
            DB::commit();
            return redirect()->route('user.index')->with('success', 'Usuário cadastrado!!');
        }
        catch(Exception $e){
            Log::warning('Erro ao cadastrar usuário', ['erro' => $e->getMessage()]);
            return redirect()->route('user.create')->with('error', 'Erro ao cadastrar usuário!!');
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('user.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ],
        [
            'name.required' => 'O campo nome é obrigatório',
            'email.required' => 'E-mail é obrigatório',
            'email.email' => 'E-mail inválido',
            'email.unique' => 'E-mail já existe no sistema',
        ]);
        // Marca o ponto inicial de uma transação
        DB::beginTransaction();
        try{

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            Log::info('Usuário editado com sucesso', ['user' =>$user->id]);
            DB::commit();
            return redirect()->route('user.index')->with('success', 'Usuário alterado com sucesso!!');
        }
        catch(Exception $e){
            Log::warning('Erro ao editar o usuário', ['erro' => $e->getMessage()]);
            return redirect()->route('user.create')->with('error', 'Erro ao editar o usuário!!');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
