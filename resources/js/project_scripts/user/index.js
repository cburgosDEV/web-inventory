import VueUploadMultipleImage from 'vue-upload-multiple-image';

let vue = new Vue({
    el: '#index',
    components: {
        VueUploadMultipleImage
    },
    data: {
        url: $('#baseUrl').val() + 'user',
        filterText: '',
        users: [],
        paginate: {},
        viewModel: {},
        validations : {},
        showError: false,
        modalTitle: '',
        buttonModalTitle: '',
        isEditForm: false,
        //IMAGE
        image: [],
        imagePath: [],
        showEdit: false,
        isMultiple: false,
        //PASSWORD
        idUser: 0,
        password: '',
        rePassword: '',
        showErrorsChangePassword: false,
        validationsChangePassword: {},
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
                    this.users = response.model;
                    this.paginate = response.paginate;
                    break;
                case 'jsonCreate':
                    this.viewModel = response;
                    break;
                case 'store':
                    if(response){
                        showToast('success', 'Operación realizada correctamente');
                        this.initList();
                        $('#UserModal').modal('hide');
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
        showModal: function (idUser = 0) {
            this.clearData();
            if (idUser === 0){
                this.modalTitle = 'Crear nuevo usuario'
                this.buttonModalTitle = 'Guardar';
                this.initFormCreate();
            } else {
                this.modalTitle = 'Detalle'
                this.buttonModalTitle = 'Actualizar';
                this.isEditForm = true;
                this.initFormDetail(idUser);

            }
            $('#UserModal').modal('show');
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
        initFormDetail: function (idUser, callback){
            loading(true);
            let url = this.url + "/jsonDetail/" + idUser;
            window.axios.get(url).then((response) => {
                this.switchResponseServer("jsonDetail", response.data);
            }).catch((error) => {

            }).finally((response) => {
                this.setImageToShow(this.viewModel.urlFirebase);
                loading(false);
                if(callback){
                    callback();
                }
            });
        },
        save: function () {
            let url = this.url + "/store";
            if(this.imagePath.length>0)this.viewModel.image = this.imagePath[0].path;
            loading(true);
            console.log(this.viewModel);
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
        softDelete: function (idUser) {
            this.$swal({
                icon: 'warning',
            }).then((result) => {
                if(result.value) {
                    let context = this;
                    this.initFormDetail(idUser, function (){
                        context.viewModel.state = false;
                        context.save();
                    });
                }
            });
        },
        clearData: function () {
            this.isEditForm = false;
            this.showError = false;
            this.validations = {};
            this.viewModel = {};
            this.modalTitle = '';
            this.buttonModalTitle = '';
            this.image = [];
            this.imagePath = [];
        },
        uploadImageSuccess(formData, index, fileList) {
            this.imagePath = fileList;
        },
        beforeRemove (index, done, fileList) {
            let r = true;
            if (r) {
                this.viewModel.isImageDeleted = true;
                done();
            }
        },
        setImageToShow: function (image){
            this.image.push(
                {
                    path: image,
                    default: 1,
                    highlight: 1,
                    caption: 'Profile'
                }
            );
        },
        showModalChangePassword: function (idUser) {
            this.clearDataChangePassword();
            this.idUser = idUser;
            $('#UserPasswordModal').modal('show');
        },
        changePassword: function () {
            let url = this.url + "/changePassword";
            let data = {
                id: this.idUser,
                password: this.password,
                rePassword: this.rePassword,
            };
            this.$swal({
                confirmButtonText: 'Si, cambiar contraseña',
                icon: 'warning',
            }).then((result) => {
                if(result.value) {
                    loading(true);
                    window.axios.post(url, data).then((response) => {
                        if (response.data) {
                            showToast('success', 'Operación realizada correctamente');
                            this.clearDataChangePassword();
                            $('#UserPasswordModal').modal('hide');
                        }
                    }).catch((error) => {
                        if(error.response.status === 422){
                            this.showErrorsChangePassword = true;
                            this.validationsChangePassword = error.response.data.errors;
                            showToast("warning", "Revisar los datos ingresados");
                        }
                    }).finally((response) => {
                        loading(false);
                    });
                }
            });
        },
        clearDataChangePassword: function (){
            this.idUser = 0;
            this.password = '';
            this.rePassword = '';
            this.showErrorsChangePassword = false;
            this.validationsChangePassword = {};
        }
    },
});


