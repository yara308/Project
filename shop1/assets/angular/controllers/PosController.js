window.angularApp.controller("PosController", [
    "$scope", 
    "API_URL", 
    "localStorageService",
    "window", 
    "jQuery",
    "$compile",
    "$uibModal",
    "$http",
    "$sce",
function (
    $scope,
    API_URL,
    localStorageService,
    window,
    $,
    $compile,
    $uibModal,
    $http,
    $sce
) {
    "use strict";

    $scope._percentage = function (amount, per)
    {
        if(false === $scope._isNumeric(amount) || false === $scope._isNumeric(per)) {
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
    $scope.itemArray = [];
    $scope.totalItem        = 0;
    $scope.totalQuantity    = 0;
    $scope.totalAmount      = 0;
    $scope.payable          = 0;
    $scope.totalPayable     = 0;
    $scope._calcTotalPayable = function ($childScope) {                    
        $scope.payable = $scope.totalAmount  + $scope.taxAmount;
        $scope.totalPayable =  $scope.payable;
        $scope.totalItem = window._.size($scope.itemArray);
    };
    $scope.itemQuantity = 0;
    $scope.isPrevQuantityCalcculate = false;
    $scope.prevQuantity = 0;
    $scope.itemListHeight = 0;
    $scope.addItemToInvoice = function (id, qty, index) {
        $("#prod-"+id+" .prod-inner-loader").addClass("d-block");
        var qty = parseFloat(qty);
        if (!qty) { qty = 1;}
        if (index != null) {
            var selectItem = $("#"+index);
            $("#item-list .item").removeClass("select");
            if (selectItem.length) {
                selectItem.addClass("select");
            }
        }
        var $queryString = "p_id=" + id + "&action_type=PRODUCTITEM&api_key=12456";
        if (window.getParameterByName("invoice_id")) {
            $queryString += "&is_edit_mode=1";
        }
        $http({
            url: "https://control.elmattger.com/_inc/pos.php?" + $queryString,
            method: "GET",
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json"
        }).
        then(function(response) {
            if (response.data.p_id) {
                var find = window._.find($scope.itemArray, function (item) { 
                    return item.id == response.data.p_id;
                });
                qty = parseFloat(response.data.quantity_in_stock);
                qty = qty > 0 && qty < 1 ? qty : 1;
                if (find) {
                    window._.map($scope.itemArray, function (item) {
                        if (item.id == response.data.p_id) {
                            if (!$scope.isPrevQuantityCalcculate && window.getParameterByName("customer_id") && window.getParameterByName("invoice_id")) {
                                $scope.isPrevQuantityCalcculate = true;
                                $scope.prevQuantity = item.quantity;
                            }
                            $scope.itemQuantity = item.quantity - $scope.prevQuantity;
                            if ((qty > response.data.quantity_in_stock || $scope.itemQuantity >= response.data.quantity_in_stock) && response.data.p_type != 'service') {
                                window.toastr.error("This product is out of stock!", "Warning!");
                                return false;
                            }
                            item.quantity = parseFloat(item.quantity) + qty;
                            $("#item_quantity_"+item.id).val(item.quantity);
                            var taxamount = 0;
                            if (response.data.tax_method == 'exclusive') {
                                taxamount = parseFloat(response.data.tax_amount);
                                $scope.itemTaxAmount = taxamount;
                            }
                            item.subTotal = (item.subTotal + (parseFloat(response.data.sell_price) * qty)) + (parseFloat(response.data.sell_price_addition) * qty) + parseFloat(taxamount);
                            $scope.totalQuantity = $scope.totalQuantity + qty;
                            $scope.totalAmount = parseFloat($scope.totalAmount) + (parseFloat(response.data.sell_price) * qty) + (parseFloat(response.data.sell_price_addition) * qty) + parseFloat(taxamount);
                        }
                        window.toastr.success("'"+response.data.p_name+"' Added to cart!", "Success!");
                    });
                } else {
                    if ((qty > response.data.quantity_in_stock) && response.data.p_type != 'service') {
                        window.toastr.error("This product is out of stock!", "Warning!");
                        return false;
                    }
                    var taxamount = 0;
                    if (response.data.tax_method == 'exclusive') {
                        taxamount = parseFloat(response.data.tax_amount);
                        $scope.itemTaxAmount = taxamount;
                    }
                    var itemVariantName = response.data.variant_name ? ' ('+ response.data.variant_name +')' : '';
                    var item = {};
                    item.id = response.data.p_id;
                    item.pType = response.data.p_type;
                    item.categoryId = response.data.category_id;
                    item.supId = response.data.sup_id;
                    item.name = response.data.p_name + itemVariantName;
                    item.unitName = response.data.unit_name;
                    item.img = response.data.p_image;
                    item.taxamount = taxamount;
                    item.variant_name = response.data.variant_name;
                    item.variant_slug = response.data.variant_slug;
                    item.sell_price_addition = parseFloat(response.data.sell_price_addition);
                    item.price = parseFloat(response.data.sell_price) + parseFloat(response.data.sell_price_addition) + taxamount;
                    item.quantity = qty;
                    item.subTotal = (parseFloat(response.data.sell_price) * qty) + (parseFloat(response.data.sell_price_addition) * qty) + parseFloat(taxamount);
                    $scope.itemArray.push(item);
                    $scope.totalQuantity = $scope.totalQuantity + qty;
                    console.log('totalAmount:'+parseFloat($scope.totalAmount) + 'sell_price:'+ + (parseFloat(response.data.sell_price) * qty) + 'sell_price_addition:'+ (parseFloat(response.data.sell_price_addition) * qty) + 'taxamount:'+ parseFloat(item.taxamount));
                    $scope.totalAmount = parseFloat($scope.totalAmount) + (parseFloat(response.data.sell_price) * qty) + (parseFloat(response.data.sell_price_addition) * qty) + parseFloat(item.taxamount);
                    window.toastr.success("'"+item.name+"' Added to cart!", "Success!");
                }
                $scope._calcTotalPayable();
                $scope.productName = '';
            }
            localStorageService.set('cart', $scope.itemArray);
            localStorageService.set('totalQuantity', $scope.totalQuantity);
            localStorageService.set('totalAmount', $scope.totalAmount);
            $scope.showLoader = !1;
            $("#prod-"+id+" .prod-inner-loader").removeClass("d-block");
        }, function(response) {
            window.toastr.error(response.data.errorMsg, "Warning!");
            $scope.showLoader = !1;
            $("#prod-"+id+" .prod-inner-loader").removeClass("d-block");
        });
    };

    if (localStorageService.get('cart')) {
        $scope.itemArray = localStorageService.get('cart');
        $scope.totalQuantity = localStorageService.get('totalQuantity');
        $scope.totalAmount = localStorageService.get('totalAmount');
        $scope._calcTotalPayable();
    }

    $scope.DecreaseItemFromInvoice = function (id, qty) {
        var qty = parseFloat(qty);
        if (!qty) { qty = 1; }
        if (id) {
            var find = window._.find($scope.itemArray, function (item) {
                return item.id == id;
            });
            if (find) {
                window._.map($scope.itemArray, function (item) {
                    if (item.id == id) {
                        if (item.quantity > 1) {
                            item.quantity = parseFloat(item.quantity) - qty;
                            $("#item_quantity_"+item.id).val(item.quantity);
                            item.subTotal = item.subTotal - ((parseFloat(item.price) * qty) + (parseFloat(item.sell_price_addition) * qty));
                            $scope.totalQuantity = $scope.totalQuantity - qty;
                            $scope.totalAmount = $scope.totalAmount - parseFloat(item.price);
                        } else {
                            window.toastr.error("Quantity can't be less than 1", "Warning!");
                        }
                    }
                });
            }
            $scope.totalItem = window._.size($scope.itemArray);
            $scope._calcTotalPayable();

            localStorageService.set('cart', $scope.itemArray);
            localStorageService.set('totalQuantity', $scope.totalQuantity);
            localStorageService.set('totalAmount', $scope.totalAmount);
        }
    };

    $scope.removeItemFromInvoice = function (index, id) {
        if ($scope.isEditMode) {
            if ($scope.itemArray.length <= 1) {
                window.toastr.error("Last item can not be removed!", "Warning!");
                return false;
            }
        }

        window._.map($scope.itemArray, function (item, key) {
            if (item.id == id) {
                $scope.totalQuantity = $scope.totalQuantity - item.quantity;
                $scope.totalAmount = parseFloat($scope.totalAmount) > parseFloat(item.subTotal) ?  $scope.totalAmount - parseFloat(item.subTotal) : 0;
                $scope.totalItem = $scope.totalItem - 1;
            }
        });

        $scope._calcTotalPayable();
        $scope.itemArray.splice(index, 1);
        $scope.totalItem = window._.size($scope.itemArray);

        localStorageService.set('cart', $scope.itemArray);
        localStorageService.set('totalQuantity', $scope.totalQuantity);
        localStorageService.set('totalAmount', $scope.totalAmount);
    };

    $scope.clearTheCart = function () {
        $scope.totalQuantity = 0;
        $scope.totalAmount = 0;
        $scope.totalItem = 0;
        $scope._calcTotalPayable();
        $scope.itemArray = [];
        localStorageService.set('cart', '');
        localStorageService.set('totalQuantity', 0);
        localStorageService.set('totalAmount', 0);
    };

    if (window.getParameterByName("store_id")) {
        $scope.clearTheCart();
        window.location = 'home.php';
    }

    $scope.triggerKeyup = false;
    $(document).delegate(".item_quantity", "keyup", function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        var  itemid = $(this).data("itemid");
        var  itemquantity = $(this).val();
        var totalAmount = 0;
        window._.map($scope.itemArray, function (item) {
            if (item.id == itemid) {
                item.quantity = itemquantity;
                item.subTotal = item.price * itemquantity;
                $scope.$applyAsync(function() {
                    $scope.itemArray = $scope.itemArray;
                });
            }
            totalAmount += item.subTotal;
            $scope.$applyAsync(function() {
                $scope.totalAmount = totalAmount;
                $scope._calcTotalPayable();
            });
        });
        if ($scope.triggerKeyup == false) {
            $scope.error = false;
        } else {
            $scope.triggerKeyup = false;
        }
    });


    // Place Order
    $scope.placeOrder = function() {
        var form = $("#orderForm");
        var actionUrl = form.attr("action");
        var pmethodName = $("#pmethod_name").val();
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
            if (response.data.status == 'ok') {
                localStorageService.set('cart', '');
                localStorageService.set('totalQuantity', 0);
                localStorageService.set('totalAmount', 0);
                window.swal({
                  title: "Success!",
                  text:  "#ReferenceNo: "+response.data.reference_no,
                  type: "success",
                  timer: 5000,
                  showConfirmButton: false
                })
                .then(function (willDelete) {
                    // if (willDelete) {
                        if (pmethodName == 'paypal') {
                            window.location = window.baseUrl+"/pp_checkout.php?reference_no="+response.data.reference_no;
                        } else {
                            window.location = window.baseUrl+"/success.php?reference_no="+response.data.reference_no;
                        }
                    // }
                });
            }
        }, function(response) {
            var alertMsg = "<div>";
            window.angular.forEach(response.data, function(value) {
                alertMsg += "<p>" + value + ".</p>";
            });
            alertMsg += "</div>";
            window.toastr.warning(alertMsg, "Warning!");
        });
    };

    // Delete Order
    $("#delete-order").on("click", function(e) {
        e.preventDefault();

        var refNo = $(this).data('refno');
        $http({
            url: window.baseUrl + "/_inc/order.php",
            method: "POST",
            data: "reference_no="+refNo+"&action_type=DELETE",
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json"
        }).
        then(function(response) {

            var alertMsg = response.data.msg;
            // window.toastr.success(alertMsg, "Success!");
            window.swal({
              title: "Deleted!",
              text:  alertMsg,
              type: "success",
              showConfirmButton: false
            })
            .then(function (willDelete) {
                if (willDelete) {
                    window.location = window.baseUrl+"/account.php?tab=orders";
                }
            });
            
        }, function(response) {

            var alertMsg = "<div>";
            window.angular.forEach(response.data, function(value) {
                alertMsg += "<p>" + value + ".</p>";
            });
            alertMsg += "</div>";
            window.toastr.warning(alertMsg, "Warning!");
        });
    });

    // Profile Edit
    $scope.ProfileEdit = function() {
        var form = $("#profileEditForm");
        var actionUrl = form.attr("action");
        $http({
            url: window.baseUrl + "/_inc/" + actionUrl,
            method: "POST",
            data: form.serialize(),
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json"
        }).
        then(function(response) {
            var alertMsg = "<div class=\"alert alert-success\">";
            alertMsg += "<p><i class=\"fa fa-check\"></i> " + response.data.msg + ".</p>";
            alertMsg += "</div>";
            window.swal({
              title: "Success!",
              text:  response.data.msg,
              type: "success",
              showConfirmButton: false
            })
            .then(function (willDelete) {
                if (willDelete) {
                    window.location = window.baseUrl+"/account.php?tab=profile_edit";
                }
            });
        }, function(response) {
            var alertMsg = "<div>";
            window.angular.forEach(response.data, function(value) {
                alertMsg += "<p>" + value + ".</p>";
            });
            alertMsg += "</div>";
            window.toastr.warning(alertMsg, "Warning!");
        });
    };

    // Change Password
    $scope.ChangePassword = function() {
        var form = $("#changePasswordForm");
        var actionUrl = form.attr("action");
        $http({
            url: window.baseUrl + "/_inc/" + actionUrl,
            method: "POST",
            data: form.serialize(),
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json"
        }).
        then(function(response) {
            window.swal({
              title: "Success!",
              text:  response.data.msg,
              type: "success",
              showConfirmButton: false
            })
            .then(function (willDelete) {
                if (willDelete) {
                    window.location = window.baseUrl+"/account.php?tab=change_password";
                }
            });
        }, function(response) {
            var alertMsg = "<div>";
            window.angular.forEach(response.data, function(value) {
                alertMsg += "<p>" + value + ".</p>";
            });
            alertMsg += "</div>";
            window.toastr.warning(alertMsg, "Warning!");
        });
    };

    // Change Email
    $scope.ChangeEmail = function() {
        var form = $("#changeEmailForm");
        var actionUrl = form.attr("action");
        $http({
            url: window.baseUrl + "/_inc/" + actionUrl,
            method: "POST",
            data: form.serialize(),
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json"
        }).
        then(function(response) {
            window.swal({
              title: "Success!",
              text:  response.data.msg,
              type: "success",
              showConfirmButton: false
            })
            .then(function (willDelete) {
                if (willDelete) {
                    window.location = window.baseUrl+"/account.php?tab=change_email";
                }
            });
        }, function(response) {
            var alertMsg = "<div>";
            window.angular.forEach(response.data, function(value) {
                alertMsg += "<p>" + value + ".</p>";
            });
            alertMsg += "</div>";
            window.toastr.warning(alertMsg, "Warning!");
        });
    };

    // Change Phone
    $scope.ChangePhone = function() {
        var form = $("#changePhoneForm");
        var actionUrl = form.attr("action");
        $http({
            url: window.baseUrl + "/_inc/" + actionUrl,
            method: "POST",
            data: form.serialize(),
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json"
        }).
        then(function(response) {
            window.swal({
              title: "Success!",
              text:  response.data.msg,
              type: "success",
              showConfirmButton: false
            })
            .then(function (willDelete) {
                if (willDelete) {
                    window.location = window.baseUrl+"/account.php?tab=change_phone";
                }
            });
        }, function(response) {
            var alertMsg = "<div>";
            window.angular.forEach(response.data, function(value) {
                alertMsg += "<p>" + value + ".</p>";
            });
            alertMsg += "</div>";
            window.toastr.warning(alertMsg, "Warning!");
        });
    };

    // Creatae Customer
    $scope.CreateCustomer = function() {
        var form = $("#createCustomerForm");
        var actionUrl = form.attr("action");
        $http({
            url: window.baseUrl + "/_inc/" + actionUrl,
            method: "POST",
            data: form.serialize(),
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json"
        }).
        then(function(response) {
            window.swal({
              title: "Success!",
              text:  response.data.msg,
              type: "success",
              showConfirmButton: false
            })
            .then(function (willDelete) {
                window.location = window.baseUrl+"/account_login.php";
            });
        }, function(response) {
            var alertMsg = "<div>";
            window.angular.forEach(response.data, function(value) {
                alertMsg += "<p>" + value + ".</p>";
            });
            alertMsg += "</div>";
            window.toastr.warning(alertMsg, "Warning!");
        });
    };


    // Login
    $scope.Login = function() {
        var form = $("#loginForm");
        var actionUrl = form.attr("action");
        $http({
            url: window.baseUrl + "/_inc/" + actionUrl,
            method: "POST",
            data: form.serialize(),
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json"
        }).
        then(function(response) {
            window.swal({
              title: "Success!",
              text:  response.data.msg,
              type: "success",
              showConfirmButton: false
            })
            .then(function (willDelete) {
                window.location = window.baseUrl+"/home.php";
            });
        }, function(response) {
            var alertMsg = "<div>";
            window.angular.forEach(response.data, function(value) {
                alertMsg += "<p>" + value + ".</p>";
            });
            alertMsg += "</div>";
            window.toastr.warning(alertMsg, "Warning!");
        });
    };

    // Variant
    $(".product-variant").on("select2:select", function (e) {
        e.preventDefault();
        var data = e.params.data;
        var variant_slug = data.element.value;
        window.location = "?product_id=" + getParameterByName('product_id') + "&variant_slug=" + variant_slug;
    });

}]);