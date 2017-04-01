<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Cache;

class CategoriesController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getChilds(Request $request) {

        if (!$request->ajax()) {
            $response = new \stdClass();
            $response->response = false;
            $response->error = 'Nº Codigo: 2. Não podes acessar acessar este arquivo diretamente';
            return response()->json($response);
        }
        //Cache::forget('getImmediateChilds');

        $child = $request->input('childs');
        
        $categories =  Cache::remember('categories', 180, function () {
            return (new Category);
        });

        Cache::add('category-havechilds-'.$child, $categories->haveChilds($child), 180);

        $haveChild = Cache::get('category-havechilds-'.$child);
        $response = new \stdClass();
        if ($haveChild) {
            Cache::add('category-getchilds-'.$child,$categories->getImmediateChilds($child), 180);
            
            //if (!Cache::has('getImmediateChilds-')) {
               // Cache::put('getImmediateChilds-',$categories->getImmediateChilds(0), 180);
            
            $response->code = Cache::get('category-getchilds-'.$child);
            $response->response = true;
            $response->haveChilds = true;
            return response()->json($response);
        }
        $response->response = true;
        $response->haveChilds = false;
        return response()->json($response);
    }

}
