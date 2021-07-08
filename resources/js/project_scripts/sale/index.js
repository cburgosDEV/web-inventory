let vue = new Vue({
    el: '#index',
    components: {

    },
    data: {
        url: $('#baseUrl').val() + 'sale',
        filterText: '',
        sales: [],
        paginate: {},

        modalTitle: '',
        buttonModalTitle: '',
        viewModel: {},
        viewModelToDelete: {},
        productsDropdown: [],
        customersDropdown: [],
        saleDetail: [],

        //SALE DETAIL DATA
        validations: {},
        showError: false,

        viewModelDetail: {},
        listDetail: [],

        validationsDetail: [],
        showErrorDetail: false,

        showErrorListProduct: false,
        listDetailDelete: []
    },
    computed:{
        subTotal: function (){
            return this.viewModelDetail.subTotal = (this.viewModelDetail.unitaryPrice * this.viewModelDetail.quantity || 0).toFixed(2);
        },
        totalPrice: function () {
            return this.viewModel.totalPrice = this.listDetail===null?0:this.listDetail.reduce((total, detail) => total + parseFloat(detail.subTotal), 0);
        }
    },
    created() {
        this.initList();
    },
    methods: {
        switchResponseServer: function (switchAction, response){
            switch (switchAction){
                case 'initList':
                    this.sales = response.model;
                    this.paginate = response.paginate;
                    break;
                case 'jsonCreate':
                    this.viewModel = response.model;
                    this.productsDropdown = response.productsDropdown;
                    this.customersDropdown = response.customersDropdown;
                    break;
                case 'jsonDetail':
                    this.viewModelToDelete = response;
                    break;
                case 'store':
                    if(response){
                        showToast('success', 'Operación realizada correctamente');
                        $('#SaleModal').modal('hide');
                        this.initList();
                    } else {
                        showToast('error', 'No se pudo realizar la venta');
                    }
                    break;
                case 'checkFormDetail':
                    if(response){
                        this.listDetail.push(this.viewModelDetail);
                        this.removeProductFromDropdown(this.viewModelDetail.idProduct);
                        this.viewModelDetail = {};
                        showToast('success', 'Producto agregado correctamente');
                    }
                    else {
                        showToast('error', 'Ocurrió un error al agregar el producto');
                    }
                    break;
                case 'getDataProduct':
                    if(response){
                        this.viewModelDetail = response;
                    }
                    break;
            }
        },
        initList: function(page = 1){
            loading(true);
            let url = this.url + "/jsonIndex/" + this.filterText + '?page=' + page;
            window.axios.get(url).then((response) => {
                this.switchResponseServer("initList", response.data);
            }).catch((error) => {

            }).finally((response) => {
                loading(false);
            });
        },
        search: function (filterText){
            this.filterText = filterText;
            this.initList();
        },
        showModal: function (idSale = 0) {
            this.clearData();
            if (idSale === 0){
                this.modalTitle = 'Registrar nueva venta'
                this.buttonModalTitle = 'Guardar';
                this.initFormCreate();
            }
            $('#SaleModal').modal('show');
        },
        initFormCreate: function (){
            loading(true);
            let url = this.url + "/jsonCreate";
            window.axios.get(url).then((response) => {
                this.switchResponseServer("jsonCreate", response.data);
            }).catch((error) => {

            }).finally((response) => {
                loading(false);
            });
        },
        initFormDetail: function (idSale, callback){
            loading(true);
            let url = this.url + "/jsonDetail/" + idSale;
            window.axios.get(url).then((response) => {
                this.switchResponseServer("jsonDetail", response.data);
            }).catch((error) => {

            }).finally((response) => {
                loading(false);
                if(callback){
                    callback();
                }
            });
        },
        save: function (action) {
            let data = {};
            this.clearErrors();
            if(action==='store'){
                if(this.listDetail===null){
                    this.showErrorListProduct = true;
                    showToast('warning', 'Agregar al menos un producto');
                    return;
                }
                this.viewModel.listDetail = this.listDetail;
                data = this.viewModel;
            } else {
                data = this.viewModelToDelete;
            }
            loading(true);
            let url = this.url + "/store";
            window.axios.post(url, data).then((response) => {
                this.switchResponseServer("store", response.data);
            }).catch((error) => {
                if(error.response.status === 422){
                    this.showError = true;
                    this.validations = error.response.data.errors;
                }
                showToast('error', 'Revisar los datos ingresados');
            }).finally((response) => {
                loading(false);
            });
        },
        softDelete: function (idSale) {
            this.$swal({
                icon: 'warning',
            }).then((result) => {
                if(result.value) {
                    let context = this;
                    this.initFormDetail(idSale, function (){
                        context.viewModelToDelete.state = false;
                        context.save('softDelete');
                    });
                }
            });
        },
        getDataProduct: function () {
            loading(true);
            this.clearErrorsDetail();
            if(this.viewModelDetail.idProduct===undefined)return;
            let url = this.url + "/jsonProduct/" + this.viewModelDetail.idProduct;
            window.axios.get(url).then((response) => {
                this.switchResponseServer("getDataProduct", response.data);
            }).catch((error) => {
                if(error.response.status === 422){
                    this.showErrorDetail = true;
                    this.validationsDetail = error.response.data.errors;
                }
                showToast('error', 'Revisar los datos ingresados');
            }).finally((response) => {
                loading(false);
            });
        },
        addViewModelDetail: function () {
            this.clearErrors();
            this.clearErrorsDetail();
            loading(true);
            let url = this.url + "/checkFormDetail";
            window.axios.post(url, this.viewModelDetail).then((response) => {
                this.switchResponseServer("checkFormDetail", response.data);
            }).catch((error) => {
                if(error.response.status === 422){
                    this.showErrorDetail = true;
                    this.validationsDetail = error.response.data.errors;
                }
                showToast('error', 'Revisar los datos ingresados');
            }).finally((response) => {
                loading(false);
            });
        },
        clearErrors: function () {
            this.validations = {};
            this.showError = false;
        },
        clearErrorsDetail: function () {
            this.showErrorDetail = false;
            this.validationsDetail = [];
            this.showErrorListProduct = false;
        },
        clearData: function () {
            this.modalTitle = '';
            this.buttonModalTitle = '';
            this.viewModel = {};
            this.viewModelDetail = {};
            this.listDetail = [];
            this.clearErrorsDetail();
            this.clearErrors();
        },
        deleteProduct: function (index, idProduct) {
            this.listDetail.splice(index);
            this.addProductToDropdown(idProduct);
        },
        showModalDetail: function (detail, totalPrice) {
            this.saleDetail = detail;
            this.saleDetail.totalPrice = totalPrice;
            $('#SaleDetailModal').modal('show');
        },
        removeProductFromDropdown: function (idProduct){
            for( let i = 0; i < this.productsDropdown.length; i++){
                if (this.productsDropdown[i].value === idProduct) {
                    this.listDetailDelete.push(this.productsDropdown[i]);
                    this.productsDropdown.splice(i, 1);
                }
            }
        },
        addProductToDropdown: function (idProduct){
            for( let i = 0; i < this.listDetailDelete.length; i++){
                if (this.listDetailDelete[i].value === idProduct) {
                    this.productsDropdown.push(this.listDetailDelete[i]);
                    this.listDetailDelete.splice(i, 1);
                }
            }
        },
    },
});
