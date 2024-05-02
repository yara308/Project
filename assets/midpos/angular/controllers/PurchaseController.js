window.angularApp.controller("PurchaseController", [
    "$scope",
    "API_URL",
    "window",
    "jQuery",
    "$compile",
    "$uibModal",
    "$http",
    "$sce",
    "ProductCreateModal",
    "CustomerCreateModal",
    "CustomerEditModal",
    "PurchaseOptionSelectorModal",
    "PurchasePaymentModal",
    "PurchaseInvoiceViewModal",
    "PurchaseInvoiceInfoEditModal",
    "PurchaseReturnModal",
    "EmailModal", 
function (
    $scope,
    API_URL,
    window,
    $,
    $compile,
    $uibModal,
    $http,
    $sce,
    ProductCreateModal,
    CustomerCreateModal,
    CustomerEditModal,
    PurchaseOptionSelectorModal,
    PurchasePaymentModal,
    PurchaseInvoiceViewModal,
    PurchaseInvoiceInfoEditModal,
    PurchaseReturnModal,
    EmailModal
) {
    "use strict";

    var dt = $("#invoice-invoice-list");
    var i;

    var hideColums = dt.data("hide-colums").split(",");
    var hideColumsArray = [];
    if (hideColums.length) {
        for (i = 0; i < hideColums.length; i+=1) {     
           hideColumsArray.push(parseInt(hideColums[i]));
        }
    }
    var $type = window.getParameterByName("type");
    var $from = window.getParameterByName("from");
    var $to = window.getParameterByName("to"),$store_id = window.getParameterByName("store_id");

    //================
    // Start datatable
    //================

    $("#invoice-invoice-list").dataTable({
        "oLanguage": {sProcessing:"<img src='../assets/midpos/img/loading2.gif'>", sUrl:langUrl},
        "processing": true,
        "dom": "lfBrtip",
        "serverSide": true,
        "ajax": API_URL + "/_inc/purchase.php?from="+$from+"&to="+$to+"&type="+$type + "&store_id=" + $store_id,
        "fixedHeader": true,
        "order": [[ 0, "desc"]],
        "aLengthMenu": [
            [10, 25, 50, 100, 200, -1],
            [10, 25, 50, 100, 200, "All"]
        ],
        "columnDefs": [
            {"targets": [7, 8, 9, 10, 11, 12], "orderable": false},
            {"className": "text-center", "targets": [0, 3, 7, 8, 9, 10, 11]},
            {"className": "text-right", "targets": [4, 5, 6]},
            { "visible": false,  "targets": hideColumsArray},
            { 
                "targets": [0],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#invoice-invoice-list thead tr th:eq(0)").html());
                }
            },
            { 
                "targets": [1],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#invoice-invoice-list thead tr th:eq(1)").html());
                }
            },
            { 
                "targets": [2],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#invoice-invoice-list thead tr th:eq(2)").html());
                }
            },
            { 
                "targets": [3],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#invoice-invoice-list thead tr th:eq(3)").html());
                }
            },
            { 
                "targets": [4],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#invoice-invoice-list thead tr th:eq(4)").html());
                }
            },
            { 
                "targets": [5],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#invoice-invoice-list thead tr th:eq(5)").html());
                }
            },
            { 
                "targets": [6],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#invoice-invoice-list thead tr th:eq(6)").html());
                }
            },
            { 
                "targets": [7],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#invoice-invoice-list thead tr th:eq(7)").html());
                }
            },
            { 
                "targets": [8],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#invoice-invoice-list thead tr th:eq(8)").html());
                }
            },
            { 
                "targets": [9],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#invoice-invoice-list thead tr th:eq(9)").html());
                }
            },
            { 
                "targets": [10],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#invoice-invoice-list thead tr th:eq(10)").html());
                }
            },
            { 
                "targets": [11],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#invoice-invoice-list thead tr th:eq(11)").html());
                }
            },
            { 
                "targets": [12],
                'createdCell':  function (td, cellData, rowData, row, col) {
                   $(td).attr('data-title', $("#invoice-invoice-list thead tr th:eq(12)").html());
                }
            },
        ],
        "aoColumns": [
            {data : "created_at"},
            {data : "invoice_id"},
            {data : "sup_name"},
            {data : "created_by"},
            {data : "invoice_amount"},
            {data : "paid_amount"},
            {data : "due"},
            {data : "status"},
            {data : "btn_pay"},
            {data : "btn_return"},
            {data : "btn_view"},
            {data : "btn_edit"},
            {data : "btn_delete"}
        ],
        "footerCallback": function ( row, data, start, end, display ) {
            var pageTotal;
            var api = this.api();
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === "string" ?
                    i.replace(/[\$,]/g, "")*1 :
                    typeof i === "number" ?
                        i : 0;
            };

            // Total over all pages at column 4
            pageTotal = api
                .column( 4, { page: "current"} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Update footer
            $( api.column( 4 ).footer() ).html(
                window.formatDecimal(pageTotal, 2)
            );

            // Total over all pages at column 5
            pageTotal = api
                .column( 5, { page: "current"} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Update footer
            $( api.column( 5 ).footer() ).html(
                window.formatDecimal(pageTotal, 2)
            );

            // Total over all pages at column 6
            pageTotal = api
                .column( 6, { page: "current"} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Update footer
            $( api.column( 6 ).footer() ).html(
                window.formatDecimal(pageTotal, 2)
            );
        },
        "pageLength": window.settings.datatable_item_limit,
        "buttons": [
            {
                extend:    "print",footer: 'true',
                text:      "<i class=\"fa fa-print\"></i>",
                titleAttr: "Print",
                title: "Purchase Listing-"+from+" to "+to,
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .append(
                            '<div><b><i>Powered by: Onzstore.com</i></b></div>'
                        )
                        .prepend(
                            '<div class="dt-print-heading"><img class="logo" src="'+window.logo+'"/><h2 class="title">'+window.store.name+'</h2><p>Printed on: '+window.formatDate(new Date())+'</p></div>'
                        );
 
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                },
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
            {
                extend:    "copyHtml5",
                text:      "<i class=\"fa fa-files-o\"></i>",
                titleAttr: "Copy",
                title: window.store.name + " > Purchase Listing-"+from+" to "+to,
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
            {
                extend:    "excelHtml5",
                text:      "<i class=\"fa fa-file-excel-o\"></i>",
                titleAttr: "Excel",
                title: window.store.name + " > Purchase Listing-"+from+" to "+to,
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
            {
                extend:    "csvHtml5",
                text:      "<i class=\"fa fa-file-text-o\"></i>",
                titleAttr: "CSV",
                title: window.store.name + " > Purchase Listing-"+from+" to "+to,
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
            {
                extend:    "pdfHtml5",
                text:      "<i class=\"fa fa-file-pdf-o\"></i>",
                titleAttr: "PDF",
                download: "open",
                title: window.store.name + " > Purchase Listing-"+from+" to "+to,
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                },
                customize: function (doc) {
                    doc.content[1].table.widths =  Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    doc.pageMargins = [10,10,10,10];
                    doc.defaultStyle.fontSize = 8;
                    doc.styles.tableHeader.fontSize = 8;doc.styles.tableHeader.alignment = "left";
                    doc.styles.title.fontSize = 10;
                    // Remove spaces around page title
                    doc.content[0].text = doc.content[0].text.trim();
                    // Header
                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        fontSize: 8,
                        text: 'Printed on: '+window.formatDate(new Date()),
                    });
                    // Create a footer
                    doc['footer']=(function(page, pages) {
                        return {
                            columns: [
                                'Powered by Onzstore.com',
                                {
                                    // This is the right column
                                    alignment: 'right',
                                    text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                                }
                            ],
                            margin: [10, 0]
                        };
                    });
                    var objLayout = {};
                    objLayout['hLineWidth'] = function(i) { return 0.5; };
                    objLayout['vLineWidth'] = function(i) { return 0.5; };
                    objLayout['hLineColor'] = function(i) { return '#aaa'; };
                    objLayout['vLineColor'] = function(i) { return '#aaa'; };
                    objLayout['paddingLeft'] = function(i) { return 4; };
                    objLayout['paddingRight'] = function(i) { return 4; };
                    doc.content[1].layout = objLayout;
                }
            }
        ],
    });


    // Add Product
    $scope.ProductCreateModalCallback = function($res)
    {
        $("#add_item").val($res.product.p_name).focus();
    }
    $(document).delegate("#add_new_product", "click", function(e) {
        e.stopPropagation();
        e.preventDefault();
        $scope.hideBoxAddBtn = true;
        $scope.hideCategoryAddBtn = true;
        $scope.hideSupAddBtn = true;
        $scope.hideUnitAddBtn = true;
        $scope.hideTaxrateAddBtn = true;
        ProductCreateModal($scope);
    });

    // Edit Invoice
    $(document).delegate("#edit-invoice-info", "click", function(e) {
        e.stopPropagation();
        e.preventDefault();
        var d = dt.DataTable().row( $(this).closest("tr") ).data();
        var $tag = $(this);
        var $btn = $tag.button("loading");
        PurchaseInvoiceInfoEditModal(d);
        setTimeout(function() {
            $tag.button("reset");
        }, 300);
    });

    // View Invoice
    $(document).delegate("#view-invoice-btn", "click", function (e) {
        e.stopPropagation();
        e.preventDefault();
        var d = dt.DataTable().row( $(this).closest("tr") ).data();
        var $tag = $(this);
        var $btn = $tag.button("loading");
        PurchaseInvoiceViewModal(d);
        setTimeout(function() {
            $tag.button("reset");
        }, 300);
    });

    // Delete Invoice
    $(document).delegate("#delete-invoice", "click", function(e) {
        e.stopPropagation();
        e.preventDefault();
        var d = dt.DataTable().row( $(this).closest("tr") ).data();
        var $tag = $(this);
        var $btn = $tag.button("loading");
        window.swal({
          title: "Delete!",
          text: "Are You Sure?",
          icon: "warning",
          buttons: {
			cancel: true,
			confirm: true,
		  },
        })
        .then(function (willDelete) {
            if (willDelete) {
                $http({
                    method: "POST",
                    url: API_URL + "/_inc/purchase.php",
                    data: "invoice_id="+d.id+"&action_type=DELETE",
                    dataType: "JSON"
                })
                .then(function(response) {
                    dt.DataTable().ajax.reload( null, false );
                    window.swal("success!", response.data.msg, "success");
                    setTimeout(function() {
                        $tag.button("reset");
                    }, 300);
                }, function(response) {
                    window.swal("Oops!", response.data.errorMsg, "error");
                    setTimeout(function() {
                        $tag.button("reset");
                    }, 300);
                });
            } else {
                setTimeout(function() {
                    $tag.button("reset");
                }, 300);
            }
        });
    });


    // Popup Payment Modal
    $(document).delegate("#pay_now", "click", function(e) {
        e.stopPropagation();
        e.preventDefault();
        var d = dt.DataTable().row( $(this).closest("tr") ).data();
        var $tag = $(this);
        var $btn = $tag.button("loading");
        PurchasePaymentModal(d);
        setTimeout(function() {
            $tag.button("reset");
        }, 300);
    });

    // Popup Return Modal
    $(document).delegate("#return_item", "click", function(e) {
        e.stopPropagation();
        e.preventDefault();
        var d = dt.DataTable().row( $(this).closest("tr") ).data();
        var $tag = $(this);
        var $btn = $tag.button("loading");
        $http({
          url: window.baseUrl + "/_inc/purchase_payment.php?action_type=ORDERDETAILS&invoice_id="+d.invoice_id,
          method: "GET"
        })
        .then(function(response, status, headers, config) {
            $scope.order = response.data.order;
            $scope.order.datatable = dt;
            PurchaseReturnModal($scope);
            setTimeout(function() {
                $tag.button("reset");
            }, 300);
        }, function(response) {
           window.swal("Oops!", response.data.errorMsg, "error");
           setTimeout(function() {
                $tag.button("reset");
            }, 300);
        });
    });


    // Create new Order
    $(document).delegate("#create-order-submit", "click", function(e) {
        e.preventDefault();
        var $tag = $(this);
        var $btn = $tag.button("loading");
        var form = $($tag.data("form"));
        form.find(".alert").remove();
        var actionUrl = form.attr("action");
        $http({
            url: window.baseUrl + "/_inc/" + actionUrl + "?action_type=CREATE&action_cat=ORDER",
            method: "POST",
            data: form.serialize(),
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json"
        }).
        then(function(response) {
            $("#reset").trigger("click");
            $btn.button("reset");
            $(":input[type=\"button\"]").prop("disabled", false);
            var alertMsg = response.data.msg;
            window.toastr.success(alertMsg, "Success!");
            var id = response.data.id;
            dt.DataTable().ajax.reload(function(json) {
                if ($("#row_"+id).length) {
                    $("#row_"+id).flash("yellow", 5000);
                }
            }, false);
        }, function(response) {
            $btn.button("reset");
            $(":input[type=\"button\"]").prop("disabled", false);
            var alertMsg = "<div>";
            window.angular.forEach(response.data, function(value) {
                alertMsg += "<p>" + value + ".</p>";
            });
            alertMsg += "</div>";
            window.toastr.warning(alertMsg, "Warning!");
        });
    });


    // Create new Purchase
    $(document).delegate("#create-purchase-submit", "click", function(e) {
        e.preventDefault();
        var $tag = $(this);
        var $btn = $tag.button("loading");
        var form = $($tag.data("form"));
        form.find(".alert").remove();
        var actionUrl = form.attr("action");
        $http({
            url: window.baseUrl + "/_inc/" + actionUrl + "?action_type=CREATE",
            method: "POST",
            data: form.serialize(),
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json"
        }).
        then(function(response) {
            $("#reset").trigger("click");
            $btn.button("reset");
            $(":input[type=\"button\"]").prop("disabled", false);
            var alertMsg = response.data.msg;
            window.toastr.success(alertMsg, "Success!");
            var id = response.data.id;
            dt.DataTable().ajax.reload(function(json) {
                if ($("#row_"+id).length) {
                    $("#row_"+id).flash("yellow", 5000);
                }
            }, false);
            PurchaseInvoiceViewModal({'invoice_id':response.data.id});
        }, function(response) {
            $btn.button("reset");
            $(":input[type=\"button\"]").prop("disabled", false);
            var alertMsg = "<div>";
            window.angular.forEach(response.data, function(value) {
                alertMsg += "<p>" + value + ".</p>";
            });
            alertMsg += "</div>";
            window.toastr.warning(alertMsg, "Warning!");
        });
    });

    $scope.itemArray        = [];
    $scope.totalItem        = 0;
    $scope.totalQuantity    = 0;
    $scope.totalAmount      = 0;
    $scope.discountAmount   = 0;
    $scope.itemTaxAmount    = 0;
    $scope.totalItemTaxAmount= 0;
    $scope.orderTaxAmount   = 0;
    $scope.totalTaxAmount   = 0;
    $scope.shippingAmount   = 0;
    $scope.othersChargeAmount     = 0;
    $scope.totalPayable     = 0;
    $scope.orderTaxInput    = 0;
    $scope.discountInput    = 0;
    $scope.shippingInput    = 0;
    $scope.othersChargeInput= 0;
    $scope.discountType     = 'plain';
    $scope.shippingType     = 'plain';
    $scope.payableAmount = 0;
    $scope.pmethod = 'cod';
    $scope.paidAmount = 0;
    $scope.dueAmount = 0;
    $scope.changeAmount = 0;
    $scope.searchBoxText;
    $scope.sup_id;
    if (window.getParameterByName("sup_id")) {
        $scope.sup_id = parseInt(window.getParameterByName("sup_id"));
    }

    // Supplier Select
    $(document).delegate("#sup_id", "select2:select", function (e) {
        e.preventDefault();
        e.stopPropagation();
        var data = e.params.data;
        $scope.$apply(function() {
            $scope.modal_title = data.element.text;
            $scope.sup_id = data.element.value;
        });
    });

    // Product Autocomplete
    $(document).on("focus", ".autocomplete-product", function (e) {
		e.stopImmediatePropagation();
        e.stopPropagation();
        e.preventDefault();
        if (!$scope.sup_id) {
            window.swal("Oops!", "Please, select supplier first", "warning");
        }
        var $this = $(this);
        $this.attr('autocomplete', 'off');
        var type = $this.data("type");
        $this.autocomplete({
            source: function (request, response) {
                return $http({
                    url: window.baseUrl + "/_inc/ajax.php?type=PURCHASEITEM",
                    dataType: "json",
                    method: "post",
                    data: $.param({
                       sup_id: $scope.sup_id,
                       name_starts_with: request.term,
                       type: type
                    }),
                })
                .then(function (resData) {
                    return response( $.map( resData.data, function (item) {
                        return {
                            label: item.p_name + " (" + item.p_code + ")",
                            value: item.p_id,
                            data : item
                        };
                    }));
                }, function (data) {
                   window.swal("Oops!", response.data.errorMsg, "error");
                });
            },
            focusOpen: true,
            autoFocus: true,
            minLength: 0,
            select: function ( event, ui ) {
                $scope.addItemToInvoice(ui.item.data);
            }, 
            open: function () {
                $(".ui-autocomplete").perfectScrollbar();
                if ($(".ui-autocomplete .ui-menu-item").length == 1) {
                    $(".ui-autocomplete .ui-menu-item:first-child").trigger("click");
                    $("#add_item").val("");
                    $("#add_item").focus();
                }
            }, 
            close: function () {
                $(document).find(".autocomplete-product").blur();
                $(document).find(".autocomplete-product").val("");
                $("#add_item").focus();
            },
        }).bind("focus", function() { 
            if ($("#add_item").val().length > 1) {
                $(this).autocomplete("search");
            }
        });
    });


    $scope.triggerKeyup = false;
    $(document).delegate(".quantity", "keyup", function(e) {
        e.preventDefault();
        e.stopPropagation();
        var  itemid = $(this).data("itemid");
        var  itemquantity = $(this).val();
        var totalAmount = 0;
        window._.map($scope.itemArray, function (item) {
            if (item.id == itemid) {
                item.quantity = itemquantity;
                item.subTotal = item.purchasePrice * itemquantity;
                $scope.itemArray = $scope.itemArray;
            }
            totalAmount += item.subTotal;
            $scope.totalAmount = totalAmount;
            $scope._calcTotalPayable();
        });
        if ($scope.triggerKeyup == false) {
            $scope.error = false;
        } else {
            $scope.triggerKeyup = false;
        }
    });


    // if (window.settings.change_item_price_while_billing == 1) {
        $(document).delegate(".purchase-price", "keyup", function(e) {
            e.preventDefault();
            e.stopPropagation();
            // e.stopImmediatePropagation();
            var  itemid = $(this).data("itemid");
            var  itemprice = $(this).val();
            var totalAmount = 0;
            window._.map($scope.itemArray, function (item) {
                if (item.id == itemid) {
                    item.purchasePrice = itemprice;
                    item.subTotal = item.quantity * itemprice;
                    $scope.itemArray = $scope.itemArray;
                }
                totalAmount += item.subTotal;
                $scope.totalAmount = totalAmount;
                $scope._calcTotalPayable();
            });
        });
    // }
    $scope._percentage = function (amount, per)
    {
        if(false === $scope._isNumeric(amount) || false === $scope._isNumeric(per)) {
            if (window.store.sound_effect == 1) {
                window.storeApp.playSound("error.mp3");
            }
            window.toastr.error("The discount amount isn't numeric!", "Warning!");
            return 0;
        }
        return (amount/100)*per;
    };
    $scope._isNumeric = function (val) {
      return !isNaN(parseFloat(val)) && 'undefined' !== typeof val ? parseFloat(val) : false;
    };
    $scope._isInt = function (value) {
        return !isNaN(value) && 
             parseInt(Number(value)) == value && 
             !isNaN(parseInt(value, 10));
    };
    $scope._calcDisAmount = function () {
        if (window._.includes($scope.discountInput, '%')) {
            $scope.discountType = 'percentage';
        } else {
            $scope.discountType = 'plain';
        }
        if ($scope.discountInput < 1) {
            $scope.discountAmount = 0;
            $scope.discountInput = 0;
        } else {
            $scope.discountAmount = parseFloat($scope.discountInput);
        }
    };
    $scope._calcTaxAmount = function () {
        if ($scope.orderTaxInput < 1 || $scope.orderTaxInput > 100) {
            $scope.orderTaxAmount = 0;
            $scope.orderTaxInput = 0;
        } else {
            $scope.orderTaxAmount = (parseFloat($scope.orderTaxInput) / 100) * parseFloat($scope.totalAmount-$scope.totalItemTaxAmount);
        }
        $scope.totalTaxAmount = parseFloat($scope.totalItemTaxAmount) + parseFloat($scope.orderTaxAmount);
    };
    $scope._calcShippingAmount = function () {
        if (window._.includes($scope.shippingInput, '%')) {
            $scope.shippingType = 'percentage';
        } else {
            $scope.shippingType = 'plain';
        }
        if ($scope.shippingInput < 1) {
            $scope.shippingAmount = 0;
            $scope.shippingInput = 0;
        } else {
            $scope.shippingAmount = parseFloat($scope.shippingInput);
        }
    };
    $scope._calcOthersCharge = function () {
        if ($scope.othersChargeInput < 1) {
            $scope.othersChargeAmount = 0;
            $scope.othersChargeInput = 0;
        } else {
            $scope.othersChargeAmount = parseFloat($scope.othersChargeInput);
        }
    };
    $scope._calcTotalPayable = function () 
    {
        var discountPercentage = 0;
        var shippingPercentage = 0;
        $scope._calcDisAmount();
        $scope._calcTaxAmount();
        $scope._calcShippingAmount();
        $scope._calcOthersCharge();
        $scope.payable = $scope.totalAmount  + $scope.totalTaxAmount;
        if ($scope.payable != 0 && ($scope.discountAmount >= $scope.payable)) {
            $scope.discountAmount = 0;
            $scope.discountInput = 0;
            if (window.store.sound_effect == 1) {
                window.storeApp.playSound("error.mp3");
            }
            window.toastr.error("Discount amount must be less than payable amount", "Warning!");
        }
        if ($scope.payable != 0 && ($scope.shippingAmount >= $scope.payable)) {
            $scope.shippingAmount = 0;
            $scope.shippingInput = 0;
            if (window.store.sound_effect == 1) {
                window.storeApp.playSound("error.mp3");
            }
            window.toastr.error("Shipping amount must be less than payable amount", "Warning!");
        }
        if ($scope.discountType == 'percentage') {
            discountPercentage =  parseFloat($scope._percentage($scope.payable, $scope.discountAmount));
        } else {
            discountPercentage =  parseFloat($scope.discountAmount);
        }

        if ($scope.shippingType == 'percentage') {
            shippingPercentage =  parseFloat($scope._percentage($scope.totalPayable, $scope.shippingAmount));
        } else {
            shippingPercentage =  parseFloat($scope.shippingAmount);
        }
        $scope.payable = ($scope.payable + shippingPercentage + $scope.othersChargeAmount) - discountPercentage;
        $scope.totalPayable =  $scope.payable;
        $scope.payableAmount =  $scope.totalPayable;
        $scope.dueAmount = $scope.totalPayable - $scope.paidAmount;
        $scope.$applyAsync(function() {
            $scope = $scope;
        });
    };

    $scope.addOrderTax = function () {
        $scope._calcTotalPayable();
    };

    $scope.addShippingAmount = function () {
        $scope._calcTotalPayable();
    };

    $scope.addOthersCharge = function () {
        $scope._calcTotalPayable();
    };

    $scope.addDiscountAmount = function () {
        $scope._calcTotalPayable();
    };

    $scope.addPaidAmount = function () {
        $scope.$applyAsync(function() {
            $scope.dueAmount = parseFloat($scope.payableAmount) > parseFloat($scope.paidAmount) ? parseFloat($scope.payableAmount) - parseFloat($scope.paidAmount) : 0;
            $scope.changeAmount = parseFloat($scope.payableAmount) < parseFloat($scope.paidAmount) ? parseFloat($scope.paidAmount) - parseFloat($scope.payableAmount) : 0;
        });
    };

    $scope.PurchaseOptionSelectorModal = function(item) {
        $scope.item = item;
        PurchaseOptionSelectorModal($scope);
    }

    $scope.addItemToInvoice = function(data) 
    {
        var qty = 1;
        if (data.item_quantity && data.item_quantity != undefined) {
            qty = parseFloat(data.item_quantity);
        }
        var itemTaxAmount = 0;
        if (data.tax_method == 'exclusive') {
            itemTaxAmount = parseFloat(data.tax_amount);
            $scope.itemTaxAmount = itemTaxAmount;
        }
        $scope.totalItemTaxAmount += parseFloat($scope.itemTaxAmount);

        var find = window._.find($scope.itemArray, function (item) { 
            return item.id == data.p_id;
        });
        if (find) {
            window._.map($scope.itemArray, function (item) {
                if (item.id == data.p_id) {    
                    $scope.$apply(function() {
                        item.quantity = parseFloat(item.quantity) + parseFloat(qty);
                        item.subTotal = (item.subTotal + (parseFloat(data.purchase_price) * item.quantity)) + itemTaxAmount;
                        $scope.totalQuantity = $scope.totalQuantity + item.quantity;
                        $scope.totalAmount = $scope.totalAmount + (parseFloat(data.purchase_price) * item.quantity) + itemTaxAmount;
                    });
                }
            });
        } else {
            var item = [];
            item.id = data.p_id;
            item.pType = data.p_type;
            item.hasVariant = data.has_variant;
            item.variantID = data.variant_id;
            item.variantSlug = data.variant_slug;
            item.variantName = data.variant_name;
            item.categoryId = data.category_id;
            item.supId = data.sup_id;
            item.name = data.p_name;
            item.code = data.p_code;
            item.available = data.quantity_in_stock;
            item.status = data.status;
            item.sold = data.sold;
            item.unitName = data.unit_name;
            item.taxMethod = data.tax_method;
            item.taxrate = data.taxrate;
            item.itemTaxAmount = itemTaxAmount;
            item.purchasePrice = parseFloat(data.purchase_price) + parseFloat(data.purchase_price_addition) + itemTaxAmount;
            item.sellPrice = parseFloat(data.sell_price) + parseFloat(data.sell_price_addition) + itemTaxAmount
            item.quantity = qty;
            item.subTotal = (parseFloat(data.purchase_price) * qty) + (parseFloat(data.purchase_price_addition) * qty) + itemTaxAmount;
            $scope.$applyAsync(function() {
                $scope.itemArray.push(item);
            });
            $scope.totalQuantity = $scope.totalQuantity + qty;
            $scope.totalAmount = $scope.totalAmount + (parseFloat(data.purchase_price) * qty) + (parseFloat(data.purchase_price_addition) * qty) + item.itemTaxAmount;
        }
        $scope.totalItem = window._.size($scope.itemArray);
        $scope._calcTotalPayable();
    };

    // Remove Item from Invoice
    $scope.removeItemFromInvoice = function (index, id) {
        if (window.store.sound_effect  == 1) {
            window.storeApp.playSound("modify.mp3");
        }
        window._.map($scope.itemArray, function (item, key) {
            if (item.id == id) {
                $scope.totalItem = $scope.totalItem - 1;
                $scope.totalQuantity = $scope.totalQuantity - item.quantity;
                $scope.totalAmount = $scope.totalAmount - parseFloat(item.subTotal);
            }
        });
        $scope._calcTotalPayable();
        $scope.itemArray.splice(index, 1);
        $scope.totalItem = window._.size($scope.itemArray);
    };

    // Add Supplier And Product By Query String
    if (window.getParameterByName("sup_id")) {
        $("#sup_id").val(window.getParameterByName("sup_id")).trigger("change");
        $scope.sup_id = window.getParameterByName("sup_id");
    }
    if (window.getParameterByName("p_code")) {
        $("#add_item").val(window.getParameterByName("p_code"));
        $("#add_item").trigger("focus");
    }

    $("#sup_id").on("select2:select", function(e) {
        $scope.itemArray = [];
    });

    $(document).on('click', function(e) {
        window._.map($scope.itemArray, function (item) {
            $("#quantity-"+item.id).trigger("keyup");
            $("#purchase-price-"+item.id).trigger("keyup");
        });
        $scope.trigger = true;
    });

    if (window.getParameterByName("invoice_id")) {
        $http({
            method: "POST",
            url: window.baseUrl + "/_inc/ajax.php?type=PURCHASEEDITINFO",
            data: "invoice_id="+window.getParameterByName("invoice_id"),
            dataType: "JSON"
        })
        .then(function(res) {
            $("#reference_no").val(res.data.info.invoice_id);
            $("#purchase-note").val(res.data.info.purchase_note);
            $scope.sup_id = res.data.info.sup_id;
            $("#sup_id").val(res.data.info.sup_id).trigger("change");          

            window.angular.forEach(res.data.items, function(item, key) {
                $scope.totalItemTaxAmount += parseFloat(item.item_tax);
                item.status = item.sell_status;
                item.sold = item.total_sell;
                $scope.addItemToInvoice(item);
            });

            $scope.$applyAsync(function() {
                $scope.totalItem = res.data.info.total_item;
                $scope.orderTaxAmount = (parseFloat(res.data.info.order_tax)/(parseFloat($scope.totalAmount)-parseFloat($scope.totalItemTaxAmount)))*100;
                $scope.orderTaxInput = window.formatDecimal((parseFloat(res.data.info.order_tax)/(parseFloat($scope.totalAmount)-parseFloat($scope.totalItemTaxAmount)))*100,2);
                $scope.totalTaxAmount = parseFloat(res.data.info.item_tax)+parseFloat(res.data.info.order_tax);
                $scope.shippingType = res.data.info.shipping_type;
                $scope.shippingAmount = res.data.info.shipping_amount;
                $scope.shippingInput = window.formatDecimal(res.data.info.shipping_amount,2);
                $scope.othersChargeAmount = res.data.info.others_charge;
                $scope.othersChargeInput = window.formatDecimal(res.data.info.others_charge,2);
                $scope.discountType = res.data.info.discount_type;
                $scope.discountAmount = res.data.info.discount_amount;
                $scope.discountInput =  window.formatDecimal(res.data.info.discount_amount,2);
                $scope.totalPayable = res.data.info.payable_amount;
                $scope._calcTotalPayable();
            });

        }, function(res) {
            window.toastr.error("an unknown error occured!", "Warning!");
        });
    }

    // Reset purchase form
    $(document).delegate("#reset", "click", function (e) {
        e.preventDefault();
        $scope.totalTaxAmount = 0;
        $scope.totalAmount = 0;
        $scope.totalPayable = 0;
        $scope.payableAmount = 0;
        $scope.paidAmount = 0;
        $scope.orderTaxAmount = 0;
        $scope.orderTaxAmount = 0;
        $scope.shippingAmount = 0;
        $scope.shippingInput = 0;
        $scope.othersChargeAmount = 0;
        $scope.othersChargeInput = 0;
        $scope.discountAmount = 0;
        $scope.discountInput = 0;
        $scope.dueAmount = 0;
        $scope.changeAmount = 0;
        $scope.searchBoxText;
        $scope.itemArray = [];

        $("#reference_no").val("");
        $("#purchase-note").val("");
        $("#sup_id").val("").trigger("change");
        $("#customer_id").val("").trigger("change");
        $("#reference_no").val("");

        $("#image_thumb img").attr("src", "../assets/midpos/img/noimage.jpg");
        $("#image").val("");

    });

    if (window.sendReportEmail) { 
        $(".dt-buttons").append("<button id=\"email-btn\" class=\"btn btn-default buttons-email\" tabindex=\"0\" aria-controls=\"purchase-purchase-list\" type=\"button\" title=\"Email\"><span><i class=\"fa fa-envelope\"></i></span></button>"); 
    };
    $("#email-btn").on( "click", function (e) {
        e.stopPropagation();
        e.preventDefault();
        dt.find("thead th:nth-child(9), thead th:nth-child(10), thead th:nth-child(11), thead th:nth-child(12), thead th:nth-child(13), tbody th:nth-child(9), tbody th:nth-child(10), tbody td:nth-child(11) tbody td:nth-child(12), tbody td:nth-child(13), tfoot td:nth-child(9), tfoot td:nth-child(10), tfoot td:nth-child(11), tfoot th:nth-child(12) tfoot th:nth-child(13)").addClass("hide-in-mail");
        var thehtml = dt.html();
        EmailModal({template: "default", subject: "Purchase Invoice Listing", title:"Purchase Invoice Listing", html: thehtml});
    });
}]);