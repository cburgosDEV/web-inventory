<?php

namespace App\Architecture\ViewModels;

use App\Models\Expense;

class ExpenseViewModel
{
    protected $id;
    protected $name;
    protected $amount;
    protected $state;

    public function __construct()
    {

    }

    public function generateViewModel(Expense $model)
    {
        $this->id = $model->id;
        $this->name = $model->name;
        $this->amount = $model->amount;
        $this->state = $model->state;

        return $this;
    }
}
