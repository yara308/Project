window.angularApp.factory("PurchaseOptionSelectorModal", ["API_URL", "window", "jQuery", "$http", "$uibModal", "$sce", "$rootScope", function(API_URL, window, $, $http, $uibModal, $sce, $scope) {
    return function($scope) {
        var item = $scope.item;
        var uibModalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: "modal-title",
            ariaDescribedBy: "modal-body",
            template: "<div class=\"modal-header\">" +
                           "<button ng-click=\"closePurchaseOptionSelectorModal();\" type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>" +
                           "<h3 class=\"modal-title\" id=\"modal-title\"><span class=\"fa fa-fw fa-th-large\"></span> {{ modal_title }}</h3>" +
                        "</div>" +
                        "<div class=\"modal-body\" id=\"modal-body\" style=\"background-color:#f6f6f6;\">" +
                            "<div bind-html-compile=\"rawHtml\"><span class=\"modal-loader\">Loading...</span></div>" +
                        "</div>" +
                        "<div class=\"modal-footer\">" +
                            "<button ng-click=\"closePurchaseOptionSelectorModal();\" type=\"button\" class=\"btn btn-info\"><span class=\"fa fa-fw fa-check\"></span> OK &nbsp;</button>&nbsp;&nbsp;" +
                        "</div>",
            controller: function ($scope, $uibModalInstance) {
                $http({
                  url: window.baseUrl + "/_inc/ajax.php?id=" + item.id + "&name=" + item.name + "&type=PURCHASEPRODUCTOPTIONS",
                  method: "GET"
                })
                .then(function(response, status, headers, config) {
                    $scope.modal_title = 'Select Option';
                    $scope.rawHtml = $sce.trustAsHtml(response.data);

                    setTimeout(function() {
                        window.storeApp.select2();
                        $(".variant-list-group-item").removeClass("active");
                        $("#variant_list_item_"+$scope.item.variantID).addClass("active");
                    }, 100);
                }, function(response) {
                    window.swal("Oops!", response.data.errorMsg, "error")
                    .then(function() {
                        $scope.closePurchaseOptionSelectorModal();
                    });
                });

                $scope.applyVariantPrice = function(id,name,purchasePrice,sellPrice,purchasePriceAddition,sellPriceAddition,variantID,variantSlug,variantName) {
                    // var thePriceField = $("#item_price_"+id);
                    // thePriceField.val(parseFloat(price)+parseFloat(purchasePriceAddition)).trigger("keyup");
                    $(".variant-list-group-item").removeClass("active");
                    $("#variant_list_item_"+variantID).addClass("active");

                    var find = window._.find($scope.itemArray, function (item) {
                        return item.id == id;
                    });
                    if (find) {
                        window._.map($scope.itemArray, function (item) {
                            if (item.id == id) {
                                if (item.quantity > 0) {
                                    if (window.store.sound_effect == 1) {
                                        window.storeApp.playSound("modify.mp3");
                                    }
                                    item.priceAddition = purchasePriceAddition;
                                    item.variantID = variantID;
                                    item.variantSlug = variantSlug;
                                    item.variantName = variantName;
                                    item.purchasePrice = parseFloat(purchasePrice) + parseFloat(purchasePriceAddition);
                                    item.sellPrice = parseFloat(sellPrice) + parseFloat(sellPriceAddition);
                                } else {
                                    if (window.store.sound_effect == 1) {
                                        window.storeApp.playSound("error.mp3");
                                    }
                                    window.toastr.error("Quantity can't be less than 1", "Warning!");
                                }
                            }
                        });
                    }
                }

                $scope.closePurchaseOptionSelectorModal = function () {
                    $uibModalInstance.dismiss("cancel");
                };
            },
            scope: $scope,
            size: "md",
            backdrop  : "static",
            keyboard: true,
        });
        
        uibModalInstance.result.catch(function () { 
                uibModalInstance.close(); 
        });
    };
}]);