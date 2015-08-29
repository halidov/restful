angular.module('Restful').controller('LoginCtrl', function ($scope, $state, AuthService) {

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
            $state.go('main');
        }, function (response) {
            $scope.failedLoginAttempt = true;
        });

    };
});