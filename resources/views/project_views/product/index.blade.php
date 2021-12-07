@extends('layouts.app')

@section('content')
    <div id="index" class="container">
        <custom-card
            card-title="Productos"
            button-title="Crear"
            button-icon="plus"
            @button-action="showModal(0,'create')">
            <h6 class="font-weight-light"><i class="fa fa-list"></i> Lista de productos</h6>
            <search-bar @search="search"></search-bar>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Unidad de medida</th>
                    <th>Precio mínimo</th>
                    <th>Stock</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(product, index) in products">
                    <th>@{{ index + 1 }}</th>
                    <td>@{{ product.name }}</td>
                    <td>@{{ product.nameUnit }}</td>
                    <td>@{{ product.minPrice }}</td>
                    <td>@{{ product.stock }}</td>
                    <td>
                        <button class="btn btn-outline-success btn-sm" v-on:click="showModal(product.id, 'detail')"><i class="fa fa-eye"></i> Ver</button>
                        <button class="btn btn-outline-danger btn-sm" v-on:click="softDelete(product.id)"><i class="fa fa-trash"></i> Eliminar</button>
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
            id-modal="ProductModal"
            :modal-title="modalTitle"
            :button-title="buttonModalTitle"
            @button-action="save">
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="name">Producto: </label>
                    <input type="text" class="form-control" id="name" placeholder="Producto" v-model="viewModel.name">
                    <span v-if="showError && validations.name !== undefined" class="text-danger font-weight-light">@{{validations.name[0]}}</span>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="description">Descripción:</label>
                    <textarea class="form-control" id="description" rows="3" placeholder="Descripción" v-model="viewModel.description"></textarea>
                    <span v-if="showError && validations.description !== undefined" class="text-danger font-weight-light">@{{validations.description[0]}}</span>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="idUnit">Unidad de medida:</label>
                    <select class="custom-select my-1 mr-sm-2" id="idUnit" v-model="viewModel.idUnit">
                        <option value="0" selected disabled>Seleccionar unidad de medida</option>
                        <option v-for="item in dropdownUnit" :value="item.value">
                            @{{item.text}}
                        </option>
                    </select>
                    <span v-if="showError && validations.idUnit !== undefined" class="text-danger font-weight-light">@{{validations.idUnit[0]}}</span>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="idCategory">Categoría:</label>
                    <v-select
                        multiple
                        :options="dropdownCategory"
                        label="text"
                        :reduce="item => item.value"
                        v-model="categories">
                    </v-select>
                </div>
                <div class="col-md-12 d-flex justify-content-center">
                    <vue-upload-multiple-image
                        drag-text="Arrastrar imagen"
                        browse-text="Seleccionar imagen"
                        primary-text="Imagen principal"
                        mark-is-primary-text="Marcar como imagen principal"
                        popup-text="Esta imagen se mostrará  en la portada del producto"
                        drop-text="Soltar aquí"
                        :data-images="images"
                        id-upload="myIdUpload"
                        :show-edit="showEdit"
                        @upload-success="uploadImageSuccess"
                        @mark-is-primary="markIsPrimary"
                        @before-remove="beforeRemove">
                    </vue-upload-multiple-image>
                </div>
            </div>
        </custom-modal>
    </div>
@endsection

@section('inlineScript')
    <script src="{{asset('js/product/index.js')}}"></script>
@endsection
