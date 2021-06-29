<?php

namespace App\Architecture\ViewModels;

use App\Models\Category;

class CategoryViewModel
{
    protected $id;
    protected $name;
    protected $state;

    public function __construct()
    {

    }

    public function generateViewModel(Category $model)
    {
        $this->id = $model->id;
        $this->name = $model->name;
        $this->state = $model->state;

        return $this;
    }
}
