<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Item;
use App\ItemImages;
use Auth;

class AnuncioController extends Controller
{
    public function __construct () {
    	$this->middleware('auth', ['except' => 'show']);
        
    }


    public function show($slug) {
    	$slug = Item::where('slug', $slug)->first();
    	if ($slug != NULL && !empty($slug)) {

    		return view('anuncios.show')
    				->with('item', $slug);
    	}else {
    		return redirect('/');
    	}
    }
    public function getCriar() {
        //dd(\Auth::user()->id);
        return view('anuncios.create');
    }


    /**
     * Cria Anuncio Com os dados recebidos 
     * @param  request $request Obtem dados
     * @return boolean       
     */
    public function postCriar(request $request) {
        /**
         * Valida os valores introduzidos
         * @var boolean
         */
        $regras = [
            'titulo'    => 'max:70',
            'descricao' => 'max:700',
            'images.*'  => 'mimes:jpg,jpeg,png|max:4072',
        ];

        $count_images = count($request->file('images'));

        if ($count_images > config('Images.maxFilesAllow')) {
            return back()->with(session()->flash('message-error',trans('messages.errors.files.maxFilesAllow')));
        }
       /*$count_images = count($request->file('images')) - 1;
        foreach(range(0, $count_images) as $index) {
            $regras['images.' . $index] = 'mimes:exe|max:3072';
        } */
        $this->validate($request,$regras);
        //dd($regras);
        /**
         * 
         * Multi Upload de Imagens !
         * Transformando-o em unico Array !
         * @Autor 13 :D
         * 
         */
        $imagens = [];
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach($files as $file){
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $imagem = hash('ripemd160',uniqid()).'.'.$extension;
                $destinationPath = base_path() . '/public/content/anuncios';
                $file->move($destinationPath, $imagem);
                $imagens[]['path'] = $imagem;
            }

        }
        //dd($imagens);
        /**
         * Obtem so os dados necessarios
         * @var Array
         */
        $campos = [
            'titulo' => htmlspecialchars($request->input('titulo')),
            'descricao' => htmlspecialchars($request->input('descricao')),
            'user_id' => Auth::user()->id,
        ];
        /**
         * Limpa Array removendo campos nulos e campos = 0
         */
        $campos = array_filter($campos, 'strlen');
        $campos = array_filter($campos, 'trim');
        /**
         * $item Cria item
         * @var Boolean
         */
        $item = Item::create($campos);
        /**
         * [$imagens Adiciona indeces para preecher tabela itemItems]
         * @var array
         */
        $imagens = array_map('array_filter',$imagens);
        foreach ($imagens as $imagem => $value) {
            $imagens[$imagem]['item_id'] = $item->id;
        }

        $ItemImages = ItemImages::insert($imagens);

        return redirect('/a/criar/anuncio')
                ->with(session()->flash('message', trans('messages.success.anuncio.create'))); 
        //dd($imagens);

        /*foreach ($imagens as $imagem => $value) {
            if (isset($imagens[$imagem]['path'])) {
                if ($imagens[$imagem]['path'] == '' || is_null($imagens[$imagem]['path']) ||
                    $imagens[$imagem]['item_id'] == '' || is_null($imagens[$imagem]['item_id'])) {
                    unset($imagens[$imagem]);
                }
            }else {
                unset($imagens[$imagem]);
            }
           
        } */
        
       /* if (!empty($product['images'])) {
            $product['images'] = $picture;
        } else {
            unset($product['images']);
        } */


        //$item->id;
    }

}
