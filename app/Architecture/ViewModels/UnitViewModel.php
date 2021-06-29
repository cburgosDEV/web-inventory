<?php

namespace App\Architecture\ViewModels;

use App\Models\Unit;

class UnitViewModel
{
    protected $id;
    protected $name;
    protected $symbol;
    protected $state;

    public function __construct()
    {

    }

    public function generateViewModel(Unit $model)
    {
        $this->id = $model->id;
        $this->name = $model->name;
        $this->symbol = $model->symbol;
        $this->state = $model->state;

        return $this;
    }
}
