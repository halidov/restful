angular.module('Restful').service('AuthService', function ($q, localStorageService, Session) {

    this.login = function(credentials) {
        var me = this;
        deferred = $q.defer();
        var token = me.setToken(credentials);
        Session.login(token, true).then(function(user) {
            return deferred.resolve(user);
        }, function(response) {
            if (response.status == 401) {
                me.logout();
                return deferred.reject(false);
            }
            throw new Error('No handler for status code ' + response.status);
        });
        return deferred.promise;
    };

    this.logout = function() {
        localStorageService.clearAll();
    };

    this.isAuthenticated = function() {
        var token = this.getToken();
        return token !== null;
    };

    this.setToken = function(credentials) {
        var token = btoa(credentials.username + ':' + credentials.password);
        localStorageService.set('token', token);
        return token;
    };

    this.getToken = function() {
        return localStorageService.get('token');
    };

    return this;
});