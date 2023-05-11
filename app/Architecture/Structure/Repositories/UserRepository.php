<?php

namespace App\Architecture\Structure\Repositories;

use App\Architecture\Helpers\PaginatorHelper;
use App\Models\User;

class UserRepository
{
    public function buildEmptyModel()
    {
        return $emptyModel = [
            'id' => 0,
            'name' => '',
            'email' => '',
            'password' => '',
            'state' => true,
            'avatar' => '',
            'role' => '',
            'image' => '',
            'isImageDeleted' => false,
            'avatarUrl' => ''
        ];
    }

    public function getById($id)
    {
        return User::select('users.*', 'roles.name as role')
            ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', 'roles.id')
            ->where('users.id', $id)
            ->first();
    }

    public function store(User $user)
    {
        if($user->id == 0) {
            return $user->save();
        } else {
            return $user->update();
        }
    }

    public function getAllPaginateToIndex($pages, $filterText)
    {
        $model = User::select('users.*')
            ->where('users.state', true)
            ->filtersToUserIndex($filterText)
            ->paginate($pages);

        $paginatorHelper = new PaginatorHelper();
        $paginate = $paginatorHelper->paginateModel($model);

        return [
            'model' => $model->all(),
            'paginate' => $paginate
        ];
    }
}
