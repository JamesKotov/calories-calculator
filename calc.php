<?php
// simple backend part for ajax calculation

// config

// number of kilocalories to substract for loss weight
$iLossyCorrection = 500;

// minimal calories per day
$iMinCaloriesPerDay = 1200;

// validation params
$aAllowedGenders = array('male', 'female');
$iMinWeight = 1;
$iMaxWeight = 727;
$iMinHeight = 50;
$iMaxHeight = 246;
$iMinAge = 1;
$iMaxAge = 122;

// params for exercise amount
$aExerciseLevels = array(
	1 => 1.2,
	2 => 1.375,
	3 => 1.55,
	4 => 1.725,
	5 => 1.9,
);

$oResult = new StdClass();
$oResult->success = false;
$oResult->standard = 0;
$oResult->lossy = 0;

// getting form data
$aInputData = json_decode(trim(file_get_contents('php://input')), true);

if (is_array($aInputData))
{
	// conform input data
	$oData = new StdClass();
	$oData->gender = strtolower(strval($aInputData['gender']));
	$oData->weight = intval($aInputData['weight']);
	$oData->height = intval($aInputData['height']);
	$oData->age = intval($aInputData['age']);
	$oData->exercise = intval($aInputData['exercise']);

	// validating conformed values
	$bIsGenderCorrect = in_array($oData->gender, $aAllowedGenders);
	$bIsWeightCorrect = $oData->weight >= $iMinWeight && $oData->weight <= $iMaxWeight;
	$bIsHeightCorrect = $oData->height >= $iMinHeight && $oData->height <= $iMaxHeight;
	$bIsAgeCorrect = $oData->age >= $iMinAge && $oData->age <= $iMaxAge;
	$bIsExerciseCorrect = in_array($oData->exercise, array_keys($aExerciseLevels));

	$bIsDataCorrect = ($bIsGenderCorrect && $bIsWeightCorrect && $bIsHeightCorrect && $bIsAgeCorrect && $bIsExerciseCorrect);

	$oResult->success = $bIsDataCorrect;

	if  ($bIsDataCorrect)
	{
		$iResult = 0;
		switch ($oData->gender) {
			case 'male': {
				$iResult = (88.362 + (13.397 * $oData->weight) + (4.799 * $oData->height) - (5.677 * $oData->age)) * $aExerciseLevels[$oData->exercise];
				break;
			}
			case 'female': {
				$iResult = (447.593 + (9.247 * $oData->weight) + (3.098 * $oData->height) - (4.330 * $oData->age)) * $aExerciseLevels[$oData->exercise];
				break;
			}
		}
		$oResult->saveWeight = $iResult >= $iMinCaloriesPerDay ? intval($iResult) : $iMinCaloriesPerDay;
		$oResult->lossWeight = intval($iResult - $iLossyCorrection);
		$oResult->lossWeightAllowed = $oResult->lossWeight >= $iMinCaloriesPerDay;
	}
}

// sending header and result
header('Content-Type: application/json');
echo json_encode($oResult);
exit();
