/**
 * Created by webdeveloper on 13/04/16.
 */
angular.module('magazijn').controller('orderDetailCtrl', ['$scope', '$http','$routeParams', function($scope,$http,$routeParams){

    var getOrderDetails = function(){
        $http.get('/promo/detail/'+$routeParams.id).success(function(data){
            $scope.order = data;
        })
    }

    var getBeursOrderDetails = function(){
        $http.get('/beurs/detail/'+$routeParams.id).success(function(data){
            $scope.order = data;
        })
    }

    $scope.init = function(){
        if($routeParams.type == "promo"){
            getOrderDetails();
        }else if($routeParams.type == "beurs"){
            getBeursOrderDetails();
        }
    }

    $scope.init();

}]);