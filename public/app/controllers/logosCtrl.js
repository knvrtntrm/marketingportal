angular.module('magazijn').controller('logosCtrl', ['$scope', '$http', function($scope,$http){

    $scope.logos;

    var getLogos = function(){
        $http.get('/logos/all').success(function(data){
            $scope.logos = data;
        });
    }

    $scope.downloadLogo = function(image,ext)
    {
        window.location = "/logos/download/"+image+"."+ext;
    }

    $scope.init = function(){

        getLogos();

    }

    $scope.init();

}]);