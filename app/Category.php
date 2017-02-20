<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use DB;

class Category extends Model
{
	public $fillable = ['title','parent_id'];
	
	// identa a tree criada por getAllCHilds()
	private $levelIdentifier = "&nbsp;&nbsp;";

	// so para criar a tree de categorias!
    private $itemPointer = "|-"; 

    // guarda todos os filhos 
    private $allChilds = [];

    // guarda o caminho de um item!
    private $itemPath = [];

   /**
     * Get the index name for the model.
     *
     * @return string
    */
    public function childs() {
        return $this->hasMany('App\Category','parent_id','id');
    }

    /**
     * Obtem um filho de cada vez
     * @param  integer $parent_id este parametro é o parent_id do pretendido
     * @return collection     retorna o filho
     */
	public static function getImmediateChilds($parent_id){
		$childs = DB::table('categories')->where('parent_id',$parent_id)->orderBy('id')->get();
		
		return $childs;	
	}

	/**
	 * obtem a lista de categoriasd
	 * @param  integer $parent_id       id do parente
	 * @param  string  $levelIdentifier indentificador do nivel
	 * @param  boolean $start           V - retorna | F - não retorna
	 * @return collection                   
	 */
	public function getAllChilds($parent_id, $levelIdentifier="", $start= true) { 
		
		$immediate_childs = $this->getImmediateChilds($parent_id);

		if(count($immediate_childs)) {
			foreach($immediate_childs as $chld) {
				$chld->title = $levelIdentifier . $this->itemPointer. $chld->title;
				array_push($this->allChilds,$chld);

				$this->getAllChilds($chld->id, ($levelIdentifier . $this->levelIdentifier), false);
			}
		}
		if($start) {
			return $this->allChilds; 
		}
	}

	public function getItemPath($item_id, $start = true){ 
		if($item_id != 0) {
			$item = DB::table('categories')->where('id', $item_id);
			$itemdata = $item->first();
			if ($item->count() == 0) {
				return false;
			}else {
				array_push($this->itemPath,$itemdata); 
		
				if($itemdata->parent_id != 0) {
					$this->itemPath = $this->getItemPath($itemdata->parent_id, false);
				} 
				if ($start) {
					$this->itemPath = array_reverse($this->itemPath);
				}	
			}

		
		}
		return $this->itemPath;
		
	} 

	public function deleteItem($id){
		
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

}