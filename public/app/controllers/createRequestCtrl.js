angular.module('magazijn').controller('createRequestCtrl',function($scope,$http,$location){

    // INITIALIZE PROMOITEMS ARRAY

    $scope.promoItems = [];

    // INITIALIZE INVENTORY ARRAY AND CURRENT JOB LIST ARRAY

    $scope.inventoryItems = [];
    $scope.currentRequestList = [];
    $scope.locationsList = [];
    $scope.errors = [];
    $scope.chosenAmount = 1;

    $scope.totaalprijs = 0;


    // GET INVENTORY LIST ITEMS

    $http.get('/user').success(function(data){
        $scope.user = data;
        $scope.userdata = data;
    });

    var getInventoryList = function(){
        $http.get('/inventory/get').success(function(response){
            $scope.inventoryItems = response;
        });
    };

    var getPromoInventoryList = function(){
        $http.get('/promoinventory/get').success(function(response){
            $scope.promoItems = response;
        });
    };

    // REMOVE ITEM FROM INVENTORY ITEM ARRAY

    var removeItemFromInventoryList = function(item){
        var index = $scope.inventoryItems.indexOf(item);
        $scope.inventoryItems.splice(index, 1);
        updateTotalPrice();
    };

    var removePromoItemFromInventoryList = function(item){
        var index = $scope.promoItems.indexOf(item);
        $scope.promoItems.splice(index, 1);
    };

    // ADD AND REMOVE FROM JOBLIST

    $scope.addItemToRequestList = function(item){
        $scope.currentRequestList.push(item);
        removeItemFromInventoryList(item);
        removePromoItemFromInventoryList(item);
    };

    $scope.addPromoItemToRequestList = function(item){
        $scope.currentRequestList.push(item);
        removePromoItemFromInventoryList(item);
        updateTotalPrice();
    };

    $scope.removeItemFromRequestList = function(item){
        var index = $scope.currentRequestList.indexOf(item);
        $scope.currentRequestList.splice(index, 1);
        $scope.inventoryItems.push(item);
    };

    $scope.removePromoItemFromRequestList = function(item){
        var index = $scope.currentRequestList.indexOf(item);
        $scope.currentRequestList.splice(index, 1);
        $scope.promoItems.push(item);
    };

    // CHANGE AMOUNT FOR ITEM

    $scope.changeAmountToOrder = function(item,amount){
        var index = $scope.currentRequestList.indexOf(item);
        $scope.currentRequestList[index].amountordered = amount;
        updateTotalPrice();
    };

    var changeItemAmountNegative = function(item,amount){
        var request = [item,amount];
        $http.post('/inventory/updateitemamountnegative',request);
    };

    var changePromoItemAmountNegative = function(item,amount){
        var request = [item,amount];
        $http.post('/promoinventory/updateitemamountnegative',request);
    };

    // LIVE SEARCH
    $('.inventory-search').keyup(function() {
        var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$', reg = RegExp(val, 'i'), text;
        $('table#inventoryItemTable tr.datarow').show().filter(function() {
            text = $(this).text().replace(/\s+/g, ' ');
            return !reg.test(text);
        }).hide();
    });

    // INVENTORY ITEM IMAGE SHOW / HIDE

    $scope.showInventoryItemImage = function(item){
        $('.imagepopup').append('<img src="/images/'+item.image+'"/>');
    };

    $scope.hideInventoryItemImage = function(){
        $('.imagepopup').empty();
    };

    // SAVE REQUEST

    $scope.saveRequest = function(){

        if($scope.currentRequestList.length > 0)
        {
            $.each($scope.currentRequestList, function(index, value){
                changeItemAmountNegative(value.code,value.amount);
            });
        }

        if($scope.comment == "" || $scope.comment == null){
            $scope.comment = "geen opmerkingen";
        }

        if($scope.errors.length == 0){
            var requestData = {'requests':$scope.currentRequestList,'comment':$scope.comment};

            $http.post('/beurs/request/save',requestData).success(function(data){
                $location.path('/');
            });

            updateTotalPrice();

            $http.post('/user/updatebudget',{'price':$scope.totaalprijs});
        }
    };

    $scope.savePromoRequest = function(){

        if($scope.currentRequestList.length > 0)
        {
            $.each($scope.currentRequestList, function(index, value){
                changePromoItemAmountNegative(value.code,value.amountordered);
            });
        }

        if($scope.comment == "" || $scope.comment == null){
            $scope.comment = "geen opmerkingen";
        }

        updateTotalPrice();

        if($scope.errors.length == 0){

            var requestData = {'requests':$scope.currentRequestList,'comment':$scope.comment,'price':$scope.totaalprijs};

            $http.post('/promo/request/save',requestData).success(function(data){
                $location.path('/');
            });

            $http.post('/user/updatebudget',{'price':$scope.totaalprijs});
        }
    };

    // MODAL

    $scope.openConfirmationDimmer = function(){

        updateTotalPrice();

        if($scope.currentRequestList.length != 0 && $scope.overbudget == 0){
            $('.ui.dimmer').dimmer('show');
        }
    }

    $scope.closeDimmer = function(){
        $('.ui.dimmer').dimmer('hide');
    }

    var updateTotalPrice = function(){

        $scope.totaalprijs = 0;

        $("td.prijs").each(function() {
            var value = parseFloat($(this).text().replace('€',''));
            if(!isNaN(value) && value.length != 0) {
                $scope.totaalprijs += parseFloat(value);
            }
        });

        if($scope.user.budget < $scope.totaalprijs){
            $scope.overbudget = 1;
        }else{
            $scope.overbudget = 0;
        }

    }

    // INIT

    $scope.init = function(){
        getInventoryList();
        getPromoInventoryList();
    };

    $scope.init();

});


