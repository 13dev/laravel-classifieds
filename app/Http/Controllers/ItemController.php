<?php

namespace App\Http\Controllers;

use Auth;
use Cache;
use App\Item;
use App\User;
use App\Category;
use App\ItemImages;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'show']);
    }

    public function show($slug)
    {
        $slug = Item::where('slug', $slug)->first();
        if ($slug != null && ! empty($slug)) {
            return view('items.show')
                            ->with('item', $slug);
        } else {
            return redirect('/');
        }
    }

    public function getMyItems()
    {
        $items = Item::where('user_id', Auth::user()->id);
        $itemsPagin = $items->paginate(10);
        $items = $items->get();

        return view('items.myitems')
                        ->with(compact('items', 'itemsPagin'));
    }

    public function create(Category $categories, $category = null)
    {
        if (is_null($category) || ! is_numeric($category)) {
            return view('items.selectCategory');
        }
        if ($categories->haveChilds($category)) {
            return view('items.selectCategory');
        }

        /*
         * $allCategoriesSelect = [];
          foreach ($categories->getAllChilds(0) as $key => $value){
          $allCategoriesSelect[$key]['value'] = $value->id;
          $allCategoriesSelect[$key]['title'] = $value->title;
          }
         */
        $forEachItemPath = $categories->getItemPath($category);
        $itemPath = '';
        foreach ($forEachItemPath as $key => $value) {
            if (empty($itemPath[$key + 1])) {
                $itemPath .= $value->title;
            } else {
                $itemPath .= ' / '.$value->title;
            }
        }

        return view('items.create', compact('category', 'itemPath'));
    }

    /**
     * Cria Anuncio Com os dados recebidos.
     * @param  request $request Obtem dados
     * @return bool
     */
    public function store(Category $categories, Request $request)
    {
        $category = $request->input('category_id');

        if ($categories->haveChilds($category)) {
            return redirect('/')
                    ->with(session()->flash('message-error', trans('messages.errors.category.havechilds')));
        }
        /**
         * Valida os valores introduzidos.
         * @var bool
         */
        $validate = [
            'titulo' => 'min:10|max:70',
            'descricao' => 'min:30|max:700',
            'images.*' => 'mimes:jpg,jpeg,png|max:4072',
            'category_id' => 'required|min:1|numeric',
        ];

        $countImages = count($request->file('images'));

        if ($countImages > config('Images.maxFilesAllow')) {
            return back()->with(session()->flash('message-error', trans('messages.errors.files.maxFilesAllow')));
        }

        $this->validate($request, $validate);

        /**
         * Multi Upload de Imagens !
         * Transformando-o em unico Array !
         * @Autor 13 :D
         */
        $imagens = [];
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $imagem = hash('ripemd160', uniqid()).'.'.$extension;
                $destinationPath = base_path().'/public/content/anuncios';
                $file->move($destinationPath, $imagem);
                $imagens[]['path'] = $imagem;
            }
        }
        //dd($imagens);
        /**
         * Obtem so os dados necessarios.
         * @var array
         */
        $fields = [
            'titulo' => htmlspecialchars($request->input('titulo')),
            'descricao' => htmlspecialchars($request->input('descricao')),
            'user_id' => Auth::user()->id,
            'category_id' => $request->input('category_id'),
        ];
        /**
         * Limpa Array removendo campos nulos e campos = 0.
         */
        $fields = array_filter($fields, 'strlen');
        $fields = array_filter($fields, 'trim');
        /**
         * $item Cria item.
         * @var bool
         */
        $item = Item::create($fields);
        /**
         * [$imagens Adiciona indeces para preecher tabela itemItems].
         * @var array
         */
        $imagens = array_map('array_filter', $imagens);
        foreach ($imagens as $imagem => $value) {
            $imagens[$imagem]['item_id'] = $item->id;
        }

        $ItemImages = ItemImages::insert($imagens);

        return redirect('/')
                        ->with(session()->flash('message', trans('messages.success.anuncio.create')));
    }

    public function selectCategory(Request $request)
    {
        if (! $request->ajax()) {
            $response = new \stdClass();
            $response->response = false;
            $response->error = 'Nº Codigo: 2. Não podes acessar acessar este arquivo diretamente';

            return response()->json($response);
        }
        //Cache::forget('getImmediateChilds');

        $child = $request->input('childs');

        $categories = Cache::remember('categories', 180, function () {
            return new Category;
        });

        Cache::add('category-havechilds-'.$child, $categories->haveChilds($child), 180);

        $haveChild = Cache::get('category-havechilds-'.$child);
        $response = new \stdClass();
        if ($haveChild) {
            Cache::add('category-getchilds-'.$child, $categories->getImmediateChilds($child), 180);

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
