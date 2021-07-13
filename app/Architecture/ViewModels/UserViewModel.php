<?php

namespace App\Architecture\ViewModels;

use App\Models\User;

class UserViewModel
{
    protected $id;
    protected $name;
    protected $email;
    protected $password;
    protected $state;
    protected $avatar;

    public function __construct()
    {

    }

    public function generateViewModel(User $model)
    {
        $this->id = $model->id;
        $this->name = $model->name;
        $this->email = $model->email;
        $this->password = $model->password;
        $this->state = $model->state;
        $this->avatar = $model->avatar;

        return $this;
    }
}
