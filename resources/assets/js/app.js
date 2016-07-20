var app = angular.module('magazijn', ["ngRoute","ngAnimate","ngToast","pascalprecht.translate"], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});



app.config(['$routeProvider', function($routeProvider){

    $routeProvider
        .when('/',{
            templateUrl: 'app/views/dashboard/index.html',
            controller: 'dashboardCtrl'
        }).when('/emailhandtekeningen',{
            templateUrl: 'app/views/emailhandtekening/index.html',
            controller: 'createEmailhandtekeningCtrl'
        }).when('/logos',{
            templateUrl: 'app/views/logos/index.html',
            controller: 'logosCtrl'
        }).when('/admin/aanvragen',{
            templateUrl: 'app/views/dashboard/admin.html',
            controller: 'adminCtrl'
        }).when('/admin/emailhandtekeningen',{
            templateUrl: 'app/views/emailhandtekening/admin.html',
            controller: 'adminCtrl'
        }).when('/admin/drukwerk',{
            templateUrl: 'app/views/drukwerk/admin.html',
            controller: 'adminCtrl'
        }).when('/admin/users',{
            templateUrl: 'app/views/gebruikers/index.html',
            controller: 'adminCtrl'
        }).when('/drukwerk/detail/:id',{
            templateUrl: 'app/views/drukwerk/detail.html',
            controller: 'drukwerkDetailCtrl'
        }).when('/promo/detail/:type/:id',{
            templateUrl: 'app/views/promo/detail/index.html',
            controller: 'orderDetailCtrl'
        }).when('/promo/aanvraag',{
            templateUrl: 'app/views/promo/aanvraag/index.html',
            controller: 'dashboardCtrl'
        }).when('/beurs/aanvraag',{
            templateUrl: 'app/views/materiaal/aanvraag/index.html',
            controller: 'dashboardCtrl'
        }).when('/beurs/detail/:type/:id',{
            templateUrl: 'app/views/materiaal/detail/index.html',
            controller: 'orderDetailCtrl'
        }).when('/drukwerk',{
            templateUrl: 'app/views/drukwerk/index.html',
            controller: 'drukwerkCtrl'
        }).otherwise({
            redirectTo: '/'
        });

}]);


app.config(function ($translateProvider) {
 
  $translateProvider.translations('nl', {
    'DOWNLOAD_IN_PDF': 'Download in PDF of JPG.',
    'NOTIFICATIONS': 'Notificaties',
    'LAST_ORDER_PROMO': 'Laatste bestellingen promomateriaal'
  });

  $translateProvider.translations('fr', {
    'DOWNLOAD_IN_PDF': 'Téléchanger en PDF ou JPG.',
    'NOTIFICATIONS': 'Notifications',
    'LAST_ORDER_PROMO': 'oui, non, baguette, hohohoh i iz french'
  });

  $translateProvider.preferredLanguage('nl');
 
});

app.controller('Ctrl', ['$translate', '$scope', function ($translate, $scope) {
 
  $scope.changeLanguage = function (langKey) {
    $translate.use(langKey);
  };
}]);