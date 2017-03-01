<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Category;

class CategoriesController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function manageCategory(Category $category)
    {
        Cache::add('category-getallChilds', $category->getAllChilds(0), 180);
        $allCategories = Cache::get('category-getallChilds');
        
        $allCategoriesSelect = [];
        foreach ($allCategories as $key => $value) {
            $allCategoriesSelect[$key]['title'] = $value->title;
            $allCategoriesSelect[$key]['value'] = $value->id;
        }
        //dd($allCategoriesSelect);
        return view('categories.index',compact('allCategories','allCategoriesSelect'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function addCategory(Request $request)
    {
        $this->validate($request, [
        		'title' => 'required',
        ]);

        $input = $request->all();
        $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
        
        Category::create($input);
        return back()->with('success', 'Nova categoria adicionada!');
    }

    public function deleteCategory(Request $request, Category $category)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        $input = $request->all();
        if(!empty($input['id'])){
            $category->deleteItem($input['id']);
        }
        
        return back()->with('success', 'Categoria removida!');
    }
}
