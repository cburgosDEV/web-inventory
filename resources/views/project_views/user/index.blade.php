@extends('layouts.app')

@section('content')
    <div id="index" class="container">
        <custom-card
            card-title="Usuarios"
            button-title="Crear"
            button-icon="plus"
            @button-action="showModal">
            <h6 class="font-weight-light"><i class="fa fa-list"></i> Lista de usuarios</h6>
            <search-bar @search="search"></search-bar>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre del usuario</th>
                    <th>Email</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(user, index) in users">
                    <th>@{{ index + 1 }}</th>
                    <td>@{{ user.name }}</td>
                    <td>@{{ user.email }}</td>
                    <td>
                        <button class="btn btn-outline-success btn-sm" v-on:click="showModal(user.id)"><i class="fa fa-eye"></i> Ver</button>
                        <button class="btn btn-outline-dark btn-sm" v-on:click="showModalChangePassword(user.id)"><i class="fa fa-lock"></i> Cambiar contraseña</button>
                        <button class="btn btn-outline-danger btn-sm" v-on:click="softDelete(user.id)"><i class="fa fa-trash"></i> Eliminar</button>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination
                align="center"
                :data="paginate"
                @pagination-change-page="initList">
            </pagination>
        </custom-card>
        <custom-modal
            id-modal="UserModal"
            :modal-title="modalTitle"
            :button-title="buttonModalTitle"
            @button-action="save">
            <div class="row">
                <div class="col-md-12 col-lg-4 col-xl-4 d-flex justify-content-center">
                    <vue-upload-multiple-image
                        drag-text="Arrastrar imagen"
                        browse-text="Seleccionar imagen"
                        primary-text="Imagen principal"
                        popup-text="Esta imagen se mostrará en el perfil del usuario"
                        drop-text="Soltar aquí"
                        :data-images="image"
                        :show-edit="showEdit"
                        :multiple="isMultiple"
                        @upload-success="uploadImageSuccess"
                        @before-remove="beforeRemove">
                    </vue-upload-multiple-image>
                </div>
                <div class="col-md-12 col-lg-8 col-xl-8 mt-2">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name">Nombre del usuario:</label>
                            <input type="text" class="form-control" id="name" placeholder="Nombre del usuario" v-model="viewModel.name">
                            <span v-if="showError && validations.name !== undefined" class="text-danger font-weight-light">@{{validations.name[0]}}</span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" placeholder="Email" v-model="viewModel.email">
                            <span v-if="showError && validations.email !== undefined" class="text-danger font-weight-light">@{{validations.email[0]}}</span>
                        </div>
                        <div v-if="!isEditForm" class="col-md-12 mb-3">
                            <label for="password">Contraseña:</label>
                            <input type="password" class="form-control" id="password" placeholder="Contraseña" v-model="viewModel.password">
                            <span v-if="showError && validations.password !== undefined" class="text-danger font-weight-light">@{{validations.password[0]}}</span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="role">Rol:</label>
                            <select class="custom-select my-1 mr-sm-2" id="role" v-model="viewModel.role">
                                <option value="" selected disabled>Seleccionar rol</option>
                                <option value="admin">Administrador</option>
                                <option value="seller">Vendedor</option>
                            </select>
                            <span v-if="showError && validations.role !== undefined" class="text-danger font-weight-light">@{{validations.role[0]}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </custom-modal>
        <custom-modal
            id-modal="UserPasswordModal"
            modal-title="Cambiar contraseña"
            button-title="Guardar"
            @button-action="changePassword">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="password">Nueva contraseña:</label>
                            <input type="password" class="form-control" id="password" placeholder="Nueva contraseña:" v-model="password">
                            <span v-if="showErrorsChangePassword && validationsChangePassword.password !== undefined" class="text-danger">@{{validationsChangePassword.password[0]}}</span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="rePassword">Repetir contraseña:</label>
                            <input type="password" class="form-control" id="rePassword" placeholder="Repetir contraseña:" v-model="rePassword">
                            <span v-if="showErrorsChangePassword && validationsChangePassword.rePassword !== undefined" class="text-danger">@{{validationsChangePassword.rePassword[0]}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </custom-modal>
    </div>
@endsection

@section('inlineScript')
    <script src="{{asset('js/user/index.js')}}"></script>
@endsection
