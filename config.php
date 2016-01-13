<?php

// config

$oConfig = new StdClass();

// number of kilocalories to substract for loss weight
$oConfig->iLossyCorrection = 500;

// minimal calories per day
$oConfig->iMinCaloriesPerDay = 1200;

// validation params
$oConfig->aAllowedGenders = array('male', 'female');
$oConfig->iMinWeight = 1;
$oConfig->iMaxWeight = 727; // max real human weight ever in world history
$oConfig->iMinHeight = 50; // min real human height ever in history
$oConfig->iMaxHeight = 246; // max real human height ever in history
$oConfig->iMinAge = 1;
$oConfig->iMaxAge = 122; // max real human age ever in history

// params for exercise amount
$oConfig->aExerciseLevels = array(
	1 => 1.2,
	2 => 1.375,
	3 => 1.55,
	4 => 1.725,
	5 => 1.9,
);
