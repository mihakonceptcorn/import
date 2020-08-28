<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'rubric_id',
        'sub_rubric_id',
        'category_id',
        'manufacturer',
        'name',
        'code',
        'description',
        'price',
        'guarantee',
        'availability',
    ];

    public function category()
    {
        $this->belongsTo(Category::class);
    }

    public function rubrics()
    {
        return $this->belongsToMany(Rubric::class);
    }
}
