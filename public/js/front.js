/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/front-assets/js/app.js":
/*!******************************************!*\
  !*** ./resources/front-assets/js/app.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  /*
   * DELETE FORM SUBMIT
   */
  $('.btn-delete').click(function (e) {
    e.preventDefault();

    if (confirm('Are you sure ?')) {
      var frm = $(e.currentTarget).attr('form') || 'form-delete';
      var url = $(e.currentTarget).attr('href') || $(e.currentTarget).attr('data-delete-url');
      $('#' + frm).attr('action', url).submit();
    }
  });
  $('[data-submit-form]').click(function (e) {
    e.preventDefault();
    var needConfirm = $(e.currentTarget).attr('data-submit-noconfirm') === undefined;
    if (needConfirm && !confirm('Are you sure ?')) return;
    var frm = $(e.currentTarget).attr('data-submit-form');
    var url = $(e.currentTarget).attr('[data-submit-url]') || $(e.currentTarget).attr('href');
    if (!frm || !url) return;
    $('#' + frm).attr('action', url).submit();
  });

  function onShippingTypeChange(regionId) {
    $('#shipping_id option[data-region-id]').css('display', 'none');
    $("#shipping_id option[data-region-id=".concat(regionId, "]")).css('display', 'inline');
    $('#shipping_id').val('');
  }

  function parseToFloat(nb) {
    var amount = Number.parseFloat(nb);

    if (Number.isNaN(amount)) {
      amount = 0;
    }

    return amount;
  }

  onShippingTypeChange($('#shipping_region_id').val());
  var subTotal = parseToFloat($('#cartSubtotal').text());
  $('#shipping_region_id').change(function (e) {
    var val = e.currentTarget.value;
    onShippingTypeChange(val);
  });
  $('#shipping_id').change(function (e) {
    var region_id = $('#shipping_id').val();
    var shippingAmount = $(e.currentTarget).children("option[value=\"".concat(region_id, "\"]")).attr('data-cost');
    shippingAmount = parseToFloat(shippingAmount);

    if (shippingAmount < 0.0001) {
      $('#shippingAmount').text('Free');
      $('#cartTotal').text(subTotal);
    } else {
      $('#shippingAmount').text(shippingAmount);
      var total = shippingAmount + subTotal;
      $('#cartTotal').text(total.toFixed(2));
    }
  });
});

/***/ }),

/***/ 1:
/*!************************************************!*\
  !*** multi ./resources/front-assets/js/app.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/ulrich/devlab/projects/UA/ecom-turing/code/resources/front-assets/js/app.js */"./resources/front-assets/js/app.js");


/***/ })

/******/ });