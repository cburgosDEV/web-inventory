let vue = new Vue({
    el: '#index',
    components: {

    },
    data: {
        url: $('#baseUrl').val() + 'purchase',
        filterText: '',
        purchases: [],
        paginate: {},

        modalTitle: '',
        buttonModalTitle: '',
        viewModel: {},
        viewModelToDelete: {},
        productsDropdown: [],
        suppliersDropdown: [],
        purchaseDetail: [],

        //PURCHASE DETAIL DATA
        validations: {},
        showError: false,

        unitSymbol: '',
        viewModelDetail: {},
        listDetail: [],

        validationsDetail: [],
        showErrorDetail: false,

        showErrorListProduct: false,
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
                    this.purchases = response.model;
                    this.paginate = response.paginate;
                    break;
                case 'jsonCreate':
                    this.viewModel = response.model;
                    this.productsDropdown = response.productsDropdown;
                    this.suppliersDropdown = response.suppliersDropdown;
                    break;
                case 'jsonDetail':
                    this.viewModelToDelete = response;
                    break;
                case 'store':
                    if(response){
                        showToast('success', 'Operación realizada correctamente');
                        $('#PurchaseModal').modal('hide');
                        this.initList();
                    } else {
                        showToast('error', 'No se puedo realizar la compra');
                    }
                    break;
                case 'checkFormDetail':
                    if(response){
                        this.listDetail.push(this.viewModelDetail);
                        this.viewModelDetail = {};
                        showToast('success', 'Producto agregado correctamente');
                    }
                    else {
                        showToast('error', 'Ocurrió un error al agregar el producto');
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
        showModal: function (idPurchase = 0) {
            this.clearData();
            if (idPurchase === 0){
                this.modalTitle = 'Registrar nueva compra'
                this.buttonModalTitle = 'Guardar';
                this.initFormCreate();
            }
            $('#PurchaseModal').modal('show');
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
        initFormDetail: function (idPurchase, callback){
            loading(true);
            let url = this.url + "/jsonDetail/" + idPurchase;
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
            if(action==='store'){
                if(this.listDetail===null){
                    this.showErrorListProduct = true;
                    showToast('warning', 'Seleccionar al menos un producto');
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
        softDelete: function (idPurchase) {
            this.$swal({
                icon: 'warning',
            }).then((result) => {
                if(result.value) {
                    let context = this;
                    this.initFormDetail(idPurchase, function (){
                        context.viewModelToDelete.state = false;
                        context.save('softDelete');
                    });
                }
            });
        },
        getDataProduct: function () {
            let productSelected = this.productsDropdown.filter((item)=>item.value===this.viewModelDetail.idProduct);
            this.viewModelDetail.unitSymbol = productSelected[0].unitSymbol;
            this.viewModelDetail.productName = productSelected[0].text;
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
        deleteProduct: function (index) {
            this.listDetail.splice(index);
        },
        showModalDetail: function (detail, totalPrice) {
            this.purchaseDetail = detail;
            this.purchaseDetail.totalPrice = totalPrice;
            $('#PurchaseDetailModal').modal('show');
        },
    },
});
