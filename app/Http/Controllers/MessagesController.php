<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\User;
use Talk;
use Carbon\Carbon;

class MessagesController extends Controller {

    public function __construct() {
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
        $response = new \stdClass();

        if (!Talk::getConversationsById($convId)) {
            unset($response);
            $response->response = false;
            $response->error = 'Nº Codigo: 2. Esta conversa não existe!';
            return response()->json($response);
        }

        if (!$request->ajax()) {
            unset($response);
            $response->response = false;
            $response->error = 'Nº Codigo: 2. Não podes acessar acessar este arquivo diretamente';
            return response()->json($response);
        }

        $response->code = Talk::sendMessage($convId, trim(htmlspecialchars($mensagem)));

        if (!$response->code) {
            $response->response = false;
            $response->error = 'Nº Codigo: 1. Ocorreu um erro Por favor contacte a administração do site';
            return response()->json($response);
        }
        $response->response = true;

        return response()->json($response);
    }

    public function getInbox(request $request) {
        /**
         * Set The Auth User
         */
        Talk::setAuthUserId(Auth::user()->id);
        $response = new \stdClass();
        $response->code = Talk::getInbox();

        foreach ($response->code as $key => $value) {
            $response->code[$key]->thread->time = Carbon::parse($value->thread->created_at)->diffForHumans();
        }

        if (!$response) {
            unset($response);
            $response->response = false;
            $response->error = 'Nº Codigo: 1. Ocorreu um erro Por favor contacte a administração do site';
            return response()->json($response);
        }

        if (!$request->ajax()) {
            unset($response);
            $response->response = false;
            $response->error = 'Nº Codigo: 2. Não podes acessar acessar este arquivo diretamente';
            return response()->json($response);
        }

        $response->response = true;
        return response()->json($response/* ,200,[], JSON_PRETTY_PRINT */);
    }

    /**
     * Obtem as conversas da conversa selecionada
     * @param  Request $request pedido
     * @param  int  $convId conversa id
     * @return json          return json 
     */
    public function getChat(Request $request) {
        /**
         * Set The Auth User
         */
        Talk::setAuthUserId(Auth::user()->id);

        $convId = $request->input('conv_id');
        $response = new \stdClass();
        
        if (!$request->ajax()) {
            unset($response);
            $response->response = false;
            $response->error = 'Nº Codigo: 3. Não podes acessar acessar este arquivo diretamente';
            return response()->json($response);
        }
        
        if (!Talk::getConversationsById($convId) || !is_numeric($convId) || empty($convId)) {
            unset($response);
            $response->response = false;
            $response->error = 'Nº Codigo: 2. Esta conversa não existe!';
            return response()->json($response);
        }

        if (!Talk::isAuthenticUser($convId, Auth::user()->id)) {
            $response->response = false;
            $response->error = 'Nº Codigo: 1. Não podes ver esta conversa!';
            return response()->json($response);
        }

        $response->code = Talk::getConversationsById($convId);

        foreach ($response->code->messages as $key => $value) {

            if ($response->code->messages[$key]->user_id == Auth::user()->id) {
                $response->code->messages[$key]->me = true;
            } else {
                $response->code->messages[$key]->me = false;
            }
            //$response->messages[$key]->me = Carbon::createFromFormat('d/m/Y h:i:s', $response->messages[$key]->created_at); 
        }

        $response->response = true;
        return response()->json($response);
    }

}
