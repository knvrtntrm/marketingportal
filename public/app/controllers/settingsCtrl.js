angular.module('magazijn').controller('settingsCtrl', ['$scope','$filter','$http','$location','ngToast', function($scope,$filter,$http,$location,ngToast){

	$scope.changePassword = function(){

		if($scope.password == $scope.passwordrepeat && $scope.password != undefined && $scope.passwordrepeat != undefined)
		{
			$('.passrepeat').text($filter('translate')('PASSWORD_REPEAT')).css('color','#000');
			$http.post('/password/manualreset',{"password" : $scope.password})
				.success(function(response){
					ngToast.create({
		                className: 'success',
		                content: $filter('translate')('PASSWORD_SUCCESS')
		            });
					$location.path('/');
				});

		}else{

			$('.passrepeat').text($filter('translate')('PASSWORD_NO_MATCH')).css('color','#ff0000');

		}

	}

}]);