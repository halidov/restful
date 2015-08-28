angular.module('Restful').controller('LoginCtrl', function ($scope, $location, AuthService) {

    $scope.submitForm = function (isValid) {
        $scope.failedLoginAttempt = false;

        if (!isValid) {
            console.log("form is not valid");
            return;
        }

        var user = {
            username: $scope.loginForm.username.$viewValue, password: $scope.loginForm.password.$viewValue
        };

        AuthService.login(user).then(function (user) {
            $location.path('/');
        }, function (response) {
            $scope.failedLoginAttempt = true;
        });

    };
});