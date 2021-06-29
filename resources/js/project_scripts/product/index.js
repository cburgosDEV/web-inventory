import VueUploadMultipleImage from 'vue-upload-multiple-image';

let vue = new Vue({
    el: '#index',
    components: {
        VueUploadMultipleImage
    },
    data: {
        url: $('#baseUrl').val() + 'product',
        filterText: '',
        products: [],
        paginate: {},
        viewModel: {},
        validations : {},
        showError: false,
        modalTile: '',
        buttonModalTile: '',
        dropdownUnit: [],
        images: [],
        listImagePath: [],
        listImageDelete: null,
        showEdit: false,
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
                    this.products = response.model;
                    this.paginate = response.paginate;
                    break;
                case 'jsonCreate':
                    this.viewModel = response.viewModel;
                    this.dropdownUnit = response.dropdownUnit;
                    break;
                case 'store':
                    if(response){
                        showToast('success', 'Operación realizada correctamente');
                        this.initList();
                        $('#ProductModal').modal('hide');
                    } else {
                        showToast('error', 'Ocurrió un error al guardar el registro');
                    }
                    break;
                case 'jsonDetail':
                    this.viewModel = response.viewModel;
                    this.dropdownUnit = response.dropdownUnit;
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
        showModal: function (idProduct = 0, action) {
            this.clearData();
            if (idProduct === 0){
                this.modalTile = 'Crear nuevo'
                this.buttonModalTile = 'Guardar';
                this.initFormCreate(action);
            } else {
                this.modalTile = 'Detalle'
                this.buttonModalTile = 'Actualizar';
                this.initFormDetail(idProduct, null, action);
            }
        },
        initFormCreate: function (){
            loading(true);
            let url = this.url + "/jsonCreate";
            window.axios.get(url).then((response) => {
                this.switchResponseServer("jsonCreate", response.data);
            }).catch((error) => {

            }).finally((response) => {
                $('#ProductModal').modal('show');
                loading(false);
            });
        },
        initFormDetail: function (idProduct, callback, action){
            loading(true);
            let url = this.url + "/jsonDetail/" + idProduct;
            window.axios.get(url).then((response) => {
                this.switchResponseServer("jsonDetail", response.data);
            }).catch((error) => {

            }).finally((response) => {
                if(action==='detail'){
                    this.setImages(this.viewModel.images);
                    $('#ProductModal').modal('show');
                }
                loading(false);
                if(callback)callback();
            });
        },
        save: function () {
            let listImageFile = [];
            this.listImagePath.forEach((item)=>{
                listImageFile.push({
                    'id':item.id??0,
                    'default':item.default,
                    'highlight':item.highlight,
                    'file': item.path
                });
            });
            this.viewModel.listImageDelete = this.listImageDelete;
            this.viewModel.listImage = listImageFile;
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
        softDelete: function (idProduct) {
            this.$swal({
                icon: 'warning',
            }).then((result) => {
                if(result.value) {
                    let context = this;
                    this.initFormDetail(idProduct, function (){
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
            this.modalTile = '';
            this.buttonModalTile = '';
            this.images = [];
            this.listImagePath = [];
            this.listImageDelete = null;
        },
        uploadImageSuccess(formData, index, fileList) {
            this.listImagePath = fileList;
        },
        beforeRemove (index, done, fileList) {
            let r = true;
            if (r) {
                this.listImageDelete = fileList;
                done();
            }
        },
        markIsPrimary: function (index, fileList) {
            this.listImagePath = fileList;
        },
        setImages: function (images){
            images.forEach((item)=>{
                if(!item.state)return;
                this.images.push(
                    {
                        id: item.id,
                        path: 'storage/'+item.url,
                        default: item.isPrincipal??0,
                        highlight: item.isPrincipal??0,
                        caption: 'Producto'
                    }
                );
            });
        }
    },
});


