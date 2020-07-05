(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[8],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/favoris/FavorisComponent.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/favoris/FavorisComponent.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

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
  data: function data() {
    return {
      typeSelected: 'tous',
      lstExercices: [],
      page: 1,
      perPage: 9,
      pages: [],
      lastTypeSelected: 'btn-tous',
      lstObjectifsSelected: [],
      exercicesByUser: [],
      isLoading: true
    };
  },
  methods: _objectSpread({
    deleteExerciceFavoris: function deleteExerciceFavoris(id, index) {
      var _this = this;

      axios["delete"]('/favoris/delete-exercice/' + id).then(function (response) {
        _this.lstExercices.splice(index, 1);
      });
    },
    filtrerParType: function filtrerParType(type) {
      if (type) {
        this.lastTypeSelected = type;
        var lstExercicesByType = [];
        this.exercicesByUser.forEach(function (exe) {
          if (exe.typesexcercice_id === type) {
            lstExercicesByType.push(exe);
          }
        });
        this.initPages();
        this.lstExercices = lstExercicesByType;
      } else {
        this.lastTypeSelected = 'btn-tous';
        this.lstExercices = this.exercicesByUser;
      }

      this.$root.$emit('filtredByType');
    },
    filtrerParPrivate: function filtrerParPrivate() {
      var lstExercicesPrivates = [];
      this.lastTypeSelected = 'btn-private';
      this.exercicesByUser.forEach(function (exe) {
        if (exe["private"] === 1) {
          lstExercicesPrivates.push(exe);
        }
      });
      this.initPages();
      this.lstExercices = lstExercicesPrivates;
      this.$root.$emit('filtredByType');
    },
    filtrerParObjectifs: function filtrerParObjectifs(objectif) {
      var _this2 = this;

      var lstExercicesByObjectif = []; //vérifier si l'objectif est déjà dans la liste, si c'est le cas il faut le supprimer, l'ajouter sinon

      if (this.lstObjectifsSelected.includes(objectif)) {
        var index = this.lstObjectifsSelected.indexOf(objectif);
        this.lstObjectifsSelected.splice(index, 1);
      } else {
        this.lstObjectifsSelected.push(objectif);
      } //il faut filtrer la liste d'exercices seuelement s'il y a des objestifs sélectionnés


      if (this.lstObjectifsSelected.length > 0) {
        var lstExercicesFiltred = this.getLstExercicesFiltredByType();
        lstExercicesFiltred.forEach(function (exe) {
          exe.objectifs.forEach(function (obj) {
            if (_this2.lstObjectifsSelected.includes(obj.id)) {
              var isExeAdded = lstExercicesByObjectif.find(function (exercice) {
                return exercice.id === exe.id;
              });

              if (!isExeAdded) {
                lstExercicesByObjectif.push(exe);
              }
            }
          });
        });
        this.initPages();
        this.lstExercices = lstExercicesByObjectif;
      } else {
        if (this.lastTypeSelected === 'btn-private') {
          this.filtrerParPrivate();
        } else if (this.lastTypeSelected === 'btn-tous') {
          this.filtrerParType(null);
        } else {
          this.filtrerParType(this.lastTypeSelected);
        }
      }
    },
    getLstExercicesFiltredByType: function getLstExercicesFiltredByType() {
      var _this3 = this;

      var retval = [];

      if (this.lastTypeSelected === 'btn-private') {
        retval = this.exercicesByUser.filter(function (e) {
          return e["private"] === 1;
        });
      } else if (this.lastTypeSelected === 'btn-tous') {
        retval = this.exercicesByUser;
      } else {
        retval = this.exercicesByUser.filter(function (e) {
          return e.typesexcercice_id === _this3.lastTypeSelected;
        });
      }

      return retval;
    },
    initPages: function initPages() {
      this.page = 1;
      this.perPage = 9;
      this.pages = [];
    },
    setPages: function setPages() {
      var numberOfPages = Math.ceil(this.lstExercices.length / this.perPage);

      if (numberOfPages > 1) {
        for (var index = 1; index <= numberOfPages; index++) {
          this.pages.push(index);
        }
      }
    },
    paginate: function paginate(exercices) {
      var page = this.page;
      var perPage = this.perPage;
      var from = page * perPage - perPage;
      var to = page * perPage;
      return exercices.slice(from, to);
    }
  }, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapActions"])(['loadAllObjectifs', 'loadAllTypes'])),
  computed: _objectSpread({
    displayedExercices: function displayedExercices() {
      return this.paginate(this.lstExercices);
    }
  }, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapState"])(['lstAllTypes', 'lstAllObjectifs'])),
  watch: {
    lstExercices: function lstExercices() {
      this.setPages();
    }
  },
  filters: {
    trimWords: function trimWords(value) {
      return value.split(" ").splice(0, 20).join(" ") + '...';
    }
  },
  mounted: function mounted() {
    var _this4 = this;

    this.isLoading = true; //récupérer la liste de favoris

    axios.get('/favoris/get-favoris-by-user').then(function (reponse) {
      _this4.exercicesByUser = reponse.data.favoris;
      _this4.lstExercices = reponse.data.favoris;
      _this4.isLoading = false;
    })["catch"](function (error) {
      console.log(error);
      _this4.isLoading = false;
    }); //load le type d'exercice et les objectifs

    this.loadAllTypes();
    this.loadAllObjectifs();
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/favoris/FavorisComponent.vue?vue&type=template&id=ac0bfd4a&scoped=true&":
/*!**********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/favoris/FavorisComponent.vue?vue&type=template&id=ac0bfd4a&scoped=true& ***!
  \**********************************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "mes-favoris" }, [
    _c(
      "div",
      { staticClass: "loading" },
      [
        _c("bounce", {
          directives: [
            {
              name: "show",
              rawName: "v-show",
              value: _vm.isLoading,
              expression: "isLoading"
            }
          ],
          attrs: { color: "17b87d" }
        })
      ],
      1
    ),
    _vm._v(" "),
    !_vm.isLoading
      ? _c("div", [
          _c("div", { staticClass: "actions" }, [
            _c("h5", [_vm._v("Filtrer par type")]),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "btn-group" },
              [
                _c(
                  "button",
                  {
                    staticClass: "btn btn-g btn-soccer-coach-action",
                    class: {
                      "btn-g-selected": _vm.lastTypeSelected === "btn-tous"
                    },
                    attrs: { type: "button", id: "btn-tous" },
                    on: {
                      click: function($event) {
                        return _vm.filtrerParType(null)
                      }
                    }
                  },
                  [
                    _c("i", { staticClass: "ti-star" }),
                    _vm._v(" Tous\n                ")
                  ]
                ),
                _vm._v(" "),
                _vm._l(_vm.lstAllTypes, function(type) {
                  return _c(
                    "button",
                    {
                      key: type.id,
                      staticClass: "btn btn-g btn-soccer-coach-action",
                      class: {
                        "btn-g-selected": _vm.lastTypeSelected === type.id
                      },
                      attrs: { type: "button", id: "type-" + type.id },
                      on: {
                        click: function($event) {
                          return _vm.filtrerParType(type.id)
                        }
                      }
                    },
                    [
                      _c("i", { class: type.icon }),
                      _vm._v(" " + _vm._s(type.nom) + "\n                ")
                    ]
                  )
                }),
                _vm._v(" "),
                _c(
                  "button",
                  {
                    staticClass: "btn btn-g btn-soccer-coach-action",
                    class: {
                      "btn-g-selected": _vm.lastTypeSelected === "btn-private"
                    },
                    attrs: { type: "button" },
                    on: {
                      click: function($event) {
                        return _vm.filtrerParPrivate()
                      }
                    }
                  },
                  [
                    _c("i", { staticClass: "ti-key" }),
                    _vm._v(" Privées\n                ")
                  ]
                )
              ],
              2
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "mt-3" },
              [
                _c("filter-by-objectif", {
                  attrs: {
                    objectifs: _vm.lstAllObjectifs,
                    "set-filter": true,
                    "show-btn-filter": true,
                    "class-custom": "filter-action",
                    "on-method-filter": _vm.filtrerParObjectifs
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c("h3", [_vm._v("MES FAVORIS")]),
          _vm._v(" "),
          _c("h6", [
            _vm._v("Nombre d'exercices: " + _vm._s(_vm.lstExercices.length))
          ]),
          _vm._v(" "),
          _c(
            "div",
            {
              staticClass: "row lst-exercices",
              class: { "lst-vide": _vm.lstExercices.length === 0 }
            },
            [
              _vm.lstExercices.length === 0
                ? _c("span", { staticClass: "aucun-exercice" }, [
                    _vm._v("Aucun exercice")
                  ])
                : _vm._e(),
              _vm._v(" "),
              _vm._l(_vm.displayedExercices, function(exercice, index) {
                return _c(
                  "div",
                  {
                    key: exercice.id,
                    staticClass: "col-md-4 card card-exercice"
                  },
                  [
                    _c("div", { staticClass: "card-exercice-image" }, [
                      _c("img", {
                        staticClass: "card-img-top img-liste",
                        attrs: {
                          src: "../../images/uploaded/" + exercice.image
                        }
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "bought" }, [
                        _c("i", { class: exercice.typeExercice.icon }),
                        _vm._v(" " + _vm._s(exercice.typeExercice.nom))
                      ]),
                      _vm._v(" "),
                      _c(
                        "a",
                        {
                          staticClass: "btn-delete-favoris",
                          attrs: { alt: "Enlever cet exercice des favoris" },
                          on: {
                            click: function($event) {
                              return _vm.deleteExerciceFavoris(
                                exercice.id,
                                index
                              )
                            }
                          }
                        },
                        [_c("i", { staticClass: "fa fa-heart" })]
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "card-body body-exercice" }, [
                      _c("div", { staticClass: "card-title-principe" }, [
                        _c("h4", { staticClass: "card-title" }, [
                          _vm._v(_vm._s(exercice.principe))
                        ]),
                        _vm._v(" "),
                        _c("h6", [
                          _c("i", {
                            staticClass: "ti-timer color-soccer-coach"
                          }),
                          _vm._v(" " + _vm._s(exercice.time))
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "card-footer footer-exercice" },
                      [
                        _c(
                          "router-link",
                          {
                            staticClass: "btn btn-block btn-soccer-coach",
                            attrs: {
                              to: {
                                name: "DetailExercice",
                                params: {
                                  exercice: exercice,
                                  route: "mes-favoris"
                                }
                              }
                            }
                          },
                          [_vm._v("Voir")]
                        )
                      ],
                      1
                    )
                  ]
                )
              })
            ],
            2
          ),
          _vm._v(" "),
          _c("nav", [
            _c("ul", { staticClass: "pagination" }, [
              _c("li", { staticClass: "page-item" }, [
                _vm.page != 1
                  ? _c(
                      "button",
                      {
                        staticClass: "page-link",
                        attrs: { type: "button" },
                        on: {
                          click: function($event) {
                            _vm.page--
                          }
                        }
                      },
                      [_c("i", { staticClass: "ti-angle-double-left" })]
                    )
                  : _vm._e()
              ]),
              _vm._v(" "),
              _c(
                "li",
                { staticClass: "page-item" },
                _vm._l(_vm.pages.slice(_vm.page - 1, _vm.page + 5), function(
                  pageNumber
                ) {
                  return _c(
                    "button",
                    {
                      key: pageNumber,
                      staticClass: "page-link",
                      attrs: { type: "button" },
                      on: {
                        click: function($event) {
                          _vm.page = pageNumber
                        }
                      }
                    },
                    [_vm._v(" " + _vm._s(pageNumber) + " ")]
                  )
                }),
                0
              ),
              _vm._v(" "),
              _c("li", { staticClass: "page-item" }, [
                _vm.page < _vm.pages.length
                  ? _c(
                      "button",
                      {
                        staticClass: "page-link",
                        attrs: { type: "button" },
                        on: {
                          click: function($event) {
                            _vm.page++
                          }
                        }
                      },
                      [_c("i", { staticClass: "ti-angle-double-right" })]
                    )
                  : _vm._e()
              ])
            ])
          ])
        ])
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/favoris/FavorisComponent.vue":
/*!*********************************************************!*\
  !*** ./resources/js/views/favoris/FavorisComponent.vue ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _FavorisComponent_vue_vue_type_template_id_ac0bfd4a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FavorisComponent.vue?vue&type=template&id=ac0bfd4a&scoped=true& */ "./resources/js/views/favoris/FavorisComponent.vue?vue&type=template&id=ac0bfd4a&scoped=true&");
/* harmony import */ var _FavorisComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FavorisComponent.vue?vue&type=script&lang=js& */ "./resources/js/views/favoris/FavorisComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _FavorisComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _FavorisComponent_vue_vue_type_template_id_ac0bfd4a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _FavorisComponent_vue_vue_type_template_id_ac0bfd4a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "ac0bfd4a",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/favoris/FavorisComponent.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/favoris/FavorisComponent.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/views/favoris/FavorisComponent.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FavorisComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./FavorisComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/favoris/FavorisComponent.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_FavorisComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/favoris/FavorisComponent.vue?vue&type=template&id=ac0bfd4a&scoped=true&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/views/favoris/FavorisComponent.vue?vue&type=template&id=ac0bfd4a&scoped=true& ***!
  \****************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FavorisComponent_vue_vue_type_template_id_ac0bfd4a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./FavorisComponent.vue?vue&type=template&id=ac0bfd4a&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/favoris/FavorisComponent.vue?vue&type=template&id=ac0bfd4a&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FavorisComponent_vue_vue_type_template_id_ac0bfd4a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_FavorisComponent_vue_vue_type_template_id_ac0bfd4a_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);