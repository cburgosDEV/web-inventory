@extends('layouts.app')

@section('content')
    <div id="index" class="container">
        <custom-card
            card-title="Unidades"
            button-title="Crear"
            button-icon="plus"
            @button-action="showModal">
            <h6 class="font-weight-light"><i class="fa fa-list"></i> Lista de unidades</h6>
            <search-bar @search="search"></search-bar>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Unidad</th>
                        <th>Símbolo</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                <tr v-for="(unit, index) in units">
                    <th>@{{ index + 1 }}</th>
                    <td>@{{ unit.name }}</td>
                    <td>@{{ unit.symbol }}</td>
                    <td>
                        <button class="btn btn-outline-success btn-sm" v-on:click="showModal(unit.id)"><i class="fa fa-eye"></i> Ver</button>
                        <button class="btn btn-outline-danger btn-sm" v-on:click="softDelete(unit.id)"><i class="fa fa-trash"></i> Eliminar</button>
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
            id-modal="UnitModal"
            :modal-title="modalTile"
            :button-title="buttonModalTile"
            @button-action="save">
            <div class="form-row">
                <div class="col-md-8 mb-3">
                    <label for="name">Unidad</label>
                    <input type="text" class="form-control" id="name" placeholder="Unidad" v-model="viewModel.name">
                    <span v-if="showError && validations.name !== undefined" class="text-danger font-weight-light">@{{validations.name[0]}}</span>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="symbol">Símbolo</label>
                    <input type="text" class="form-control" id="symbol" placeholder="Símbolo" v-model="viewModel.symbol">
                    <span v-if="showError && validations.symbol !== undefined" class="text-danger font-weight-light">@{{validations.symbol[0]}}</span>
                </div>
            </div>
        </custom-modal>
    </div>
@endsection

@section('inlineScript')
    <script src="{{asset('js/unit/index.js')}}"></script>
@endsection
