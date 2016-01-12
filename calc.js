// calories calculator application controller

'use strict';

angular.module('calcApp', ['ngAnimate', 'ui.bootstrap'])
	.controller('calcCtrl', function ($scope, $http) {

		// object for user input params
		$scope.params = {};
		$scope.params.weight = undefined;
		$scope.params.height = undefined;
		$scope.params.age = undefined;
		$scope.params.gender = undefined;
		$scope.params.exercise = undefined;

		// object for result
		$scope.result = {};
		$scope.result.success = false;
		$scope.result.saveWeight = 0;
		$scope.result.lossWeight = 0;
		$scope.result.lossWeightAllowed = false;

		// watching for changes in user input params collection
		$scope.$watch('params', function() {
			var result = 0;
			var params = $scope.params;
			var result = $scope.result;

			// Not validating values here, only make sure that they are not falsy
			if (!(params.gender && params.weight && params.height && params.age && params.exercise)) {
				result.success = false;
				return;
			}
			// If user input seems to be ok, sending it to backend.
			// All numeric inputs are debounced to 500ms at ng-model level,
			// for prevent a multiply requests while typeing
			$http.post('./calc.php', params)
				.success(function(data) {
					result.success = !!data.success && data.saveWeight && data.lossWeight;
					result.saveWeight = data.saveWeight;
					result.lossWeight = data.lossWeight;
					result.lossWeightAllowed = !!data.lossWeightAllowed;
				});

		}, true);

	});
