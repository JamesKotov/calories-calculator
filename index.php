<?php
require('./config.php');
?>
<!DOCTYPE html>
<html lang="en" ng-app="calcApp">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Test task for HireRight">
		<meta name="author" content="Eugene Strigo eugene@strigo.ru">
		<title>Test task for HireRight</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="/hireright/styles.css">
	</head>
	<body>
		<div class="container-fluid" ng-controller="calcCtrl">
			<div class="row">
				<div class="col-md-12">
					<h3>Test task for HireRight</h3>
					<uib-tabset>
						<!-- calculator tab -->
						<uib-tab heading="Calculator">
							<div class="row">
								<!-- calculator form column -->
								<div class="col-md-6">
									<h3>Calories Per Day Calculator</h3>
									<p>Please, fill the form to&#160;get your individual calculation.</p>

									<form class="form-horizontal" name="calcData">

										<!-- gender -->
										<div class="form-group">
											<label for="genderMale" class="col-sm-2 control-label">Gender</label>
											<div class="col-sm-10">
											    <div class="btn-group">
													<label class="btn btn-default" ng-model="params.gender" uib-btn-radio="'male'">Male</label>
													<label class="btn btn-default" ng-model="params.gender" uib-btn-radio="'female'">Female</label>
												</div>
												<div>
													<span>we don't preselect it, to prevent gender discrimination :)</span>
												</div>
											</div>
										</div>

										<!-- weight -->
										<div class="form-group">
											<label for="inputWeight" class="col-sm-2 control-label">Weight</label>
											<div class="col-sm-10">
												<input type="number" min="<?=$oConfig->iMinWeight?>" max="<?=$oConfig->iMaxWeight ?>" maxlength="3" required name="weight"
													ng-model="params.weight" ng-model-options="{ debounce: 500 }" class="form-control" placeholder="50" id="inputWeight">
												<span class="error-hint" ng-show="calcData.weight.$error.required && !calcData.weight.$pristine;">You must enter your weight</span>
												<span class="error-hint" ng-show="calcData.weight.$invalid && !(calcData.weight.$error.required || calcData.weight.$error.max || calcData.weight.$error.min || calcData.weight.$pristine)">Sorry, only digits available</span>
												<span class="error-hint" ng-show="calcData.weight.$error.max">OMG, too max</span>
												<span class="error-hint" ng-show="calcData.weight.$error.min">Whoops, so min</span>
												<span ng-show="calcData.weight.$valid || calcData.weight.$pristine;">in kilograms</span>
											</div>
										</div>

										<!-- height -->
										<div class="form-group">
											<label for="inputHeight" class="col-sm-2 control-label">Height</label>
											<div class="col-sm-10">
												<input type="number" min="<?=$oConfig->iMinHeight ?>" max="<?=$oConfig->iMaxHeight ?>" maxlength="3" required name="height"
													ng-model="params.height" ng-model-options="{ debounce: 500 }" class="form-control" placeholder="170" id="inputHeight">
												<span class="error-hint" ng-show="calcData.height.$error.required && !calcData.height.$pristine;">You must enter your height</span>
												<span class="error-hint" ng-show="calcData.height.$invalid && !(calcData.height.$error.required || calcData.height.$error.max || calcData.height.$error.min || calcData.height.$pristine)">Sorry, only digits available</span>
												<span class="error-hint" ng-show="calcData.height.$error.max">Oh, you are too high</span>
												<span class="error-hint" ng-show="calcData.height.$error.min">Sorry, you are too small</span>
												<span ng-show="calcData.height.$valid || calcData.height.$pristine;">in centimeters</span>
											</div>
										</div>

										<!-- age -->
										<div class="form-group">
											<label for="inputAge" class="col-sm-2 control-label">Age</label>
											<div class="col-sm-10">
												<input type="number" min="<?=$oConfig->iMinAge ?>" max="<?=$oConfig->iMaxAge ?>" maxlength="3" required name="age"
													ng-model="params.age" ng-model-options="{ debounce: 500 }" class="form-control" placeholder="30" id="inputAge">
												<span class="error-hint" ng-show="calcData.age.$error.required && !calcData.age.$pristine;">You must enter your age</span>
												<span class="error-hint" ng-show="calcData.age.$invalid && !(calcData.age.$error.required || calcData.age.$error.max || calcData.age.$error.min || calcData.age.$pristine)">Sorry, only digits available</span>
												<span class="error-hint" ng-show="calcData.age.$error.max">My respect, but you're too old to think about health</span>
												<span class="error-hint" ng-show="calcData.age.$error.min">It seems, you are too young for this test</span>
												<span ng-show="calcData.age.$valid || calcData.age.$pristine;">in years</span>
											</div>
										</div>

										<!-- exercise -->
										<div class="form-group">
											<label class="col-sm-2 control-label">Exercise level</label>
											<div class="col-sm-10">
											    <div class="btn-group">
													<label class="btn btn-default" ng-model="params.exercise" uib-btn-radio="1">Sedentary</label>
													<label class="btn btn-default" ng-model="params.exercise" uib-btn-radio="2">Lightly Active</label>
													<label class="btn btn-default" ng-model="params.exercise" uib-btn-radio="3">Moderately Active</label>
													<label class="btn btn-default" ng-model="params.exercise" uib-btn-radio="4">Very Active</label>
													<label class="btn btn-default" ng-model="params.exercise" uib-btn-radio="5">Extremely Active</label>
												</div>
											</div>
										</div>

									</form>
								</div>

								<!-- calculator info and results column -->
								<div class="col-md-6">
										<h3>&#160;</h3>

										<!-- info block -->
										<div data-ng-show="!result.success">
											<p>This adult daily calories calculator gives an&#160;approximation of&#160;your <em>basal metabolic rate</em>&#160;&#8212; the number of&#160;calories
												per day your body burns, and therefore the number of&#160;calories you could eat per day to&#160;maintain your current weight.</p>
											<p>If&#160;your goal is&#160;to&#160;lose weight by&#160;burning off excess body fat, aim to&#160;eat 500 fewer calories per day than your
												daily caloric needs, and maintain or&#160;increase your exercise activity.</p>
											<p> The generally accepted rate of&#160;weight loss is&#160;1 to&#160;1.5 pounds per week or&#160;approximately 6 pounds per month. If&#160;you eliminate
												500 kcal per day from your diet (or&#160;approximately 3500 kcal/week), you should be&#160;on&#160;track to&#160;meet this degree of&#160;weight loss.
												Note: there is&#160;approximately 3500 calories per one pound of&#160;fat (0.45 kg).</p>
											<p><strong>Warning!</strong></p>
											<p>Do&#160;not go&#160;below 1200 calories per day unless you are on&#160;a&#160;medically supervised weight loss program or&#160;after
												consultation with your doctor!</p>
										</div>

										<!-- results block -->
										<div data-ng-show="result.success">
											<p><strong>So, if&#160;you want to&#160;save your weight:</strong></p>
											<p> Your individual&#8217;s recommendation to&#160;maintain current weight is&#160;<strong>{{result.saveWeight}}</strong>&#160;kilocalories per day.</p>
											<p><strong>And if&#160;you want to&#160;loss weight: </strong></p>
											<div data-ng-show="!result.lossWeightAllowed">
												<p>It&#160;seems bad for you to&#160;lose weight. Please consult your doctor.</p>
											</div>
											<div data-ng-show="result.lossWeightAllowed">
												<p>After subtracting 500 calories your new target (kilocalories/day) would be&#160;<strong>{{result.lossWeight}}</strong>, which should result
													in&#160;roughly one-pound of&#160;weight loss per week.</p>
											</div>
										</div>
								</div>
							</div>
						</uib-tab>

						<!-- about tab -->
						<uib-tab heading="About">
							<div>
								<h3>Harris-Benedict equation</h3>
								<p>The <b>Harris-Benedict equation</b> (also called the <b>Harris-Benedict principle</b>) is&#160;a&#160;method used to&#160;estimate an&#160;individual&#8217;s
									basal metabolic rat (BMR) and daily kilocalorie requirements. The estimated BMR value is&#160;multiplied by&#160;a&#160;number that corresponds to&#160;the
									individual&#8217;s activity level. The resulting number is&#160;the recommended daily kilocalorie intake to&#160;maintain current body weight.</p>
								<p>The Harris-Benedict equation may be&#160;used to&#160;assist weight loss&#160;&#8212; by&#160;reducing kilocalorie intake number below the estimated maintenance
									intake of&#160;the equation.</p>
								<p>
									<a class="btn btn-primary btn-large" href="https://en.wikipedia.org/wiki/Harris%E2%80%93Benedict_equation" target="_blank">Learn more</a>
								</p>
							</div>
						</uib-tab>
					</uib-tabset>
				</div>
			</div>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-animate.js"></script>
		<script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-1.0.0.js"></script>
		<script src="/hireright/calc.js"></script>
	</body>
</html>
