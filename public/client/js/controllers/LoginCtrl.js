angular.module('Restful').controller('LoginCtrl', function ($scope, $location, Session, AuthService) {

    $scope.submitForm = function (isValid) {
        $scope.failedLoginAttempt = false;

        if (!isValid) {
            console.log("form is not valid");
            return;
        }

        var user = {
            username: $scope.userForm.username.$viewValue, password: $scope.userForm.password.$viewValue
        };

        AuthService.login(user).then(function (user) {
            $location.path('/');
        }, function (response) {
            $scope.failedLoginAttempt = true;
        });

    };
});