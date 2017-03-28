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
        $response->temp = $this->getUnreadMessages($response->code);
        //$response->code->thread->is_seen  = 1;
        foreach ($response->code as $key => $value) {
            $response->code[$key]->thread->time = Carbon::parse($value->thread->created_at)->diffForHumans();
            //Adiciona a Key unreadMessages!
            foreach ($response->temp['code'] as $k => $v) {
                if($value->thread->conversation_id == $v['convId']){
                    $response->code[$key]->thread->unreadMessages = $v['count'];
                }
                
            }
        }

        //Numero geral de mensagens não lidas
        $response->totalCount = $response->temp['totalCount'];

        /**
          * = 0 Não tem mensagens novas
          * = 1 Tem mensagens novas
          */
        $response->countStatus = $response->temp['countStatus'];

        //eliminamos o objeto temporario
        unset($response->temp);

        if (!$response->code) {
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
    public function getChat(Request $request, $see = true) {
        /**
         * Set The Auth User
         */
        Talk::setAuthUserId(Auth::user()->id);

        $convId = $request->input('conv_id');
        $response = new \stdClass();
        
        if (!$request->ajax()) {
            unset($response);
            $response = new \stdClass();
            $response->response = false;
            $response->error = 'Nº Codigo: 3. Não podes acessar acessar este arquivo diretamente';
            return response()->json($response);
        }
        
        if (!Talk::getConversationsById($convId) || !is_numeric($convId) || empty($convId)) {
            unset($response);
            $response = new \stdClass();
            $response->response = false;
            $response->error = 'Nº Codigo: 2. Esta conversa não existe!';
            return response()->json($response);
        }

        if (!Talk::isAuthenticUser($convId, Auth::user()->id)) {
            $response = new \stdClass();
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

            // Marcar como visto todas as mensagens
            if($value->is_seen == 0 && !$value->me){
                Talk::makeSeen($value->id);
            }
        }

        $response->response = true;
        return response()->json($response);
    }

    private function getUnreadMessages($inbox){
        /**
         * Set The Auth User
         */
        Talk::setAuthUserId(Auth::user()->id);
        $response = new \stdClass();
        $response->temp = $inbox;

        $_response = [];
        $count = 0;
        foreach ($response->temp as $c => $v) {
            
            $conv = Talk::getConversationsById($v->thread->conversation_id)->messages;
            $_response['code'][$c]['convId'] = $v->thread->conversation_id;
            $_response['code'][$c]['count'] = 0;
            foreach ($conv as $m) {
                if(!$m->is_seen && $m->user_id != Auth::user()->id){
                    $_response['code'][$c]['count']++;
                    $count++;
                }
            } 
        }
        // eliminamos o response temporario
        unset($response);

        //Total de Mensagens novas
        $_response['totalCount'] = $count;

        /**
          * = 0 Não tem mensagens novas
          * = 1 Tem mensagens novas
          */
        if($count == 0){
            $_response['countStatus'] = 0; // Não tem mensagens!
        }elseif ($count > 0) {
            $_response['countStatus'] = 1; // tem mensagens!
        }
        return $_response;

    }

}
