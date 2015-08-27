angular.module('Restful', ['ngRoute', 'restangular', 'LocalStorageModule'])
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
.config(function ($routeProvider, RestangularProvider, $locationProvider) {
	RestangularProvider.setBaseUrl('http://' + location.host + '/api/');
    
    var viewsDir = 'views/';
    
    $locationProvider.html5Mode(true);

    var redirectIfAuthenticated = function (route) {
        return function ($location, $q, AuthService) {

            var deferred = $q.defer();

            if (AuthService.isAuthenticated()) {
                deferred.reject();
                $location.path(route);
            } else {
                deferred.resolve();
            }
            return deferred.promise;
        };
    };

    var redirectIfNotAuthenticated = function (route) {
        return function ($location, $q, AuthService) {

            var deferred = $q.defer();

            if (!AuthService.isAuthenticated()) {
                deferred.reject();
                $location.path(route);
            } else {
                deferred.resolve();
            }
            return deferred.promise;
        };
    };

    $routeProvider
        .when('/', {
            controller: 'MainCtrl',
            templateUrl: viewsDir + 'main.html',
            resolve: {
                redirectIfNotAuthenticated: redirectIfNotAuthenticated('/login')
            }
        })
        .when('/login', {
            controller: 'LoginCtrl',
            templateUrl: viewsDir + 'login.html',
            resolve: {
                redirectIfAuthenticated: redirectIfAuthenticated('/')
            }
        })
        .otherwise({
            redirectTo: '/'
        });
});