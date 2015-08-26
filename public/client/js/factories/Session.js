angular.module('Restful').factory('Session', function(Restangular) {
    var Session;
    Session = {
        login: function(data, bypassErrorInterceptor) {
            return Restangular
                .one('/')
                .withHttpConfig({bypassErrorInterceptor: bypassErrorInterceptor})
                .POST(data);
        }
    };
    return Session;
});