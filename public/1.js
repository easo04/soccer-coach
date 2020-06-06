(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[1],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/exercice/DetailExercice.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/exercice/DetailExercice.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
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
  props: ['exercice'],
  data: function data() {
    return {
      isLoading: true
    };
  },
  methods: {
    back: function back() {
      this.$router.push('mes-exercices');
    },
    deleteExercice: function deleteExercice() {
      var _this = this;

      axios["delete"]('/exercice/' + this.exercice.id).then(function (reponse) {
        $("#modalDeleteExercice").modal("hide");

        _this.$router.push('mes-exercices');
      });
    }
  },
  created: function created() {
    var _this2 = this;

    if (!this.exercice.variantes && !this.exercice.objectifs) {
      this.exercice.variantes = [];
      this.exercice.objectifs = [];
      this.isLoading = true;
      axios.get('/exercice/outil/get-variantes-and-objectifs/' + this.exercice.id).then(function (reponse) {
        _this2.exercice.variantes = reponse.data.variantes;
        _this2.exercice.objectifs = reponse.data.objectifs;
        _this2.isLoading = false;
      })["catch"](function (error) {
        console.log(error);
        _this2.isLoading = false;
      });
    } else {
      this.isLoading = false;
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/exercice/DetailExercice.vue?vue&type=template&id=41c336d1&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/views/exercice/DetailExercice.vue?vue&type=template&id=41c336d1& ***!
  \*********************************************************************************************************************************************************************************************************************/
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
  return _c("div", { staticClass: "detail-exercice" }, [
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
          _c("div", { staticClass: "contenu-exercices" }, [
            _c("div", { staticClass: "actions-exercice-detail" }, [
              _c("div", { staticClass: "btn-mes-exercices" }, [
                _c(
                  "a",
                  {
                    staticClass: "btn btn-soccer-coach-action",
                    on: { click: _vm.back }
                  },
                  [
                    _c("i", { staticClass: "ti-list" }),
                    _vm._v(" Mes exercices")
                  ]
                )
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "btns" },
                [
                  _vm._m(0),
                  _vm._v(" "),
                  _c(
                    "router-link",
                    {
                      staticClass: "btn btn-soccer-coach-action",
                      attrs: {
                        to: {
                          name: "UpdateExercice",
                          params: { exercice: _vm.exercice }
                        }
                      }
                    },
                    [_c("i", { staticClass: "ti-pencil" }), _vm._v(" Modifier")]
                  ),
                  _vm._v(" "),
                  _vm._m(1)
                ],
                1
              )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row details-exercice" }, [
              _c("div", { staticClass: "col-sm-6 details-exercice-image" }, [
                _c("div", { staticClass: "image-exercice" }, [
                  _c("img", {
                    staticClass: "img-responsive",
                    attrs: { src: "../images/uploaded/" + _vm.exercice.image }
                  })
                ])
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "col-sm-6 details-exercice-info" }, [
                _c("div", { staticClass: "detail bloc-info" }, [
                  _c("h3", [_vm._v(_vm._s(_vm.exercice.principe))]),
                  _vm._v(" "),
                  _c("p", { staticClass: "description-exercice" }, [
                    _vm._v(_vm._s(_vm.exercice.description))
                  ]),
                  _vm._v(" "),
                  _c(
                    "div",
                    {
                      staticClass:
                        "d-flex justify-content-center details-items-info"
                    },
                    [
                      _c("div", { staticClass: "p-flex" }, [
                        _c("p", { staticClass: "text" }, [_vm._v("DURÉE:")]),
                        _vm._v(" "),
                        _c("p", { staticClass: "value" }, [
                          _c("i", {
                            staticClass: "ti-timer color-soccer-coach"
                          }),
                          _vm._v(" " + _vm._s(_vm.exercice.time))
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "p-flex" }, [
                        _c("p", { staticClass: "text" }, [
                          _vm._v("NOMBRE DE JOUEURS:")
                        ]),
                        _vm._v(" "),
                        _c("p", { staticClass: "value" }, [
                          _vm._v(_vm._s(_vm.exercice.nbJoueurs))
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "p-flex" }, [
                        _c("p", { staticClass: "text" }, [_vm._v("TYPE:")]),
                        _vm._v(" "),
                        _c("p", { staticClass: "value" }, [
                          _c("i", {
                            staticClass: "color-soccer-coach",
                            class: _vm.exercice.typeExercice.icon
                          }),
                          _vm._v(" " + _vm._s(_vm.exercice.typeExercice.nom))
                        ])
                      ])
                    ]
                  )
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "row mt-3" }, [
              _vm.exercice.variantes.length > 0
                ? _c(
                    "div",
                    { staticClass: "variantes col-sm-6" },
                    _vm._l(_vm.exercice.variantes, function(variante, index) {
                      return _c(
                        "div",
                        { key: variante.id, staticClass: "variante" },
                        [
                          _c(
                            "div",
                            { staticClass: "variante-header clearfix" },
                            [
                              _c("h5", { staticClass: "float-left" }, [
                                _c("i", {
                                  staticClass: "ti-pin-alt color-soccer-coach"
                                }),
                                _vm._v(" Variante #" + _vm._s(index + 1))
                              ]),
                              _vm._v(" "),
                              _c("h5", { staticClass: "float-right time" }, [
                                _c("i", {
                                  staticClass: "ti-timer color-soccer-coach"
                                }),
                                _vm._v(" " + _vm._s(variante.time))
                              ])
                            ]
                          ),
                          _vm._v(" "),
                          _c("div", { staticClass: "variante-body" }, [
                            _c("p", [_vm._v(_vm._s(variante.description))])
                          ])
                        ]
                      )
                    }),
                    0
                  )
                : _c("div", { staticClass: "col-sm-6" }),
              _vm._v(" "),
              _c("div", { staticClass: "col-sm-6" }, [
                _c(
                  "div",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: _vm.exercice.observations,
                        expression: "exercice.observations"
                      }
                    ],
                    staticClass: "observations-exercice bloc-sm bloc-info"
                  },
                  [
                    _vm._m(2),
                    _vm._v(" "),
                    _c("p", [_vm._v(_vm._s(_vm.exercice.observations))])
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: _vm.exercice.sousPrincipe,
                        expression: "exercice.sousPrincipe"
                      }
                    ],
                    staticClass: "bloc-sm bloc-info"
                  },
                  [
                    _vm._m(3),
                    _vm._v(" "),
                    _c("p", [_vm._v(_vm._s(_vm.exercice.sousPrincipe))])
                  ]
                ),
                _vm._v(" "),
                _c(
                  "div",
                  {
                    directives: [
                      {
                        name: "show",
                        rawName: "v-show",
                        value: _vm.exercice.physique,
                        expression: "exercice.physique"
                      }
                    ],
                    staticClass: "bloc-sm bloc-info"
                  },
                  [
                    _vm._m(4),
                    _vm._v(" "),
                    _c("p", [_vm._v(_vm._s(_vm.exercice.physique))])
                  ]
                ),
                _vm._v(" "),
                _vm.exercice.idVideo
                  ? _c("div", { staticClass: "video" }, [
                      _c("iframe", {
                        attrs: {
                          width: "560",
                          height: "315",
                          src:
                            "https://www.youtube-nocookie.com/embed/" +
                            _vm.exercice.idVideo,
                          frameborder: "0",
                          allow:
                            "accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture",
                          allowfullscreen: ""
                        }
                      })
                    ])
                  : _vm.exercice.url && _vm.exercice.url !== ""
                  ? _c("div", { staticClass: "url" }, [
                      _c("i", { staticClass: "ti-link color-soccer-coach" }),
                      _c(
                        "a",
                        { attrs: { href: _vm.exercice.url, target: "_blank" } },
                        [_vm._v(" " + _vm._s(_vm.exercice.url))]
                      )
                    ])
                  : _vm._e()
              ])
            ]),
            _vm._v(" "),
            _c(
              "div",
              {
                directives: [
                  {
                    name: "show",
                    rawName: "v-show",
                    value: _vm.exercice.objectifs.length > 0,
                    expression: "exercice.objectifs.length > 0"
                  }
                ],
                staticClass: "mt-3"
              },
              [
                _vm._m(5),
                _vm._v(" "),
                _c("objectifs-by-exercice", {
                  attrs: { objectifs: _vm.exercice.objectifs }
                })
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "modal", attrs: { id: "modalDeleteExercice" } },
              [
                _c("div", { staticClass: "modal-dialog" }, [
                  _c("div", { staticClass: "modal-content" }, [
                    _vm._m(6),
                    _vm._v(" "),
                    _c("div", { staticClass: "modal-body" }, [
                      _vm._v(
                        "\n                            Voulez-vous supprimer l'exercice "
                      ),
                      _c("span", [_vm._v(_vm._s(_vm.exercice.principe))]),
                      _vm._v("?\n                        ")
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "modal-footer" }, [
                      _c(
                        "a",
                        {
                          staticClass: "btn btn-soccer-coach-action",
                          on: {
                            click: function($event) {
                              return _vm.deleteExercice()
                            }
                          }
                        },
                        [
                          _c("i", { staticClass: "ti-trash" }),
                          _vm._v(" Supprimer")
                        ]
                      )
                    ])
                  ])
                ])
              ]
            )
          ])
        ])
      : _vm._e()
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "a",
      { staticClass: "btn btn-soccer-coach-action", attrs: { href: "#" } },
      [_c("i", { staticClass: "fa fa-file-pdf-o" }), _vm._v(" Télecharger")]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "a",
      {
        staticClass: "btn btn-soccer-coach-action",
        attrs: { "data-toggle": "modal", "data-target": "#modalDeleteExercice" }
      },
      [_c("i", { staticClass: "ti-trash" }), _vm._v(" Supprimer")]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("h5", [
      _c("i", { staticClass: "ti-eye color-soccer-coach" }),
      _vm._v(" Observations")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("h5", [
      _c("i", { staticClass: "ti-flag color-soccer-coach" }),
      _vm._v(" Sous-principes")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("h5", [
      _c("i", { staticClass: "ti-heart color-soccer-coach" }),
      _vm._v(" Objectifs physiques")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("h5", [
      _c("i", { staticClass: "ti-tag color-soccer-coach" }),
      _vm._v(" Objectifs")
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-header" }, [
      _c("h4", { staticClass: "modal-title" }, [_vm._v("Supprimer exercice")]),
      _vm._v(" "),
      _c(
        "button",
        {
          staticClass: "close",
          attrs: { type: "button", "data-dismiss": "modal" }
        },
        [_vm._v("×")]
      )
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/views/exercice/DetailExercice.vue":
/*!********************************************************!*\
  !*** ./resources/js/views/exercice/DetailExercice.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _DetailExercice_vue_vue_type_template_id_41c336d1___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DetailExercice.vue?vue&type=template&id=41c336d1& */ "./resources/js/views/exercice/DetailExercice.vue?vue&type=template&id=41c336d1&");
/* harmony import */ var _DetailExercice_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DetailExercice.vue?vue&type=script&lang=js& */ "./resources/js/views/exercice/DetailExercice.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _DetailExercice_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _DetailExercice_vue_vue_type_template_id_41c336d1___WEBPACK_IMPORTED_MODULE_0__["render"],
  _DetailExercice_vue_vue_type_template_id_41c336d1___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/exercice/DetailExercice.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/views/exercice/DetailExercice.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/views/exercice/DetailExercice.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DetailExercice_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./DetailExercice.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/exercice/DetailExercice.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DetailExercice_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/exercice/DetailExercice.vue?vue&type=template&id=41c336d1&":
/*!***************************************************************************************!*\
  !*** ./resources/js/views/exercice/DetailExercice.vue?vue&type=template&id=41c336d1& ***!
  \***************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DetailExercice_vue_vue_type_template_id_41c336d1___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./DetailExercice.vue?vue&type=template&id=41c336d1& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/views/exercice/DetailExercice.vue?vue&type=template&id=41c336d1&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DetailExercice_vue_vue_type_template_id_41c336d1___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DetailExercice_vue_vue_type_template_id_41c336d1___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);