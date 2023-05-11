<?php

namespace App\Architecture\Structure\Services;

use App\Architecture\Helpers\StoreImageHelper;
use App\Architecture\Mappers\UserMapper;
use App\Architecture\Structure\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserService
{
    protected $userRepository;
    protected $userMapper;
    protected $storeImageHelper;
    protected $firebaseService;

    public function __construct
    (
        UserRepository $userRepository,
        UserMapper $userMapper,
        StoreImageHelper $storeImageHelper,
        FirebaseService $firebaseService
    )
    {
        $this->userRepository = $userRepository;
        $this->userMapper = $userMapper;
        $this->storeImageHelper = $storeImageHelper;
        $this->firebaseService = $firebaseService;
    }

    public function getById($id)
    {
        if($id == 0) return $this->userRepository->buildEmptyModel();
        $user = $this->userRepository->getById($id);
        $user->urlFirebase = $this->firebaseService->getImage($user->avatar);
        return $user;
    }

    public function getAllPaginateToIndex($filterText)
    {
        $listUsers = $this->userRepository->getAllPaginateToIndex(10, $filterText);
        foreach($listUsers['model'] as $user) {
            $user->avatarUrl = $this->firebaseService->getImage($user->avatar);
        }

        return  $listUsers;
    }

    public function store($request)
    {
        if($request->get('id') == 0) {
            $model = $this->userMapper->objectRequestToModel($request->all());
            $model->assignRole(Role::findByName($request->get('role')));

            //SAVE IMAGE
            if($request->get('image')!=null) {
                $image = $request->get('image');
                $responseImage = $this->firebaseService->storeImage($image, "users/");
                $model->avatar = $responseImage;
            }

            return $this->userRepository->store($model);
        }
        else {
            $model = $this->userRepository->getById($request->get('id'));
            $model->fill($request->all());

            //CHANGE ROLE
            if($model->getRoleNames()[0]!=$request->get('role')){
                $model->removeRole($model->getRoleNames()[0]);
                $model->assignRole(Role::findByName($request->get('role')));
            }

            //DELETE IMAGE
            if($request->get('isImageDeleted') && $request->get('avatar')!='users/avatar.png') {
                $this->firebaseService->deleteImage($model['avatar']);
                $model['avatar'] = 'users/avatar.png';
            }

            //SAVE IMAGE
            if($request->get('image')!=null) {
                $image = $request->get('image');
                $responseImage = $this->firebaseService->storeImage($image, "users/");
                $model['avatar'] = $responseImage;
            }

            return $this->userRepository->store($model);
        }
    }

    public function changePassword($request)
    {
        $model = $this->userRepository->getById($request->get('id'));
        $model['password'] = Hash::make($request->get('password'));
        return $this->userRepository->store($model);
    }
}
