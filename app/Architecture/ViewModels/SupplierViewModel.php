<?php

namespace App\Architecture\ViewModels;

use App\Models\Supplier;

class SupplierViewModel
{
    protected $id;
    protected $name;
    protected $dni;
    protected $ruc;
    protected $phone;
    protected $address;
    protected $state;
    protected $idTypePerson;

    public function __construct()
    {

    }

    public function generateViewModel(Supplier $model)
    {
        $this->id = $model->id;
        $this->name = $model->name;
        $this->dni = $model->dni;
        $this->ruc = $model->ruc;
        $this->phone = $model->phone;
        $this->address = $model->address;
        $this->state = $model->state;
        $this->idTypePerson = $model->idTypePerson;

        return $this;
    }
}
