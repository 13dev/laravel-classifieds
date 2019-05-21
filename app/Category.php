<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $fillable = ['title', 'parent_id'];
    // identa a tree criada por getAllCHilds()
    private $levelIdentifier = '&nbsp;&nbsp;';
    // so para criar a tree de categorias!
    private $itemPointer = '|-';
    // guarda todos os filhos
    private $allChilds = [];
    // guarda o caminho de um item!
    private $itemPath = [];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function childs()
    {
        return $this->hasMany('App\Category', 'parent_id', 'id');
    }

    public function items()
    {
        return $this->hasMany('App\Item', 'category_id');
    }

    /**
     * Obtem um filho de cada vez.
     * @param  int $parent_id este parametro é o parent_id do pretendido
     * @return collection     retorna o filho
     */
    public static function getImmediateChilds($parent_id)
    {
        $childs = DB::table('categories')->where('parent_id', $parent_id)->orderBy('id')->get();

        return $childs;
    }

    /**
     * obtem a lista de categoriasd.
     * @param  int $parent_id       id do parente
     * @param  string  $levelIdentifier indentificador do nivel
     * @param  bool $start           V - retorna | F - não retorna
     * @return collection
     */
    public function getAllChilds($parent_id, $levelIdentifier = '', $start = true)
    {
        $immediateChilds = $this->getImmediateChilds($parent_id);

        if (count($immediateChilds)) {
            foreach ($immediateChilds as $chld) {
                $chld->title = $levelIdentifier.$this->itemPointer.$chld->title;
                array_push($this->allChilds, $chld);
                $this->getAllChilds($chld->id, ($levelIdentifier.$this->levelIdentifier), false);
            }
        }
        if ($start) {
            return $this->allChilds;
        }
    }

    public function getItemPath($item_id, $start = true)
    {
        if ($item_id != 0) {
            $item = DB::table('categories')->where('id', $item_id);
            $itemdata = $item->first();
            if ($item->count() == 0) {
                return false;
            } else {
                array_push($this->itemPath, $itemdata);

                if ($itemdata->parent_id != 0) {
                    $this->itemPath = $this->getItemPath($itemdata->parent_id, false);
                }
                if ($start) {
                    $this->itemPath = array_reverse($this->itemPath);
                }
            }
        }

        return $this->itemPath;
    }

    public function deleteItem($id)
    {
        $immediate_childs = $this->getAllChilds($id);
        foreach ($immediate_childs as $key => $value) {
            $item = DB::table('categories')->where('id', $value->id)->delete();
            if ($item == 0) {
                return false;
            }
        }
        $item = DB::table('categories')->where('id', $id)->delete();
        if ($item == 0) {
            return false;
        }

        return true;
    }

    public function haveChilds($id)
    {
        $immediateChilds = $this->getAllChilds($id);
        if (empty($immediateChilds)) {
            return false;
        }

        return true;
    }
}
