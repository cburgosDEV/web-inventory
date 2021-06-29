/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************************************!*\
  !*** ./resources/js/project_scripts/product_category/index.js ***!
  \****************************************************************/
var vue = new Vue({
  el: '#index',
  components: {},
  data: {
    url: $('#baseUrl').val() + 'product_category',
    filterText: '',
    categories: [],
    paginate: {},
    viewModel: {},
    validations: {},
    showError: false,
    modalTile: '',
    buttonModalTile: ''
  },
  computed: {},
  created: function created() {
    this.initList();
  },
  methods: {
    switchResponseServer: function switchResponseServer(switchAction, response) {
      switch (switchAction) {
        case 'initList':
          this.categories = response.model;
          this.paginate = response.paginate;
          break;

        case 'jsonCreate':
          this.viewModel = response;
          break;

        case 'store':
          if (response) {
            showToast('success', 'Operación realizada correctamente');
            this.initList();
            $('#ProductCategoryModal').modal('hide');
          } else {
            showToast('error', 'Ocurrió un error al guardar el registro');
          }

          break;

        case 'jsonDetail':
          this.viewModel = response;
          break;
      }
    },
    initList: function initList() {
      var _this = this;

      var page = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
      loading(true);
      var url = this.url + "/jsonIndex/" + this.filterText + '?page=' + page;
      window.axios.get(url).then(function (response) {
        _this.switchResponseServer("initList", response.data);
      })["catch"](function (error) {})["finally"](function (response) {
        loading(false);
      });
    },
    search: function search(filterText) {
      this.filterText = filterText;
      this.initList();
    },
    showModal: function showModal() {
      var idProductCategory = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
      this.clearData();

      if (idProductCategory === 0) {
        this.modalTile = 'Crear nuevo';
        this.buttonModalTile = 'Guardar';
        this.initFormCreate();
      } else {
        this.modalTile = 'Detalle';
        this.buttonModalTile = 'Actualizar';
        this.initFormDetail(idProductCategory);
      }

      $('#ProductCategoryModal').modal('show');
    },
    initFormCreate: function initFormCreate() {
      var _this2 = this;

      loading(true);
      var url = this.url + "/jsonCreate";
      window.axios.get(url).then(function (response) {
        _this2.switchResponseServer("jsonCreate", response.data);
      })["catch"](function (error) {})["finally"](function (response) {
        loading(false);
      });
    },
    initFormDetail: function initFormDetail(idProductCategory, callback) {
      var _this3 = this;

      loading(true);
      var url = this.url + "/jsonDetail/" + idProductCategory;
      window.axios.get(url).then(function (response) {
        _this3.switchResponseServer("jsonDetail", response.data);
      })["catch"](function (error) {})["finally"](function (response) {
        loading(false);

        if (callback) {
          callback();
        }
      });
    },
    save: function save() {
      var _this4 = this;

      loading(true);
      var url = this.url + "/store";
      window.axios.post(url, this.viewModel).then(function (response) {
        _this4.switchResponseServer("store", response.data);
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this4.showError = true;
          _this4.validations = error.response.data.errors;
        }

        showToast('error', 'Revisar los datos ingresados');
      })["finally"](function (response) {
        loading(false);
      });
    },
    softDelete: function softDelete(idProductCategory) {
      var _this5 = this;

      this.$swal({
        icon: 'warning'
      }).then(function (result) {
        if (result.value) {
          var context = _this5;

          _this5.initFormDetail(idProductCategory, function () {
            context.viewModel.state = false;
            context.save();
          });
        }
      });
    },
    clearData: function clearData() {
      this.showError = false;
      this.validations = {};
      this.viewModel = {};
      this.modalTile = '';
      this.buttonModalTile = '';
    }
  }
});
/******/ })()
;