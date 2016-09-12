(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";

var app = angular.module('magazijn', ["ngRoute", "ngAnimate", "ngToast", "pascalprecht.translate"], function ($interpolateProvider, $translateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
    $translateProvider.useSanitizeValueStrategy('escape');
});

app.config(['$routeProvider', function ($routeProvider) {

    $routeProvider.when('/', {
        templateUrl: 'app/views/dashboard/index.html',
        controller: 'dashboardCtrl'
    }).when('/emailhandtekeningen', {
        templateUrl: 'app/views/emailhandtekening/index.html',
        controller: 'createEmailhandtekeningCtrl'
    }).when('/logos', {
        templateUrl: 'app/views/logos/index.html',
        controller: 'logosCtrl'
    }).when('/admin/aanvragen', {
        templateUrl: 'app/views/dashboard/admin.html',
        controller: 'adminCtrl'
    }).when('/admin/emailhandtekeningen', {
        templateUrl: 'app/views/emailhandtekening/admin.html',
        controller: 'adminCtrl'
    }).when('/admin/drukwerk', {
        templateUrl: 'app/views/drukwerk/admin.html',
        controller: 'adminCtrl'
    }).when('/admin/users', {
        templateUrl: 'app/views/gebruikers/index.html',
        controller: 'adminCtrl'
    }).when('/drukwerk/detail/:id', {
        templateUrl: 'app/views/drukwerk/detail.html',
        controller: 'drukwerkDetailCtrl'
    }).when('/promo/detail/:type/:id', {
        templateUrl: 'app/views/promo/detail/index.html',
        controller: 'orderDetailCtrl'
    }).when('/promo/aanvraag', {
        templateUrl: 'app/views/promo/aanvraag/index.html',
        controller: 'dashboardCtrl'
    }).when('/beurs/aanvraag', {
        templateUrl: 'app/views/materiaal/aanvraag/index.html',
        controller: 'dashboardCtrl'
    }).when('/beurs/detail/:type/:id', {
        templateUrl: 'app/views/materiaal/detail/index.html',
        controller: 'orderDetailCtrl'
    }).when('/drukwerk', {
        templateUrl: 'app/views/drukwerk/index.html',
        controller: 'drukwerkCtrl'
    }).when('/instellingen', {
        templateUrl: 'app/views/dashboard/settings.html',
        controller: 'settingsCtrl'
    }).otherwise({
        redirectTo: '/'
    });
}]);

app.config(function ($translateProvider) {

    $translateProvider.useStaticFilesLoader({
        prefix: 'lang/locale-',
        suffix: '.json'
    });

    $translateProvider.preferredLanguage('nl');
});

app.controller('Ctrl', ['$translate', '$scope', function ($translate, $scope) {

    $scope.changeLanguage = function (langKey) {
        $translate.use(langKey);
    };
}]);

},{}]},{},[1]);

//# sourceMappingURL=main.js.map
