/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************************!*\
  !*** ./resources/js/project_scripts/sale/index.js ***!
  \****************************************************/
var vue = new Vue({
  el: '#index',
  components: {},
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
  computed: {
    subTotal: function subTotal() {
      return this.viewModelDetail.subTotal = (this.viewModelDetail.unitaryPrice * this.viewModelDetail.quantity || 0).toFixed(2);
    },
    totalPrice: function totalPrice() {
      return this.viewModel.totalPrice = this.listDetail === null ? 0 : this.listDetail.reduce(function (total, detail) {
        return total + parseFloat(detail.subTotal);
      }, 0);
    }
  },
  created: function created() {
    this.initList();
  },
  methods: {
    switchResponseServer: function switchResponseServer(switchAction, response) {
      switch (switchAction) {
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
          if (response) {
            showToast('success', 'Operación realizada correctamente');
            $('#SaleModal').modal('hide');
            this.initList();
          } else {
            showToast('error', 'No se pudo realizar la venta');
          }
          break;
        case 'checkFormDetail':
          if (response) {
            this.listDetail.push(this.viewModelDetail);
            this.removeProductFromDropdown(this.viewModelDetail.idProduct);
            this.viewModelDetail = {};
            showToast('success', 'Producto agregado correctamente');
          } else {
            showToast('error', 'Ocurrió un error al agregar el producto');
          }
          break;
        case 'getDataProduct':
          if (response) {
            this.viewModelDetail = response;
          }
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
      var idSale = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
      this.clearData();
      if (idSale === 0) {
        this.modalTitle = 'Registrar nueva venta';
        this.buttonModalTitle = 'Guardar';
        this.initFormCreate();
      }
      $('#SaleModal').modal('show');
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
    initFormDetail: function initFormDetail(idSale, callback) {
      var _this3 = this;
      loading(true);
      var url = this.url + "/jsonDetail/" + idSale;
      window.axios.get(url).then(function (response) {
        _this3.switchResponseServer("jsonDetail", response.data);
      })["catch"](function (error) {})["finally"](function (response) {
        loading(false);
        if (callback) {
          callback();
        }
      });
    },
    save: function save(action) {
      var _this4 = this;
      var data = {};
      this.clearErrors();
      if (action === 'store') {
        if (this.listDetail === null) {
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
      var url = this.url + "/store";
      window.axios.post(url, data).then(function (response) {
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
    softDelete: function softDelete(idSale) {
      var _this5 = this;
      this.$swal({
        icon: 'warning'
      }).then(function (result) {
        if (result.value) {
          var context = _this5;
          _this5.initFormDetail(idSale, function () {
            context.viewModelToDelete.state = false;
            context.save('softDelete');
          });
        }
      });
    },
    getDataProduct: function getDataProduct() {
      var _this6 = this;
      loading(true);
      this.clearErrorsDetail();
      if (this.viewModelDetail.idProduct === undefined) return;
      var url = this.url + "/jsonProduct/" + this.viewModelDetail.idProduct;
      window.axios.get(url).then(function (response) {
        _this6.switchResponseServer("getDataProduct", response.data);
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this6.showErrorDetail = true;
          _this6.validationsDetail = error.response.data.errors;
        }
        showToast('error', 'Revisar los datos ingresados');
      })["finally"](function (response) {
        loading(false);
      });
    },
    addViewModelDetail: function addViewModelDetail() {
      var _this7 = this;
      this.clearErrors();
      this.clearErrorsDetail();
      loading(true);
      var url = this.url + "/checkFormDetail";
      window.axios.post(url, this.viewModelDetail).then(function (response) {
        _this7.switchResponseServer("checkFormDetail", response.data);
      })["catch"](function (error) {
        if (error.response.status === 422) {
          _this7.showErrorDetail = true;
          _this7.validationsDetail = error.response.data.errors;
        }
        showToast('error', 'Revisar los datos ingresados');
      })["finally"](function (response) {
        loading(false);
      });
    },
    clearErrors: function clearErrors() {
      this.validations = {};
      this.showError = false;
    },
    clearErrorsDetail: function clearErrorsDetail() {
      this.showErrorDetail = false;
      this.validationsDetail = [];
      this.showErrorListProduct = false;
    },
    clearData: function clearData() {
      this.modalTitle = '';
      this.buttonModalTitle = '';
      this.viewModel = {};
      this.viewModelDetail = {};
      this.listDetail = [];
      this.clearErrorsDetail();
      this.clearErrors();
    },
    deleteProduct: function deleteProduct(index, idProduct) {
      this.listDetail.splice(index);
      this.addProductToDropdown(idProduct);
    },
    showModalDetail: function showModalDetail(detail, totalPrice) {
      this.saleDetail = detail;
      this.saleDetail.totalPrice = totalPrice;
      $('#SaleDetailModal').modal('show');
    },
    removeProductFromDropdown: function removeProductFromDropdown(idProduct) {
      for (var i = 0; i < this.productsDropdown.length; i++) {
        if (this.productsDropdown[i].value === idProduct) {
          this.listDetailDelete.push(this.productsDropdown[i]);
          this.productsDropdown.splice(i, 1);
        }
      }
    },
    addProductToDropdown: function addProductToDropdown(idProduct) {
      for (var i = 0; i < this.listDetailDelete.length; i++) {
        if (this.listDetailDelete[i].value === idProduct) {
          this.productsDropdown.push(this.listDetailDelete[i]);
          this.listDetailDelete.splice(i, 1);
        }
      }
    }
  }
});
/******/ })()
;