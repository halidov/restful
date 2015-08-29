angular.module('Restful', ['ui.router', 'ngAnimate', 'restangular', 'LocalStorageModule'])
.run(function ($location, Restangular, AuthService) {
	Restangular.setFullRequestInterceptor(function (element, operation, route, url, headers, params, httpConfig) {
        if (AuthService.isAuthenticated()) {
            headers.Authorization = 'Basic ' + AuthService.getToken();
        }
        return {
            headers: headers
        };
    });

    Restangular.setErrorInterceptor(function (response, deferred, responseHandler, $scope) {
        if (response.config.bypassErrorInterceptor) {
            return true;
        } else {
            switch (response.status) {
                case 401:
                    AuthService.logout();
                    $location.path('/login');
                break;
                default:
                    throw new Error('No handler for status code ' + response.status);
                break;
            }
            return false;
        }
    });
})
.config(function ($stateProvider, $urlRouterProvider, RestangularProvider, $locationProvider) {
	RestangularProvider.setBaseUrl('http://' + location.host + '/api/');
    
    var viewsDir = 'views/';
    
    $locationProvider.html5Mode(true);

    var redirectIfAuthenticated = function (route) {
        return function ($location, $q, AuthService) {
            debugger
            if(AuthService.isAuthenticated())
                $location.path(route);
        }
    };

    var redirectIfNotAuthenticated = function (route) {
        return function ($location, $q, AuthService) {
            if(!AuthService.isAuthenticated())
                $location.path(route);
        }
    };

    $urlRouterProvider.otherwise('/');
    
    $stateProvider
        .state('main', {
            url: '/',
            controller: 'MainCtrl',
            templateUrl: viewsDir + 'main.html',
            resolve: {
                redirectIfNotAuthenticated: redirectIfNotAuthenticated('/login')
            }
        })
        .state('main.sub1', {
            url: 'sub1',
            controller: 'MainCtrl',
            templateUrl: viewsDir + 'main.html',
            resolve: {
                redirectIfNotAuthenticated: redirectIfNotAuthenticated('/login')
            }
        })
        .state('main.sub2', {
            url: 'sub2',
            controller: 'MainCtrl',
            templateUrl: viewsDir + 'main.html',
            resolve: {
                redirectIfNotAuthenticated: redirectIfNotAuthenticated('/login')
            }
        })
        .state('login', {
            url: '/login',
            controller: 'LoginCtrl',
            templateUrl: viewsDir + 'login.html',
            resolve: {
                redirectIfAuthenticated: redirectIfAuthenticated('/')
            }
        });
});