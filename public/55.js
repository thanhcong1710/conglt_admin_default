(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[55],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/coreui/src/views/menuElements/EditMenu_old.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/coreui/src/views/menuElements/EditMenu_old.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./resources/coreui/node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'TheSidebar',
  data: function data() {
    return {
      isRoleSelected: false,
      roleSelected: 'guest',
      roles: [],
      buffor: [],
      tableData: [],
      fields: ['assigned', 'dropdown', 'slug', 'name'],
      thisMenuRole: null
    };
  },
  methods: {
    addElementToBuffor: function addElementToBuffor(data, icon) {
      this.buffor.push({
        dropdown: icon,
        name: data['name'],
        id: data['id'],
        slug: data['slug'],
        assigned: data['assigned']
      });
    },
    innerBuildArrayData: function innerBuildArrayData(data, deep) {
      for (var i = 0; i < data.length; i++) {
        switch (data[i]['slug']) {
          case 'link':
            if (deep > 1) {
              this.addElementToBuffor(data[i], true);
            } else {
              this.addElementToBuffor(data[i], false);
            }

            break;

          case 'title':
            this.addElementToBuffor(data[i], false);
            break;

          case 'dropdown':
            this.addElementToBuffor(data[i], false);
            this.innerBuildArrayData(data[i]['elements'], deep + 1);
            break;
        }
      }
    },
    buildArrayData: function buildArrayData(data) {
      this.buffor = [];
      this.innerBuildArrayData(data, 1);
      return this.buffor;
    },
    selectRole: function selectRole() {
      var self = this;
      console.log(this.roleSelected);
      axios__WEBPACK_IMPORTED_MODULE_0___default.a.get('/api/menu/edit/selected?token=' + localStorage.getItem("api_token") + '&role=' + this.roleSelected).then(function (response) {
        self.tableData = self.buildArrayData(response.data.menuToEdit);
        self.thisMenuRole = response.data.role;
        self.isRoleSelected = true;
      })["catch"](function (error) {
        console.log(error);
        self.$router.push({
          path: '/login'
        });
      });
    },
    toggleElement: function toggleElement(id) {
      var self = this;
      axios__WEBPACK_IMPORTED_MODULE_0___default.a.get('/api/menu/edit/selected/switch?token=' + localStorage.getItem("api_token") + '&role=' + this.thisMenuRole + '&id=' + id).then(function (response) {
        self.selectRole();
      })["catch"](function (error) {
        console.log(error);
        self.$router.push({
          path: '/login'
        });
      });
    }
  },
  mounted: function mounted() {
    var _this = this;

    this.$root.$on('toggle-sidebar', function () {
      return _this.show = !_this.show;
    });
    var self = this;
    axios__WEBPACK_IMPORTED_MODULE_0___default.a.get('/api/menu/edit?token=' + localStorage.getItem("api_token")).then(function (response) {
      self.roles = response.data.roles;
    })["catch"](function (error) {
      console.log(error);
      self.$router.push({
        path: '/login'
      });
    });
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/coreui/src/views/menuElements/EditMenu_old.vue?vue&type=template&id=4c12341a&":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/coreui/src/views/menuElements/EditMenu_old.vue?vue&type=template&id=4c12341a& ***!
  \*******************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "CRow",
    [
      _c(
        "CCol",
        { attrs: { col: "12", xl: "6" } },
        [
          _c(
            "transition",
            { attrs: { name: "slide" } },
            [
              _c(
                "CCard",
                [
                  _c("CCardBody", [
                    !_vm.isRoleSelected
                      ? _c(
                          "div",
                          [
                            _c("CSelect", {
                              attrs: {
                                value: _vm.roleSelected,
                                options: _vm.roles,
                                label: "Select role assigned to menu"
                              },
                              on: {
                                "update:value": function($event) {
                                  _vm.roleSelected = $event
                                }
                              }
                            }),
                            _vm._v(" "),
                            _c(
                              "CButton",
                              {
                                attrs: { color: "primary" },
                                on: {
                                  click: function($event) {
                                    return _vm.selectRole()
                                  }
                                }
                              },
                              [_vm._v("Edit")]
                            )
                          ],
                          1
                        )
                      : _c(
                          "div",
                          [
                            _c("CDataTable", {
                              attrs: {
                                hover: "",
                                items: _vm.tableData,
                                fields: _vm.fields
                              },
                              scopedSlots: _vm._u([
                                {
                                  key: "assigned",
                                  fn: function(ref) {
                                    var item = ref.item
                                    return [
                                      item.assigned
                                        ? _c(
                                            "td",
                                            [
                                              _c(
                                                "CButton",
                                                {
                                                  attrs: { color: "primary" },
                                                  on: {
                                                    click: function($event) {
                                                      return _vm.toggleElement(
                                                        item.id
                                                      )
                                                    }
                                                  }
                                                },
                                                [_vm._v("Hide")]
                                              )
                                            ],
                                            1
                                          )
                                        : _c(
                                            "td",
                                            [
                                              _c(
                                                "CButton",
                                                {
                                                  attrs: { color: "danger" },
                                                  on: {
                                                    click: function($event) {
                                                      return _vm.toggleElement(
                                                        item.id
                                                      )
                                                    }
                                                  }
                                                },
                                                [_vm._v("Show")]
                                              )
                                            ],
                                            1
                                          )
                                    ]
                                  }
                                },
                                {
                                  key: "dropdown",
                                  fn: function(ref) {
                                    var item = ref.item
                                    return [
                                      _c("td", [
                                        item.dropdown
                                          ? _c("i", {
                                              staticClass:
                                                "cui-chevron-right icons font-2xl d-block"
                                            })
                                          : _vm._e()
                                      ])
                                    ]
                                  }
                                }
                              ])
                            })
                          ],
                          1
                        )
                  ])
                ],
                1
              )
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/coreui/src/views/menuElements/EditMenu_old.vue":
/*!******************************************************************!*\
  !*** ./resources/coreui/src/views/menuElements/EditMenu_old.vue ***!
  \******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _EditMenu_old_vue_vue_type_template_id_4c12341a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EditMenu_old.vue?vue&type=template&id=4c12341a& */ "./resources/coreui/src/views/menuElements/EditMenu_old.vue?vue&type=template&id=4c12341a&");
/* harmony import */ var _EditMenu_old_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EditMenu_old.vue?vue&type=script&lang=js& */ "./resources/coreui/src/views/menuElements/EditMenu_old.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _EditMenu_old_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _EditMenu_old_vue_vue_type_template_id_4c12341a___WEBPACK_IMPORTED_MODULE_0__["render"],
  _EditMenu_old_vue_vue_type_template_id_4c12341a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/coreui/src/views/menuElements/EditMenu_old.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/coreui/src/views/menuElements/EditMenu_old.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/coreui/src/views/menuElements/EditMenu_old.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditMenu_old_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./EditMenu_old.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/coreui/src/views/menuElements/EditMenu_old.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditMenu_old_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/coreui/src/views/menuElements/EditMenu_old.vue?vue&type=template&id=4c12341a&":
/*!*************************************************************************************************!*\
  !*** ./resources/coreui/src/views/menuElements/EditMenu_old.vue?vue&type=template&id=4c12341a& ***!
  \*************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditMenu_old_vue_vue_type_template_id_4c12341a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./EditMenu_old.vue?vue&type=template&id=4c12341a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/coreui/src/views/menuElements/EditMenu_old.vue?vue&type=template&id=4c12341a&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditMenu_old_vue_vue_type_template_id_4c12341a___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditMenu_old_vue_vue_type_template_id_4c12341a___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);