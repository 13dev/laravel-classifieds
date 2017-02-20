<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App\User;
use Talk;
use Carbon\Carbon;


class MessagesController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
		Carbon::setLocale('pt');

	}

	public function index() {
		return view('messages.index');
	}

	
	public function Send(request $request) {
		/**
		 * Set The Auth User
		 */
		Talk::setAuthUserId(Auth::user()->id);

		$convId = $request->input('conv_id');
		$mensagem = $request->input('mensagem');

		if(!Talk::getConversationsById($convId)){
			$response->response 	= false;
			$response->error		= 'Nº Codigo: 2. Esta conversa não existe!'; 
			return response()->json($response);
		}

		if(!$request->ajax()){
			$response->response 	= false;
			$response->error 	= 'Nº Codigo: 2. Não podes acessar acessar este arquivo diretamente';
			return response()->json($response);
		}

		$response = Talk::sendMessage($convId, trim(htmlspecialchars($mensagem)));
		
		if (!$response){
			$response->response 	= false;
			$response->error 		= 'Nº Codigo: 1. Ocorreu um erro Por favor contacte a administração do site';
			return response()->json($response);
		}

		$response->response = true;
		
		return response()->json($response);
	}


	public function getInbox(request $request) 
	{
		/**
		 * Set The Auth User
		 */
		Talk::setAuthUserId(Auth::user()->id);

		$response = Talk::getInbox();

		foreach ($response as $key => $value) {
			$response[$key]->thread->time = Carbon::parse($value->thread->created_at)->diffForHumans();

		}

		if (!$response){
			unset($response);
			$response = new \stdClass();
			$response->response = false;
			$response->error 	= 'Nº Codigo: 1. Ocorreu um erro Por favor contacte a administração do site';
			return response()->json($response);
		}

		if(!$request->ajax()){
			unset($response);
			$response = new \stdClass();
			$response->response = false;
			$response->error 	= 'Nº Codigo: 2. Não podes acessar acessar este arquivo diretamente';
			return response()->json($response);
		}

		$response->response = true;

		return response()->json($response/*,200,[], JSON_PRETTY_PRINT*/);

	}
	/**
	 * Obtem as conversas da conversa selecionada
	 * @param  Request $request pedido
	 * @param  int  $convId conversa id
	 * @return json          return json 
	 */
	public function getChat(Request $request)
	{
		/**
		 * Set The Auth User
		 */
		Talk::setAuthUserId(Auth::user()->id);

		$convId = $request->input('conv_id');

		if(!$request->ajax()){
			unset($response);
			$response = new \stdClass();
			$response->response 	= false;
			$response->error 		= 'Nº Codigo: 3. Não podes acessar acessar este arquivo diretamente';
			return response()->json($response);
		}

		if(!Talk::getConversationsById($convId) || !is_numeric($convId) || empty($convId)){
			unset($response);
			$response = new \stdClass();
			$response->response 	= false;
			$response->error		= 'Nº Codigo: 2. Esta conversa não existe!'; 
			return response()->json($response);
		}

		if(!Talk::isAuthenticUser($convId, Auth::user()->id)){
			$response = new \stdClass();
			$response->response 	= false;
			$response->error		= 'Nº Codigo: 1. Não podes ver esta conversa!';
			return response()->json($response);
		}

		$response = Talk::getConversationsById($convId);

		foreach ($response->messages as $key => $value) {

			if ($response->messages[$key]->user_id == Auth::user()->id) {
				$response->messages[$key]->me = true;
			}else {
				$response->messages[$key]->me = false;
			}
			//$response->messages[$key]->me = Carbon::createFromFormat('d/m/Y h:i:s', $response->messages[$key]->created_at); 

		} 

		$response->response = true;
		return response()->json($response);
	}


	
}
