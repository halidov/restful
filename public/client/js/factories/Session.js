angular.module('Restful').factory('Session', function(Restangular) {
    var Session;
    Session = {
        login: function(token, bypassErrorInterceptor) {
            return Restangular
                .one('/')
                .withHttpConfig({bypassErrorInterceptor: bypassErrorInterceptor})
                .get({}, {}, {'Authorization': 'Basic '+token});
        }
    };
    return Session;
});