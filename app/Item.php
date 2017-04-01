<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Item extends Model {


    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'titulo', 'descricao', 'category_id'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function images() {
        return $this->hasMany('App\ItemImages');
    }

    public function category() {
        return $this->belongsTo('App\Category', 'category_id');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable() {
        return [
            'slug' => [
                'source' => 'titulo'
            ]
        ];
    }

}
