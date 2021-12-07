@extends('layouts.app')

@section('content')
    <div id="index" class="container">
        <custom-card
            card-title="Categorías"
            button-title="Crear"
            button-icon="plus"
            @button-action="showModal">
            <h6 class="font-weight-light"><i class="fa fa-list"></i> Lista de categorías</h6>
            <search-bar @search="search"></search-bar>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Categoría</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(category, index) in categories">
                    <th>@{{ index + 1 }}</th>
                    <td>@{{ category.name }}</td>
                    <td>
                        <button class="btn btn-outline-success btn-sm" v-on:click="showModal(category.id)"><i class="fa fa-eye"></i> Ver</button>
                        <button class="btn btn-outline-danger btn-sm" v-on:click="softDelete(category.id)"><i class="fa fa-trash"></i> Eliminar</button>
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
            id-modal="CategoryModal"
            :modal-title="modalTitle"
            :button-title="buttonModalTitle"
            @button-action="save">
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="name">Categoría:</label>
                    <input type="text" class="form-control" id="name" placeholder="Categoría" v-model="viewModel.name">
                    <span v-if="showError && validations.name !== undefined" class="text-danger font-weight-light">@{{validations.name[0]}}</span>
                </div>
            </div>
        </custom-modal>
    </div>
@endsection

@section('inlineScript')
    <script src="{{asset('js/category/index.js')}}"></script>
@endsection
