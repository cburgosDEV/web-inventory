let vue = new Vue({
    el: '#index',
    components: {

    },
    data: {
        url: $('#baseUrl').val() + 'supplier',
        filterText: '',
        suppliers: [],
        paginate: {},
        viewModel: {},
        validations : {},
        showError: false,
        modalTitle: '',
        buttonModalTitle: '',
    },
    computed: {

    },
    created() {
        this.initList();
    },
    methods: {
        switchResponseServer: function (switchAction, response){
            switch (switchAction){
                case 'initList':
                    this.suppliers = response.model;
                    this.paginate = response.paginate;
                    break;
                case 'jsonCreate':
                    this.viewModel = response;
                    break;
                case 'store':
                    if(response){
                        showToast('success', 'Operación realizada correctamente');
                        this.initList();
                        $('#SupplierModal').modal('hide');
                    } else {
                        showToast('error', 'Ocurrió un error al guardar el registro');
                    }
                    break;
                case 'jsonDetail':
                    this.viewModel = response;
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
        showModal: function (idSupplier = 0) {
            this.clearData();
            if (idSupplier === 0){
                this.modalTitle = 'Crear nuevo'
                this.buttonModalTitle = 'Guardar';
                this.initFormCreate();
            } else {
                this.modalTitle = 'Detalle'
                this.buttonModalTitle = 'Actualizar';
                this.initFormDetail(idSupplier);

            }
            $('#SupplierModal').modal('show');
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
        initFormDetail: function (idSupplier, callback){
            loading(true);
            let url = this.url + "/jsonDetail/" + idSupplier;
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
        save: function () {
            loading(true);
            let url = this.url + "/store";
            window.axios.post(url, this.viewModel).then((response) => {
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
        softDelete: function (idSupplier) {
            this.$swal({
                icon: 'warning',
            }).then((result) => {
                if(result.value) {
                    let context = this;
                    this.initFormDetail(idSupplier, function (){
                        context.viewModel.state = false;
                        context.save();
                    });
                }
            });
        },
        clearData: function () {
            this.showError = false;
            this.validations = {};
            this.viewModel = {};
            this.modalTitle = '';
            this.buttonModalTitle = '';
        },
        clearForm: function (idTypePerson) {
            this.showError = false;
            this.validations = {};
            this.viewModel = {"id":0,"name":"","dni":"","ruc":"","phone":"","address":"","state":true,"idTypePerson":0};
            this.viewModel.idTypePerson = parseInt(idTypePerson);
        }
    },
});


