/**
 * Created by webdeveloper on 11/04/16.
 */
angular.module('magazijn').controller('adminCtrl',[ '$scope','$http','$location','$rootScope','ngToast', function($scope,$http,$location,$rootScope,ngToast){

    // AANVRAGEN

    $scope.requests = [];
    $scope.promorequests = [];
    $scope.userdata;
    $rootScope.amountofnewsignatures = 0;

    $('.tabular.menu .item').tab();

    var getUserdata = function(){
        $http.get('/user').success(function(data){
            $scope.userdata = data;
        })
    }

    var getBeursAanvragen = function(){
        $http.get('/promoaanvragen/all').success(function(data){
            $scope.promorequests = data;
        });
    }

    var getPromoAanvragen = function(){
        $http.get('/beursaanvragen/all').success(function(data){
            $scope.requests = data;
        });
    }

    // EMAILHANDTEKENINGEN

    $scope.signatures = [];

    var getEmailhandtekeningen = function(){
        $http.get('/emailhandtekeningen/all').success(function(data){
            $scope.signatures = data;
            $rootScope.amountofnewsignatures = $scope.signatures.length;
        })


    }

    $scope.approveSignature = function(signature)
    {
        $http.get('/emailhandtekeningen/approve/'+signature).success(function(data){
            getEmailhandtekeningen();
        });
    }

    $scope.declineSignature = function(signature){
        $http.get('/emailhandtekeningen/decline/'+signature).success(function(data){
            getEmailhandtekeningen();
        });
    }

    // ORDER DETAIL

    $scope.showOrderDetail = function(item){
        $location.path('/promo/detail/promo/'+item.id);
    }

    $scope.showBeursOrderDetail = function(item){
        $location.path('/beurs/detail/beurs/'+item.id);
    }

    // DRUKWERK

    $scope.showDrukwerkDetail = function(item){
        $location.path('/drukwerk/detail/'+item.id);
    }

    var getDrukwerk = function(){
        $http.get('/drukwerk/all').success(function(data){
           $scope.drukwerk = data;
        });
    }

    // USERS
    
    var getAllUsers = function(){
        $('.edituserbox').hide();
        $http.get('/users/all').success(function(data){
            $scope.allusers = data;
        });
    }

    $scope.editUser = function(user){
        $scope.userdetails = user;
        $('.edituserbox').show();
    }

    $scope.updateUserData = function(user){
        
        $http.post('/user/update', user).success(function(data){
           $scope.userdetails = [];
           $('.edituserbox').hide();
           ngToast.create({
                className: 'success',
                content: 'Wijzigingen voor '+user.name+' zijn opgeslaan!'
            });
        });
    }

    // INIT

    $scope.init = function(){
        getUserdata();
        getBeursAanvragen();
        getPromoAanvragen();
        getEmailhandtekeningen();
        //getDrukwerk();
        getAllUsers();
    }

    $scope.init();

}]);