@extends('layouts.app')

@section('content')
    <div id="index" class="container">
        <custom-card
            card-title="Proveedores"
            button-title="Crear"
            button-icon="plus"
            @button-action="showModal">
            <h6 class="font-weight-light"><i class="fa fa-list"></i> Lista de proveedores</h6>
            <search-bar @search="search"></search-bar>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Tipo de persona</th>
                    <th>DNI/RUC</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(supplier, index) in suppliers">
                    <th>@{{ index + 1 }}</th>
                    <td>@{{ supplier.name }}</td>
                    <td>@{{ supplier.nameTypePerson }}</td>
                    <td>@{{ supplier.dni }}@{{ supplier.ruc }}</td>
                    <td>@{{ supplier.phone }}</td>
                    <td>@{{ supplier.address }}</td>
                    <td>
                        <button class="btn btn-outline-success btn-sm" v-on:click="showModal(supplier.id)"><i class="fa fa-eye"></i> Ver</button>
                        <button class="btn btn-outline-danger btn-sm" v-on:click="softDelete(supplier.id)"><i class="fa fa-trash"></i> Eliminar</button>
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
            id-modal="SupplierModal"
            :modal-title="modalTitle"
            :button-title="buttonModalTitle"
            @button-action="save">
            <div class="container">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a :class="'nav-link' + [viewModel.idTypePerson === 1 ? ' active' : '']" id="pills-dni-tab"
                           data-toggle="pill" href="#pills-dni"
                           role="tab" aria-controls="pills-dni"
                           aria-selected="true"
                           v-on:click="clearForm(1)">Persona natural</a>
                    </li>
                    <li class="nav-item">
                        <a :class="'nav-link' + [viewModel.idTypePerson === 2 ? ' active' : '']" id="pills-ruc-tab"
                           data-toggle="pill" href="#pills-ruc"
                           role="tab" aria-controls="pills-ruc"
                           aria-selected="false"
                           v-on:click="clearForm(2)">Persona jurídica</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div :class="'tab-pane fade' + [viewModel.idTypePerson === 1 ? ' show active' : '']" id="pills-dni" role="tabpanel" aria-labelledby="pills-dni-tab">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name">Nombre:</label>
                                <input type="text" class="form-control" id="name" placeholder="Nombre" v-model="viewModel.name">
                                <span v-if="showError && validations.name !== undefined" class="text-danger font-weight-light">@{{validations.name[0]}}</span>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="dni">DNI:</label>
                                <input type="text" class="form-control" id="dni" placeholder="DNI" v-model="viewModel.dni">
                                <span v-if="showError && validations.dni !== undefined" class="text-danger font-weight-light">@{{validations.dni[0]}}</span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="phone">Teléfono:</label>
                                <input type="text" class="form-control" id="phone" placeholder="Teléfono" v-model="viewModel.phone">
                                <span v-if="showError && validations.phone !== undefined" class="text-danger font-weight-light">@{{validations.phone[0]}}</span>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="address">Dirección:</label>
                                <input type="text" class="form-control" id="address" placeholder="Dirección" v-model="viewModel.address">
                                <span v-if="showError && validations.address !== undefined" class="text-danger font-weight-light">@{{validations.address[0]}}</span>
                            </div>
                        </div>
                    </div>
                    <div :class="'tab-pane fade' + [viewModel.idTypePerson === 2 ? ' show active' : '']" id="pills-ruc" role="tabpanel" aria-labelledby="pills-ruc-tab">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name">Razón Social:</label>
                                <input type="text" class="form-control" id="name" placeholder="Razón Social" v-model="viewModel.name">
                                <span v-if="showError && validations.name !== undefined" class="text-danger font-weight-light">@{{validations.name[0]}}</span>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="ruc">RUC:</label>
                                <input type="text" class="form-control" id="ruc" placeholder="RUC" v-model="viewModel.ruc">
                                <span v-if="showError && validations.ruc !== undefined" class="text-danger font-weight-light">@{{validations.ruc[0]}}</span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="phone">Teléfono:</label>
                                <input type="text" class="form-control" id="phone" placeholder="Teléfono" v-model="viewModel.phone">
                                <span v-if="showError && validations.phone !== undefined" class="text-danger font-weight-light">@{{validations.phone[0]}}</span>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="address">Dirección:</label>
                                <input type="text" class="form-control" id="address" placeholder="Dirección" v-model="viewModel.address">
                                <span v-if="showError && validations.address !== undefined" class="text-danger font-weight-light">@{{validations.address[0]}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </custom-modal>
    </div>
@endsection

@section('inlineScript')
    <script src="{{asset('js/supplier/index.js')}}"></script>
@endsection
