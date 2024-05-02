window.angularApp.factory("AddItemNoteModal", ["API_URL", "window", "jQuery", "$http", "$uibModal", "$sce", "$rootScope", function(API_URL, window, $, $http, $uibModal, $sce, $scope) {
    return function($scope) {
        var theItem = $scope.item;
        var uibModalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: "modal-title",
            ariaDescribedBy: "modal-body",
            template: "<div class=\"modal-header\">" +
                           "<button ng-click=\"closeAddItemNoteModal();\" type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>" +
                           "<h3 class=\"modal-title\" id=\"modal-title\"><span class=\"fa fa-fw fa-th-large\"></span> {{ modal_title }}</h3>" +
                        "</div>" +
                        "<div class=\"modal-body\" id=\"modal-body\" style=\"background-color:#f6f6f6;\">" +
                            "<div bind-html-compile=\"rawHtml\" style=\"padding:10px 20px;\"><span class=\"modal-loader\">Loading...</span></div>" +
                        "</div>" +
                        "<div class=\"modal-footer\">" +
                            "<button ng-click=\"closeAddItemNoteModal();\" type=\"button\" class=\"btn btn-info\"><span class=\"fa fa-fw fa-check\"></span> OK &nbsp;</button>&nbsp;&nbsp;" +
                        "</div>",
            controller: function ($scope, $uibModalInstance) {
                $scope.modal_title = 'Add Note for ' + theItem.name;
                $scope.rawHtml = $sce.trustAsHtml('<textarea class="form-control" id="item-note-'+theItem.id+'" name="item-note-'+theItem.id+'" cols="3" placeholder="Add note here">'+theItem.notes+'</textarea>');
                $scope.closeAddItemNoteModal = function () {
                    var find = window._.find($scope.itemArray, function (item) {
                        return item.id == theItem.id;
                    });
                    if (find) {
                        window._.map($scope.itemArray, function (item) {
                            if (item.id == theItem.id) {
                                item.notes = $("#item-note-"+item.id).val();
                            }
                        });
                    }
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