    @extends('layouts.app')

@section('content')
    <div id="index">
        <div class="d-sm-flex align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Ventas (Mes actual)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">S/. 40,000</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-share-square fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Ganancias (Mes actual)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">S/. 215,000</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Clientes</div>
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">102</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pendiente</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">...</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <custom-card
                    card-title="Productos"
                    button-icon="plus">
                    <h6 class="font-weight-light mb-3"><i class="fa fa-list"></i> Productos sin Stock</h6>
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Stock</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>1</th>
                                <td>Product 1</td>
                                <td class="text-danger">0</td>
                            </tr>
                        </tbody>
                    </table>
                </custom-card>
            </div>
        </div>
    </div>
@endsection

@section('inlineScript')
    <script src="{{asset('js/home/index.js')}}"></script>
@endsection
