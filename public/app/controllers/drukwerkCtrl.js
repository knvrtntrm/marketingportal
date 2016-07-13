/**
 * Created by webdeveloper on 18/04/16.
 */
angular.module('magazijn').controller('drukwerkCtrl', ['$scope', '$http','$location', function($scope,$http,$location){

    var getDrukwerk = function(){
        $http.get('/drukwerk/get').success(function(data){
           $scope.drukwerk = data;
        });
    }

    $scope.showDrukwerkDetail = function(item){
        $location.path('/drukwerk/detail/'+item.id);
    }

    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        clearBtn: true,
        calendarWeeks: true,
        todayHighlight: true,
        startDate: '+21d'
    });

    $('.datepicker').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });

    $scope.init = function(){

        getDrukwerk();

    }

    $scope.init();

}]);