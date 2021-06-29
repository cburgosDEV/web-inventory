<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'symbol',
        'state'
    ];

    public function scopeFiltersToUnitIndex($query, $filters)
    {
        $query->where('unit.name', 'like', '%' . $filters . '%')
            ->orWhere('unit.symbol', 'like', '%' . $filters . '%');
    }
}
