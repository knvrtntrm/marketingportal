/**
 * Created by webdeveloper on 13/04/16.
 */
angular.module('magazijn').controller('orderDetailCtrl', ['$scope','$location', '$http','$routeParams', function($scope,$location,$http,$routeParams){



    var getOrderDetails = function(){
        $('.loadingspinner').show();
        $http.get('/promo/detail/'+$routeParams.id).success(function(data){
            $scope.order = data;
            $('.loadingspinner').hide();
        })
    }

    var getBeursOrderDetails = function(){
        $('.loadingspinner').show();
        $http.get('/beurs/detail/'+$routeParams.id).success(function(data){
            $scope.order = data;
            $('.loadingspinner').hide();
        })
    }

    $scope.removePromoItemFromOrder = function(item){
        $http.get('/order/remove/promo/'+$scope.order.id+'/'+item.id).success(function(data){
            console.log('removed');
            $scope.init();
            if(data == 'remove')
            {
                $location.path('/');
            }
        });
    }

    $scope.removeBeursItemFromOrder = function(item){
        $http.get('/order/remove/beurs/'+$scope.order.id+'/'+item.id).success(function(data){
            console.log('removed');
            $scope.init();
            if(data == 'remove')
            {
                $location.path('/');
            }
        });
    }

    $scope.init = function(){
        if($routeParams.type == "promo"){
            getOrderDetails();
        }else if($routeParams.type == "beurs"){
            getBeursOrderDetails();
        }
        $scope.admin = false;
        $http.get('/user').success(function(data){
            $scope.userdata = data;
            if($scope.userdata.admin)
            {
                $scope.admin = true;
            }
        });

        
    }

    $scope.init();

}]);