<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;

class ChatController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }

    public function show(Chat $chat)
    {
        abort_unless($chat->users->contains(auth()->id()), 403);

	    return view('chat', [
            'chat' => $chat
        ]);
    }

    public function chat_with(User $user)
    {
	// Primero recuperamos al usuario que realiza la solicitud
	$user_a = auth()->user();
 
	// Usuario con el que deseamos chatear
	$user_b = $user;
 
	// Vamos a recuperar la sala de chat del usuario a que también tenga al usuario b
	$chat = $user_a->chats()->whereHas('users', function ($q) use ($user_b) {
 
		// Aquí buscamos la relación con el usuario b
		$q->where('chat_user.user_id', $user_b->id);
 
	})->first();
 
	// Si la sala no existe debemos crearla
	if(!$chat)
	{
 
		// La sala no tiene ningún parámetro
		$chat = \App\Models\Chat::create([]);
 
		// Después adjuntamos a ambos usuarios
		$chat->users()->sync([$user_a->id, $user_b->id]);
 
	}
 
	// Redireccionamos al usuario a la ruta chat.show
	return redirect()->route('chat.show', $chat);
    }

	public function get_users(Chat $chat) 
	{
		$users = $chat->users;
	
		return response()->json([
			'users' => $users
		]);
	}

	public function get_messages(Chat $chat) 
	{
	 
		$messages = $chat->messages()->with('user')->get();
	 
		return response()->json([
			'messages' => $messages
		]);
	 
	}	
}
