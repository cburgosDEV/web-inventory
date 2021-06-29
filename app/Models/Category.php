<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'state',
    ];

    public function scopeFiltersToCategoryIndex($query, $filters)
    {
        $query->where('category.name', 'like', '%' . $filters . '%');
    }
}
