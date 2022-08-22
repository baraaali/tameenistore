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

/***/ "./resources/js/custom.js":
/*!********************************!*\
  !*** ./resources/js/custom.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var csrf = $('meta[name="csrf-token"]').attr('content');
var lang = $('meta[name="lang"]').attr('content');
var user_id = $('meta[name="user_id"]').attr('content');

var init = function init() {
  searchAll();
  $('[data-toggle="tooltip"]').tooltip();
  $('.select2').select2();
  var items = $('.items').attr('items') ? parseInt($('.items').attr('items')) : 4;
  var autoplayAttr = $('.items').attr('autoplayAttr') != 'false';
  var nav = $('.items').attr('nav') != 'false';
  var navText = $('.items').attr('navText') == 'true' ? ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'] : [];
  var loopAttr = $('.items').attr('loopAttr') != 'false';
  $(".items").owlCarousel({
    items: items,
    loop: loopAttr,
    margin: 10,
    navText: navText,
    autoplay: autoplayAttr,
    autoplayTimeout: 2500,
    autoplayHoverPause: true,
    nav: nav,
    dots: false,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
        nav: true,
        autoplay: autoplayAttr,
        autoplayTimeout: 2500
      },
      600: {
        items: 3,
        nav: true,
        autoplay: autoplayAttr,
        autoplayTimeout: 2500
      },
      1000: {
        items: items,
        nav: nav,
        autoplay: autoplayAttr,
        autoplayTimeout: 2500
      }
    }
  });
  $(".banners").owlCarousel({
    items: 1,
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 2500,
    autoplayHoverPause: true,
    nav: true,
    dots: false
  });
  var items = parseInt($('.items-sub').attr('items'));
  $(".items-sub").owlCarousel({
    items: items,
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 2500,
    autoplayHoverPause: true,
    nav: false,
    dots: false
  }); // $('#main_country').on('change',function(){
  //     if(parseInt($(this).val()) != parseInt($('#selected_country').val()))
  //     location.href = '/set-country/'+ $(this).val()
  // })

  $("#loading").hide();
};

$(document).ready(function () {
  init();
}); // search into website function

function searchAll() {
  $('#search-field').on('input', function () {
    var searchValue = $(this).val();
    var output = $("#search-box ul");
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': csrf
      },
      url: "/search/keyword",
      type: 'post',
      data: {
        searchValue: searchValue
      },
      success: function success(res) {
        var html = "";

        if (res.length) {
          var data = res.slice(0, 10);
          data.forEach(function (e) {
            var name = e[lang + '_name'] ? e[lang + '_name'] : e[lang + '_name'];
            var target = '';

            if (e['_target'] === 'items') {
              target = '/commercial-ad/' + e['id'] + '/' + lang;
            } else if (e['_target'] === 'cars' && e['sell'] == 1) {
              target = '/vehicles/sell/view/' + e['id'] + '/' + lang;
            } else if (e['_target'] === 'cars' && e['sell'] == 0) {
              target = '/vehicles/rent/view/' + e['id'] + '/' + lang;
            } else if (e['_target'] === 'mcenters') {
              target = '/view/mcenters/profil/' + e['id'] + '/' + lang;
            } else if (e['_target'] === 'services') {
              target = '/services-single/items/' + e['id'] + '/' + lang;
            }

            html += "<li class=\"list-group-item\"><a href=\"".concat(target, "\">").concat(name, "</a></li>");
          });
        }

        output.html(html);
      },
      error: function error($e) {
        console.log($e);
      }
    });
  });
} // -----------------------------------------------------------------------


window.setLike = function ($this, model) {
  var ad_id = parseInt($this.attr('ad_id'));

  if (user_id) {
    var data = {
      model: model,
      ad_id: ad_id
    }; // console.log(data);

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': csrf
      },
      url: "/actions/like",
      type: 'post',
      data: data,
      success: function success(res) {
        if (res.heart == 1) {
          $this.find('.heart').html('<i class="fa fa-heart text-danger mx-1" aria-hidden="true"></i>');
        } else {
          $this.find('.heart').html('<i class="far fa-heart text-danger mx-1" aria-hidden="true"></i>');
        }

        $this.find('.count').html(res.count);
      },
      error: function error($e) {
        console.log($e);
      }
    });
  }
};

/***/ }),

/***/ 1:
/*!**************************************!*\
  !*** multi ./resources/js/custom.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! E:\www\mostaqil\tameensistore\repo\resources\js\custom.js */"./resources/js/custom.js");


/***/ })

/******/ });