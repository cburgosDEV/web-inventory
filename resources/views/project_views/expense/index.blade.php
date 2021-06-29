@extends('layouts.app')

@section('content')
    <div id="index" class="container">
        <custom-card
            card-title="Gastos"
            button-title="Crear"
            button-icon="plus"
            @button-action="showModal">
            <h6 class="font-weight-light"><i class="fa fa-list"></i> Lista de gastos</h6>
            <search-bar @search="search"></search-bar>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Gasto</th>
                    <th>Monto</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(expense, index) in expenses">
                    <th>@{{ index + 1 }}</th>
                    <td>@{{ expense.name }}</td>
                    <td>@{{ expense.amount }}</td>
                    <td>
                        <button class="btn btn-outline-success btn-sm" v-on:click="showModal(expense.id)"><i class="fa fa-eye"></i> Ver</button>
                        <button class="btn btn-outline-danger btn-sm" v-on:click="softDelete(expense.id)"><i class="fa fa-trash"></i> Eliminar</button>
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
            id-modal="ExpenseModal"
            :modal-title="modalTile"
            :button-title="buttonModalTile"
            @button-action="save">
            <div class="form-row">
                <div class="col-md-8 mb-3">
                    <label for="name">Gasto</label>
                    <input type="text" class="form-control" id="name" placeholder="Gasto" v-model="viewModel.name">
                    <span v-if="showError && validations.name !== undefined" class="text-danger font-weight-light">@{{validations.name[0]}}</span>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="monto">Monto</label>
                    <input type="number" class="form-control" id="monto" placeholder="Monto" v-model="viewModel.amount">
                    <span v-if="showError && validations.amount !== undefined" class="text-danger font-weight-light">@{{validations.amount[0]}}</span>
                </div>
            </div>
        </custom-modal>
    </div>
@endsection

@section('inlineScript')
    <script src="{{asset('js/expense/index.js')}}"></script>
@endsection
