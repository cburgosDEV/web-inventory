<?php

namespace App\Http\Controllers;

use App\Architecture\Structure\Services\UserService;
use App\Http\Request\StoreChangePassword;
use App\Http\Request\StoreUser;
use http\Env\Request;

class UserController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('project_views.user.index');
    }

    public function jsonIndex($filterText = '')
    {
        return response()->json($this->userService->getAllPaginateToIndex($filterText));
    }

    public function jsonCreate()
    {
        return response()->json($this->userService->getById(0));
    }

    public function store(StoreUser $request)
    {
        $request->validated();

        return response()->json($this->userService->store($request));
    }

    public function jsonDetail($idUser)
    {
        return response()->json($this->userService->getById($idUser));
    }

    public function changePassword(StoreChangePassword $request)
    {
        $request->validated();

        return response()->json($this->userService->changePassword($request));
    }
}
