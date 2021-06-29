<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypePerson extends Model
{
    protected $table = 'type_person';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'state',
    ];
}
