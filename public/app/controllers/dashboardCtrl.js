angular.module('magazijn').controller('dashboardCtrl', ['$scope', '$http', '$location', 'ngToast', '$rootScope','$filter', function ($scope, $http, $location, ngToast, $rootScope, $filter) {

        $scope.requests = [];
        $scope.promorequests = [];
        $scope.userdata;
        $rootScope.notifications = [];

         


        $('.tabular.menu .item').tab();

        var getRequests = function () {
            $('.loadingspinner-beurs').show();
            $('.no-orders').hide();
            $http.get('/requests/all').success(function (data) {
                $scope.requests = data;
                $('.loadingspinner-beurs').hide();
                $('.no-orders').show();
            });
        }

        $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        clearBtn: true,
        orientation: 'auto bottom',
        calendarWeeks: true,
        todayHighlight: true
    });

    $('.datepicker').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });

        var getPromoRequests = function () {
            $('.loadingspinner-promo').show();
            $('.no-orders').hide();
            $http.get('/requests/promo/all').success(function (data) {
                $scope.promorequests = data;
                $('.loadingspinner-promo').hide();
                $('.no-orders').show();
            })
        }

        var getUserInfo = function () {
            $http.get('/user').success(function (data) {
                $scope.userdata = data;

                if ($scope.userdata.admin) {
                    $location.path('/admin/aanvragen');
                }

            }).then(function () {
                getRequests();
                getPromoRequests();

                getInventoryList();
                getPromoInventoryList();

                getNots();
                budgetcalcs();
            });
        }

        // INITIALIZE PROMOITEMS ARRAY

        $scope.promoItems = [];

        // INITIALIZE INVENTORY ARRAY AND CURRENT JOB LIST ARRAY

        $scope.inventoryItems = [];
        $scope.currentRequestList = [];
        $scope.locationsList = [];
        $scope.errors = [];
        $scope.chosenAmount = 1;

        $scope.totaalprijs = 0;


        // RESET FORMS

        $scope.resetForms = function () {
            $scope.currentRequestList = [];
            $scope.chosenAmount = 1;
            $scope.totaalprijs = 0;
            getInventoryList();
            getPromoInventoryList();
        }

        //SET LOCALE
        
        $rootScope.changeLocal = function(lang){
            $http.get('/setlocale/'+lang).success(function(response){
                console.log(lang);
            });
        };

        // GET INVENTORY LIST ITEMS

        $http.get('/user').success(function (data) {
            $scope.user = data;
            $scope.userdata = data;
        });

        var getInventoryList = function () {
            $('.loadingspinner').show();
            $http.get('/inventory/get').success(function (response) {
                $scope.inventoryItems = response;
                $('.loadingspinner').hide();
            });
        };

        var getPromoInventoryList = function () {
            $('.loadingspinner').show();
            $http.get('/promoinventory/get').success(function (response) {
                $scope.promoItems = response;
                $('.loadingspinner').hide();
            });
        };

        // REMOVE ITEM FROM INVENTORY ITEM ARRAY

        var removeItemFromInventoryList = function (item) {
            var index = $scope.inventoryItems.indexOf(item);
            $scope.inventoryItems.splice(index, 1);
        };

        var removePromoItemFromInventoryList = function (item) {
            var index = $scope.promoItems.indexOf(item);
            $scope.promoItems.splice(index, 1);
            updateTotalPrice();
        };

        // ADD AND REMOVE FROM JOBLIST

        $scope.addItemToRequestList = function (item) {
            $scope.currentRequestList.push(item);
            removeItemFromInventoryList(item);
            ;
        };

        $scope.addPromoItemToRequestList = function (item) {
            $scope.currentRequestList.push(item);
            removePromoItemFromInventoryList(item);
            updateTotalPrice();
        };

        $scope.removeItemFromRequestList = function (item) {
            var index = $scope.currentRequestList.indexOf(item);
            $scope.currentRequestList.splice(index, 1);
            $scope.inventoryItems.push(item);
        };

        $scope.removePromoItemFromRequestList = function (item) {
            var index = $scope.currentRequestList.indexOf(item);
            $scope.currentRequestList.splice(index, 1);
            $scope.promoItems.push(item);
            updateTotalPrice();
        };

        // CHANGE AMOUNT FOR ITEM

        $scope.changeAmountToOrder = function (item, amount) {

            if ($scope.chosenAmount > item.amountinstock) {
                $scope.chosenAmount = item.amountinstock;
            }

            var index = $scope.currentRequestList.indexOf(item);
            $scope.currentRequestList[index].amountordered = amount;

            updateTotalPrice();
        };

        var changeItemAmountNegative = function (item, amount) {
            var request = [item, amount];
            $http.post('/inventory/updateitemamountnegative', request);
        };

        var changePromoItemAmountNegative = function (item, amount) {
            var request = [item, amount];
            console.log(request);
            $http.post('/promoinventory/updateitemamountnegative', request);
        };

        // LIVE SEARCH
        $('.inventory-search').keyup(function () {
            var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$', reg = RegExp(val, 'i'), text;
            $('table#inventoryItemTable tr.datarow').show().filter(function () {
                text = $(this).text().replace(/\s+/g, ' ');
                return !reg.test(text);
            }).hide();
        });

        // INVENTORY ITEM IMAGE SHOW / HIDE

        $scope.showInventoryItemImage = function (item) {
            $('.imagepopup').append('<img src="/images/' + item.image + '"/>');
        };

        $scope.hideInventoryItemImage = function () {
            $('.imagepopup').empty();
        };

        // SAVE REQUEST

        $scope.saveRequest = function () {

            if ($('.locatiefield').val() == "" || $('.datumfield').val() == "")
            {

                ngToast.create({
                    className: 'danger',
                    content: $filter('translate')('ERROR_LOCATION_DATE')
                });
                
                return false;

            } else {
                if ($scope.currentRequestList.length > 0)
                {
                    $.each($scope.currentRequestList, function (index, value) {
                        if (value.amount) {
                            changeItemAmountNegative(value.code, value.amount);
                        } else {
                            changeItemAmountNegative(value.code, 1);
                        }

                    });
                }

                if ($scope.comment == "" || $scope.comment == null) {
                    $scope.comment = "geen opmerkingen";
                }

                if ($scope.errors.length == 0) {
                    var requestData = {'requests': $scope.currentRequestList, 'comment': $scope.comment, 'locatie': $scope.locatie, 'datum': $scope.datum};

                    $http.post('/beurs/request/save', requestData).success(function (data) {
                        ngToast.create({
                            className: 'success',
                            content: $filter('translate')('ORDER_REGISTER_SUCCESS')
                        });
                        getRequests();
                    });

                    $http.post('/user/updatebudget', {'price': $scope.totaalprijs});
                }
                
                $location.path('/');
            }


        };

        $scope.savePromoRequest = function () {

            if ($scope.currentRequestList.length > 0)
            {
                $.each($scope.currentRequestList, function (index, value) {
                    if (value.amountordered) {
                        changePromoItemAmountNegative(value.code, value.amountordered);
                    } else {
                        changePromoItemAmountNegative(value.code, 1);
                    }

                });
            }

            if ($scope.comment == "" || $scope.comment == null) {
                $scope.comment = "geen opmerkingen";
            }

            if ($scope.errors.length == 0) {

                var requestData = {'requests': $scope.currentRequestList, 'comment': $scope.comment, 'price': $scope.totaalprijs};

                $http.post('/promo/request/save', requestData).success(function (data) {
                    ngToast.create({
                        className: 'success',
                        content: $filter('translate')('ORDER_REGISTER_SUCCESS')
                    });
                    getPromoRequests();
                });

                $http.post('/user/updatebudget', {'price': $scope.totaalprijs});
            }
        };

        // MODAL

        $scope.openConfirmationDimmer = function () {

            if ($scope.currentRequestList.length != 0) {
                $('.promomodal').modal('show');
            }
        }

        $scope.openItemConfirmationDimmer = function () {

            if ($scope.currentRequestList.length != 0) {
                $('.beursmodal').modal('show');
            }
        }

        $scope.closeDimmer = function () {
            $('.ui.dimmer').dimmer('hide');
            $('.ui.dimmer.beursdimmer').dimmer('hide');
        }

        var updateTotalPrice = function () {

            $scope.totaalprijs = 0;

            for (var i = 0; i < $scope.currentRequestList.length; i++) {
                if ($scope.currentRequestList[i].amountordered) {
                    $scope.totaalprijs += ($scope.currentRequestList[i].amountordered * $scope.currentRequestList[i].price);
                } else {
                    $scope.totaalprijs += $scope.currentRequestList[i].price;
                }
            }

            if ($scope.totaalprijs > $scope.userdata.budget) {
                $('.totaalprijs').css('color', '#FF6666');
                $('button.confirmbutton').addClass('disabled');
            } else {
                $('.totaalprijs').css('color', '#5E6979');
                $('button.confirmbutton').removeClass('disabled');
            }

            budgetcalcs();

        }

        var budgetcalcs = function () {
            $('.budget-progress-bar').css('width', ($scope.userdata.budget / 720) * 100 + '%');
            $('.overzicht-budget-progress-bar').css('width', (($scope.userdata.budget - $scope.totaalprijs) / 720) * 100 + '%');
            $('.ordering-progress-bar').css('width', ($scope.totaalprijs / 720) * 500);

            if (($scope.userdata.budget - $scope.totaalprijs) < 0) {
                ngToast.create({
                    className: 'danger',
                    content: $filter('translate')('ERROR_OVER_BUDGET')
                });
            }

        }


        $scope.showOrderDetail = function (item) {
            $location.path('/promo/detail/promo/' + item.id);
        }

        $scope.showBeursOrderDetail = function (item) {
            $location.path('/beurs/detail/beurs/' + item.id);
        }

        $scope.init = function () {

            getUserInfo();

        }

        var getNots = function () {
            $http.get('/notifications').success(function (data) {
                if ($rootScope.notifications.length < data.length) {
                    $.playSound("sounds/not");
                }

                $rootScope.notifications = data;

            })
        }

        $rootScope.updateNotifications = function () {
            setInterval(function () {

                getNots();

            }, 10000);
        }

        $rootScope.notificationDetail = function (notification) {
            $http.get('/notifications/read/' + notification.id).success(function (data) {
                getNots();
            });
        }

        $rootScope.clearNotifications = function () {
            $http.get('/notifications/clear/' + $scope.userdata.id).success(function () {
                getNots();
            });
        }

        $scope.init();

    }]).config(['ngToastProvider', function (ngToast) {
        ngToast.configure({
            verticalPosition: 'top',
            horizontalPosition: 'center',
            maxNumber: 1,
            animation: 'fade'
        })
    }]);