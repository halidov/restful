angular.module('Restful', ['ui.router', 'ngAnimate', 'restangular', 'LocalStorageModule'])
.run(function ($rootScope, $state, Restangular, AuthService) {
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
                    $state.go('login');
                break;
                default:
                    throw new Error('No handler for status code ' + response.status);
                break;
            }
            return false;
        }
    });

    $rootScope.$on('$stateChangeStart', function(e, toState, toParams, fromState, fromParams) {
        var isLogin = toState.name === "login";
        var loggedIn = AuthService.isAuthenticated();
        if((isLogin && !loggedIn) || (!isLogin && loggedIn)) {
           return;
        }
        e.preventDefault();
        if(isLogin && loggedIn) $state.go('main');
        else if(!isLogin && !loggedIn) $state.go('login');
    });
})
.config(function ($stateProvider, $urlRouterProvider, RestangularProvider, $locationProvider) {
	RestangularProvider.setBaseUrl('http://' + location.host + '/api/');
    
    var viewsDir = 'views/';
    
    $locationProvider.html5Mode(true);

    $urlRouterProvider.otherwise(function ($injector) {
        var $state = $injector.get('$state');
        $state.go('main');
    });
    
    $stateProvider
        .state('main', {
            url: '/',
            controller: 'MainCtrl',
            templateUrl: viewsDir + 'main.html'
        })
        .state('main.sub1', {
            url: 'sub1',
            controller: 'MainCtrl',
            templateUrl: viewsDir + 'main.html'
        })
        .state('main.sub2', {
            url: 'sub2',
            controller: 'MainCtrl',
            templateUrl: viewsDir + 'main.html'
        })
        .state('login', {
            url: '/login',
            controller: 'LoginCtrl',
            templateUrl: viewsDir + 'login.html'
        });
});