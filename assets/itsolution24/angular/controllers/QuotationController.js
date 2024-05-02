window.angularApp.controller("QuotationController", [
    "$scope",
    "API_URL",
    "window",
    "jQuery",
    "$compile",
    "$uibModal",
    "$http",
    "$sce",
    "QuotationViewModal",
    "ProductCreateModal",
    "CustomerCreateModal",
    "CustomerEditModal",
    "QuotationOptionSelectorModal",
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
    QuotationViewModal,
    ProductCreateModal,
    CustomerCreateModal,
    CustomerEditModal,
    QuotationOptionSelectorModal,
    EmailModal
) {
    "use strict";

    var dt = $("#quotation-quotation-list");
    if (dt.length > 0) {
        var id = null;
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

        dt.dataTable({
            "oLanguage": {sProcessing:"<img src='../assets/itsolution24/img/loading2.gif'>", sUrl:langUrl},
            "processing": true,
            "dom": "lfBrtip",
            "serverSide": true,
            "ajax": API_URL + "/_inc/quotation.php?from="+$from+"&to="+$to+"&type="+$type + "&store_id=" + $store_id,
            "order": [[ 0, "desc"]],
            "aLengthMenu": [
                [10, 25, 50, 100, 200, -1],
                [10, 25, 50, 100, 200, "All"]
            ],
            "columnDefs": [
                {"targets": [6], "orderable": false},
                {"visible": false,  "targets": hideColumsArray},
                {"className": "text-right", "targets": [4]},
                {"className": "text-center", "targets": [0, 2, 3, 5, 6]},
                { 
                    "targets": [0],
                    'createdCell':  function (td, cellData, rowData, row, col) {
                       $(td).attr('data-title', $("#quotation-quotation-list thead tr th:eq(0)").html());
                    }
                },
                { 
                    "targets": [1],
                    'createdCell':  function (td, cellData, rowData, row, col) {
                       $(td).attr('data-title', $("#quotation-quotation-list thead tr th:eq(1)").html());
                    }
                },
                { 
                    "targets": [2],
                    'createdCell':  function (td, cellData, rowData, row, col) {
                       $(td).attr('data-title', $("#quotation-quotation-list thead tr th:eq(2)").html());
                    }
                },
                { 
                    "targets": [3],
                    'createdCell':  function (td, cellData, rowData, row, col) {
                       $(td).attr('data-title', $("#quotation-quotation-list thead tr th:eq(3)").html());
                    }
                },
                { 
                    "targets": [4],
                    'createdCell':  function (td, cellData, rowData, row, col) {
                       $(td).attr('data-title', $("#quotation-quotation-list thead tr th:eq(4)").html());
                    }
                },
                { 
                    "targets": [5],
                    'createdCell':  function (td, cellData, rowData, row, col) {
                       $(td).attr('data-title', $("#quotation-quotation-list thead tr th:eq(5)").html());
                    }
                },
                { 
                    "targets": [6],
                    'createdCell':  function (td, cellData, rowData, row, col) {
                       $(td).attr('data-title', $("#quotation-quotation-list thead tr th:eq(6)").html());
                    }
                },
            ],
            "aoColumns": [
                {data : "created_at"},
                {data : "reference_no"},
                {data : "created_by"},
                {data : "customer_name"},
                {data : "payable_amount"},
                {data : "status"},
                {data : "action"},
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
            },
            "pageLength": window.settings.datatable_item_limit,
            "buttons": [
                {
                    extend:    "print",footer: 'true',
                    text:      "<i class=\"fa fa-print\"></i>",
                    titleAttr: "Print",
                    title: "Quotation Listing",
                    customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '10pt' )
                            .append(
                                '<div><b><i>Powered by: ONZWO.COM</i></b></div>'
                            )
                            .prepend(
                                '<div class="dt-print-heading"><img class="logo" src="'+window.logo+'"/><h2 class="title">'+window.store.name+'</h2><p>Printed on: '+window.formatDate(new Date())+'</p></div>'
                            );
     
                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    },
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5 ]
                    }
                },
                {
                    extend:    "copyHtml5",
                    text:      "<i class=\"fa fa-files-o\"></i>",
                    titleAttr: "Copy",
                    title: window.store.name + " > Quotation Listing",
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5 ]
                    }
                },
                {
                    extend:    "excelHtml5",
                    text:      "<i class=\"fa fa-file-excel-o\"></i>",
                    titleAttr: "Excel",
                    title: window.store.name + " > Quotation Listing",
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5 ]
                    }
                },
                {
                    extend:    "csvHtml5",
                    text:      "<i class=\"fa fa-file-text-o\"></i>",
                    titleAttr: "CSV",
                    title: window.store.name + " > Quotation Listing",
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5 ]
                    }
                },
                {
                    extend:    "pdfHtml5",
                    text:      "<i class=\"fa fa-file-pdf-o\"></i>",
                    titleAttr: "PDF",
                    download: "open",
                    title: window.store.name + " > Quotation Listing",
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5 ]
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
                                    'Powered by ONZWO.COM',
                                    {
                                        // This is the right column
                                        alignment: 'right',
                                        text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                                    }
                                ],
                                margin: [10, 0]
                            };
                        });
                        // Styling the table: create style object
                        var objLayout = {};
                        // Horizontal line thickness
                        objLayout['hLineWidth'] = function(i) { return 0.5; };
                        // Vertikal line thickness
                        objLayout['vLineWidth'] = function(i) { return 0.5; };
                        // Horizontal line color
                        objLayout['hLineColor'] = function(i) { return '#aaa'; };
                        // Vertical line color
                        objLayout['vLineColor'] = function(i) { return '#aaa'; };
                        // Left padding of the cell
                        objLayout['paddingLeft'] = function(i) { return 4; };
                        // Right padding of the cell
                        objLayout['paddingRight'] = function(i) { return 4; };
                        // Inject the object in the document
                        doc.content[1].layout = objLayout;
                    }
                }
            ],
        });
    }


    // Add Product
    $scope.ProductCreateModalCallback = function($res){
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

    // Add Customer
    $scope.CustomerCreateModalCallback = function($res){
        $("#customer_id").append("<option value='"+$res.customerId+"' selected>"+$res.customerName+"</option>");
        $('#customer_id').trigger('change');    
    }

    $(document).delegate("#add_customer", "click", function(e) {
        e.stopPropagation();
        e.preventDefault();
        CustomerCreateModal($scope);
    });


    // Edit Customer
    $scope.CustomerEditModalCallback = function($res)
    {
        $("#customer_id").append("<option value='"+$res.customer_id+"' selected>"+$res.customer_name+"</option>");
        $('#customer_id').trigger('change');    
    }

    $(document).delegate("#edit_customer", "click", function(e) {
        e.stopPropagation();
        e.preventDefault();

        var customerID = $('#customer_id').val();
        var customerName = $("#customer_id").select2('data')[0].text;
        if (!customerID) {
            swal("warning", "Please, Select a customer!");
            return false;
        }
        CustomerEditModal({'customer_name':customerName,'customer_id':customerID});
    });


     // View Customer Profile
    $(document).delegate("#view_customer", "click", function(e) {
        e.stopPropagation();
        e.preventDefault();
        var customerID = $('#customer_id').val();
        if (!customerID) {
            swal("warning", "Please, Select a customer!");
            return false;
        }
        window.open(window.baseUrl + "/admin/customer_profile.php?customer_id=" + customerID);
    });


    $scope.itemArray        = [];
    $scope.totalItem        = 0;
    $scope.totalQuantity    = 0;
    $scope.totalAmount      = 0;
    $scope.discountType     = 'plain';
    $scope.discountInput    = 0;
    $scope.discountAmount   = 0;
    $scope.itemTaxAmount    = 0;
    $scope.orderTaxInput    = 0;
    $scope.orderTaxAmount   = 0;
    $scope.totalTaxAmount   = 0;
    $scope.shippingType     = 'plain';
    $scope.shippingInput    = 0;
    $scope.shippingAmount   = 0;
    $scope.othersChargeInput= 0;
    $scope.othersChargeAmount= 0;
    $scope.totalPayable     = 0;
    $scope.payableAmount = 0;
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
        var $this = $(this);
        $this.attr('autocomplete', 'off');
        var type = $this.data("type");
        $this.autocomplete({
            source: function (request, response) {
                return $http({
                    url: window.baseUrl + "/_inc/ajax.php?type=SELLINGITEM",
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


    // Re-Calcualte while Changing Quantity
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
                item.subTotal = item.sellPrice * itemquantity;
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


    if (window.settings.change_item_price_while_billing == 1) {
        $(document).delegate(".sell-price", "keyup", function(e) {
            e.preventDefault();
            e.stopPropagation();
            var  itemid = $(this).data("itemid");
            var  itemprice = $(this).val();
            var totalAmount = 0;
            window._.map($scope.itemArray, function (item) {
                if (item.id == itemid) {
                    item.sellPrice = itemprice;
                    item.subTotal = item.quantity * itemprice;
                    $scope.itemArray = $scope.itemArray;
                }
                totalAmount += item.subTotal;
                $scope.totalAmount = totalAmount;
                $scope._calcTotalPayable();
            });
        });
    }

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
            $scope.orderTaxAmount = (parseFloat($scope.orderTaxInput) / 100) * parseFloat($scope.totalAmount-$scope.itemTaxAmount);
        }
        $scope.totalTaxAmount = parseFloat($scope.itemTaxAmount) + parseFloat($scope.orderTaxAmount);
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
        $scope.totalPayable =  parseFloat($scope.payable);
        $scope.payableAmount =  $scope.totalPayable;
        $scope.dueAmount = $scope.totalPayable - $scope.paidAmount;
        $scope.paidAmount = window.formatDecimal($scope.totalPayable,2);
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

    $scope.QuotationOptionSelectorModal = function(item) {
        $scope.item = item;
        QuotationOptionSelectorModal($scope);
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

        var find = window._.find($scope.itemArray, function (item) { 
            return item.id == data.p_id;
        });
        if (find) {
            window._.map($scope.itemArray, function (item) {
                if (item.id == data.p_id) {    
                    $scope.$apply(function() {
                        item.quantity = parseFloat(item.quantity) + parseFloat(qty);
                        item.subTotal = (item.subTotal + (parseFloat(data.sell_price) * item.quantity)) + itemTaxAmount;
                        $scope.totalQuantity = $scope.totalQuantity + item.quantity;
                        $scope.totalAmount = $scope.totalAmount + (parseFloat(data.sell_price) * item.quantity) + itemTaxAmount;
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
            item.unitName = data.unit_name;
            item.taxMethod = data.tax_method;
            item.taxrate = data.taxrate;
            item.itemTaxAmount = itemTaxAmount;
            item.quantity = qty;
            item.sellPrice = parseFloat(data.sell_price) + parseFloat(data.sell_price_addition) + itemTaxAmount;
            item.subTotal = (parseFloat(data.sell_price) * qty)  + (parseFloat(data.sell_price_addition) * qty) + itemTaxAmount;
            $scope.$applyAsync(function() {
                $scope.itemArray.push(item);
            });
            $scope.totalQuantity = $scope.totalQuantity + qty;
            $scope.totalAmount = $scope.totalAmount + (parseFloat(data.sell_price) * qty) + (parseFloat(data.sell_price_addition) * qty) + item.itemTaxAmount;
        }
        $scope.totalItem = window._.size($scope.itemArray);
        $scope._calcTotalPayable();
    };

    // Remove Item from Quotation Item
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

    // Add Supplier
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
            $("#sell-price-"+item.id).trigger("keyup");
        });
        $scope.trigger = true;
    });


    // Create Quotation
    $(document).delegate("#create-quotation-submit", "click", function(e) {
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
            id = response.data.id;
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

    // Edit Quotation
    if (window.getParameterByName("reference_no")) {
        var refNo = window.getParameterByName("reference_no");
        $http({
            url: window.baseUrl + "/_inc/ajax.php?type=QUOTATIONINFO",
            dataType: "json",
            method: "post",
            data: $.param({
               ref_no: refNo,
            }),
        })
        .then(function (res) {
            var quotation = res.data.quotation;
            $scope.date = quotation.date;
            $scope.refNo = quotation.reference_no;
            $scope.quotationNote = quotation.quotation_note;
            $("#status").val(quotation.status).trigger("change");
            $("#customer_id").val(quotation.customer_id).trigger("change");
            $scope.orderTaxInput = window.formatDecimal(quotation.order_tax,2);
            $scope.orderTaxAmount = quotation.order_tax;
            $scope.shippingInput = window.formatDecimal(quotation.shipping_amount,2);
            $scope.shippingAmount = quotation.shipping_amount;
            $scope.othersChargeInput = window.formatDecimal(quotation.others_charge,2);
            $scope.othersChargeAmount = quotation.others_charge;
            $scope.discountInput = window.formatDecimal(quotation.discount_amount,2);
            $scope.discountAmount = quotation.discount_amount;
            window.angular.forEach(quotation.items, function(item, key) {
                $scope.addItemToInvoice(item);
            });
        }, function (res) {
           window.swal("Oops!", res.data.errorMsg, "error");
        });
    }


    // Update Quotation
    $(document).delegate("#update-quotation-submit", "click", function(e) {
        e.preventDefault();
        var $tag = $(this);
        var $btn = $tag.button("loading");
        var form = $($tag.data("form"));
        form.find(".alert").remove();
        var actionUrl = form.attr("action");
        
        $http({
            url: window.baseUrl + "/_inc/" + actionUrl + "?action_type=UPDATE",
            method: "POST",
            data: form.serialize(),
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json"
        }).
        then(function(response) {
            $btn.button("reset");
            $(":input[type=\"button\"]").prop("disabled", false);
            var alertMsg = response.data.msg;
            window.swal({
              title: "Success!",
              text: "Going back to list...",
              icon: "success",
              buttons: true,
              dangerMode: false,
            })
            .then(function (willDelete) {
                if (willDelete) {
                    window.location = window.baseUrl+'/admin/quotation.php';
                } else {
                    window.toastr.success(alertMsg, "Success!");
                }
            });

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

    // View Quotation Details
    $(document).delegate("#view-quotation-btn", "click", function (e) {
        e.stopPropagation();
        e.stopImmediatePropagation();
        e.preventDefault();
        var d = dt.DataTable().row( $(this).closest("tr") ).data();
        var $tag = $(this);
        var $btn = $tag.button("loading");
        QuotationViewModal(d);
        setTimeout(function() {
            $tag.button("reset");
        }, 300);
    });

    // Delete Quotation
    $(document).delegate("#delete-quotation", "click", function(e) {
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
                    url: API_URL + "/_inc/quotation.php?action_type=DELETE",
                    data: "reference_no="+d.reference_no,
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

    // Reset Quotation Form
    $(document).delegate("#reset", "click", function (e) {
        e.preventDefault();
        $scope.totalTaxAmount = 0;
        $scope.totalAmount = 0;
        $scope.totalPayable = 0;
        $scope.payableAmount = 0;
        $scope.paidAmount = 0;
        $scope.orderTaxInput = 0;
        $scope.orderTaxAmount = 0;
        $scope.shippingInput = 0;
        $scope.shippingAmount = 0;
        $scope.othersChargeInput = 0;
        $scope.othersChargeAmount = 0;
        $scope.discountInput = 0;
        $scope.discountAmount = 0;
        $scope.dueAmount = 0;
        $scope.changeAmount = 0;
        $scope.searchBoxText;
        $scope.itemArray = [];

        $("#reference_no").val("");
        $("#quotation-note").val("");
        $("#sup_id").val("").trigger("change");
        $("#customer_id").val("").trigger("change");
        $("#reference_no").val("");

        $("#image_thumb img").attr("src", "../assets/itsolution24/img/noimage.jpg");
        $("#image").val("");
    });

    $(document).delegate(".email-the-quotation", "click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        var d = dt.DataTable().row( $(this).closest("tr") ).data();
        var recipientName = d.recipient_name;
        var thehtml = 'Quotatin';
        var quotation = {
            id: d.reference_no, 
            template: "quotation", 
            subject: "Quotation#"+d.reference_no, 
            title: "Send Quotation through Email", 
            recipientName: recipientName, 
            senderName: window.store.name, 
            html: thehtml
        };
        EmailModal(quotation);
    });


    // Append Email Button
    if (window.sendReportEmail) { $(".dt-buttons").append("<button id=\"email-btn\" class=\"btn btn-default buttons-email\" tabindex=\"0\" aria-controls=\"quotation-quotation-list\" type=\"button\" title=\"Email\"><span><i class=\"fa fa-envelope\"></i></span></button>"); };
    
    // Send Email
    $("#email-btn").on( "click", function (e) {
        e.stopPropagation();
        e.preventDefault();
        dt.find("thead th:nth-child(7), tbody td:nth-child(7), tfoot th:nth-child(7)").addClass("hide-in-mail");
        var thehtml = dt.html();
        EmailModal({template: "default", subject: "Quotation Listing", title:"Quotation Listing", html: thehtml});
    });
}]);