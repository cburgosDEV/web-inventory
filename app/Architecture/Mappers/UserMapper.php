<?php

namespace App\Architecture\Mappers;

use App\Architecture\ViewModels\UserViewModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserMapper
{
    public function modelToViewModel(User $model)
    {
        $viewModel = new UserViewModel();

        return $viewModel->generateViewModel($model);
    }

    public function objectRequestToModel($object)
    {
        $model = new User();
        $model->id = $object['id'];
        $model->name = $object['name'];
        $model->email = $object['email'];
        $model->password = Hash::make($object['password']);
        $model->state = $object['state'];
        $model->avatar = $object['avatar']??'users/avatar.png';

        return $model;
    }
}
