/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************************************!*\
  !*** ./resources/js/project_scripts/purchase/index.js ***!
  \********************************************************/
var vue = new Vue({
  el: '#index',
  components: {},
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
    showErrorListProduct: false
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
          console.log(this.viewModelToDelete);
          break;

        case 'store':
          if (response) {
            showToast('success', 'Operación realizada correctamente');
            $('#PurchaseModal').modal('hide');
            this.initList();
          } else {
            showToast('error', 'Ocurrió un error al guardar el registro');
          }

          break;

        case 'checkFormDetail':
          if (response) {
            this.listDetail.push(this.viewModelDetail);
            this.viewModelDetail = {};
            showToast('success', 'Operación realizada correctamente');
          } else {
            showToast('error', 'Ocurrió un error al guardar el registro');
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
      var idPurchase = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
      this.clearData();

      if (idPurchase === 0) {
        this.modalTitle = 'Registrar nueva compra';
        this.buttonModalTitle = 'Guardar';
        this.initFormCreate();
      }

      $('#PurchaseModal').modal('show');
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
    initFormDetail: function initFormDetail(idPurchase, callback) {
      var _this3 = this;

      loading(true);
      var url = this.url + "/jsonDetail/" + idPurchase;
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

      if (action === 'store') {
        if (this.listDetail === null) {
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
    softDelete: function softDelete(idPurchase) {
      var _this5 = this;

      this.$swal({
        icon: 'warning'
      }).then(function (result) {
        if (result.value) {
          var context = _this5;

          _this5.initFormDetail(idPurchase, function () {
            context.viewModelToDelete.state = false;
            context.save('softDelete');
          });
        }
      });
    },
    getDataProduct: function getDataProduct() {
      var _this6 = this;

      var productSelected = this.productsDropdown.filter(function (item) {
        return item.value === _this6.viewModelDetail.idProduct;
      });
      this.viewModelDetail.unitSymbol = productSelected[0].unitSymbol;
      this.viewModelDetail.productName = productSelected[0].text;
    },
    addViewModelDetail: function addViewModelDetail() {
      var _this7 = this;

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
      this.listDetail = [];
      this.clearErrorsDetail();
      this.clearErrors();
    },
    deleteProduct: function deleteProduct(index) {
      this.listDetail.splice(index);
    },
    showModalDetail: function showModalDetail(detail, totalPrice) {
      this.purchaseDetail = detail;
      this.purchaseDetail.totalPrice = totalPrice;
      $('#PurchaseDetailModal').modal('show');
    }
  }
});
/******/ })()
;