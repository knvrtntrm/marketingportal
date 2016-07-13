/**
 * Created by webdeveloper on 19/04/16.
 */
angular.module('magazijn').controller('drukwerkDetailCtrl', ['$scope','$http','$routeParams','$location', function($scope,$http,$routeParams,$location){

    var getUserInfo = function(){
        $http.get('/user').success(function(data){
            $scope.userdata = data;
        });
    }

    var getDrukwerkDetail = function(){
        $http.get('/drukwerk/detail/'+$routeParams.id).success(function(data){
            $scope.item = data;
        }).then(function(){
            $http.get('/drukwerk/'+$scope.item.id+'/files').success(function(data){
                $scope.files = data;
            });
        });
    }

    $scope.drukwerkFinished = function(item){
        $http.get('/drukwerk/finish/'+item.id).success(function(){
            $location.path('/admin/drukwerk');
        });
    }

    $scope.removeDrukwerk = function(item){
        $http.get('/drukwerk/remove/'+item.id).success(function(){
            $location.path('/admin/drukwerk');
        })
    }

    var getDrukwerkFiles = function(){

    }

    $scope.downloadFile = function(file){
        window.location = "/drukwerk/download/"+file.name;
    }

    $scope.init = function(){
        getUserInfo();
        getDrukwerkDetail();
        getDrukwerkFiles();
    }

    $scope.init();

}]);