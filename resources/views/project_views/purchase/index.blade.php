@extends('layouts.app')

@section('content')
    <div id="index" class="container">
        <custom-card
            card-title="Compras"
            button-title="Registrar nueva compra"
            button-icon="plus"
            @button-action="showModal">
            <h6 class="font-weight-light"><i class="fa fa-list"></i> Lista de compras realizadas</h6>
            <search-bar @search="search"></search-bar>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Proveedor</th>
                        <th>Monto</th>
                        <th>Fecha de compra</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(purchase, index) in purchases">
                        <th>@{{ index + 1 }}</th>
                        <td>@{{ purchase.supplierName }}</td>
                        <td>@{{ purchase.totalPrice }}</td>
                        <td>@{{ purchase.createdDate }}</td>
                        <td>
                            <button class="btn btn-outline-success btn-sm" v-on:click="showModalDetail(purchase.detail, purchase.totalPrice)"><i class="fa fa-eye"></i> Ver compra</button>
                            <button class="btn btn-outline-danger btn-sm" v-on:click="softDelete(purchase.id)"><i class="fa fa-trash"></i> Anular compra</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <pagination
                align="center"
                :data="paginate"
                @pagination-change-page="initList">
            </pagination>
        </custom-card>
        <custom-modal
            id-modal="PurchaseModal"
            :modal-title="modalTitle"
            :button-title="buttonModalTitle"
            @button-action="save('store')">
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="idSupplier">Proveedor:</label>
                    <select class="custom-select my-1 mr-sm-2" id="idSupplier" v-model="viewModel.idSupplier">
                        <option value="null" selected disabled>Seleccionar proveedor</option>
                        <option v-for="item in suppliersDropdown" :value="item.value">
                            @{{item.text}}
                        </option>
                    </select>
                    <span v-if="showError && validations.idSupplier !== undefined" class="text-danger font-weight-light">@{{validations.idSupplier[0]}}</span>
                </div>
                <div class="col-md-12">
                    <hr/>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="idProduct">Producto:</label>
                    <select class="custom-select" id="idProduct" v-model="viewModelDetail.idProduct" v-on:change="getDataProduct">
                        <option value="undefined" selected disabled>Seleccionar producto</option>
                        <option v-for="item in productsDropdown" :value="item.value">
                            @{{item.text}}
                        </option>
                    </select>
                    <span v-if="showErrorDetail && validationsDetail.idProduct !== undefined" class="text-danger font-weight-light">@{{validationsDetail.idProduct[0]}}</span>
                    <span v-if="showErrorListProduct" class="text-danger font-weight-light">*Seleccionar al menos un producto</span>
                    <span v-if="showError && validations.listDetail !== undefined" class="text-danger font-weight-light">@{{validations.listDetail[0]}}</span>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="unitaryPrice">Precio (S/.):</label>
                    <input type="number" class="form-control" id="unitaryPrice" v-model="viewModelDetail.unitaryPrice">
                    <span v-if="showErrorDetail && validationsDetail.unitaryPrice !== undefined" class="text-danger font-weight-light">@{{validationsDetail.unitaryPrice[0]}}</span>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="quantity">Cantidad: (<span class="text-primary font-weight-bold">@{{viewModelDetail.unitSymbol}}</span>)</label>
                    <input type="number" class="form-control" id="quantity" v-model="viewModelDetail.quantity">
                    <span v-if="showErrorDetail && validationsDetail.quantity !== undefined" class="text-danger font-weight-light">@{{validationsDetail.quantity[0]}}</span>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="subTotal">Sub total:</label>
                    <input type="number" class="form-control" id="subTotal" v-model="subTotal" disabled>
                </div>
                <div class="col-md-12 mb-3">
                    <button class="btn btn-success w-100 font-weight-bold" v-on:click="addViewModelDetail">+</button>
                </div>
                <div class="col-md-12">
                    <hr/>
                </div>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Unidad de medida</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Sub total</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in listDetail">
                        <th>@{{ index + 1 }}</th>
                        <td>@{{ item.productName }}</td>
                        <td>@{{ item.unitSymbol }}</td>
                        <td>S/. @{{ item.unitaryPrice }}</td>
                        <td>@{{ item.quantity }}</td>
                        <td>S/. @{{ item.subTotal }}</td>
                        <td>
                            <button class="btn btn-outline-danger btn-sm" v-on:click="deleteProduct(index)"><i class="fa fa-minus"></i></button>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="5" class="font-weight-bold text-right">Total:</th>
                        <th>S/. @{{totalPrice}}</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </custom-modal>
        <custom-modal
            id-modal="PurchaseDetailModal"
            modal-title="Detalle de la compra">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Precio Unitario.</th>
                    <th>Cantidad</th>
                    <th>Sub total</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(detail, index) in purchaseDetail">
                    <th>@{{ index + 1 }}</th>
                    <td>@{{ detail.productName }}</td>
                    <td>@{{ detail.unitaryPrice }}</td>
                    <td>@{{ detail.quantity }}</td>
                    <td>@{{ detail.subTotal }}</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="4" class="text-right">Total:</th>
                    <td>@{{purchaseDetail.totalPrice}}</td>
                </tr>
                </tfoot>
            </table>
        </custom-modal>
    </div>
@endsection

@section('inlineScript')
    <script src="{{asset('js/purchase/index.js')}}"></script>
@endsection
