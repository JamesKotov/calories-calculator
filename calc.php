<?php
// simple backend part for ajax calculation

require('./config.php');

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
	$bIsGenderCorrect = in_array($oData->gender, $oConfig->aAllowedGenders);
	$bIsWeightCorrect = $oData->weight >= $oConfig->iMinWeight && $oData->weight <= $oConfig->iMaxWeight;
	$bIsHeightCorrect = $oData->height >= $oConfig->iMinHeight && $oData->height <= $oConfig->iMaxHeight;
	$bIsAgeCorrect = $oData->age >= $oConfig->iMinAge && $oData->age <= $oConfig->iMaxAge;
	$bIsExerciseCorrect = in_array($oData->exercise, array_keys($oConfig->aExerciseLevels));

	$bIsDataCorrect = ($bIsGenderCorrect && $bIsWeightCorrect && $bIsHeightCorrect && $bIsAgeCorrect && $bIsExerciseCorrect);

	$oResult->success = $bIsDataCorrect;

	if  ($bIsDataCorrect)
	{
		$iResult = 0;
		switch ($oData->gender) {
			case 'male': {
				$iResult = (88.362 + (13.397 * $oData->weight) + (4.799 * $oData->height) - (5.677 * $oData->age)) * $oConfig->aExerciseLevels[$oData->exercise];
				break;
			}
			case 'female': {
				$iResult = (447.593 + (9.247 * $oData->weight) + (3.098 * $oData->height) - (4.330 * $oData->age)) * $oConfig->aExerciseLevels[$oData->exercise];
				break;
			}
		}
		$oResult->saveWeight = $iResult >= $oConfig->iMinCaloriesPerDay ? intval($iResult) : $oConfig->iMinCaloriesPerDay;
		$oResult->lossWeight = intval($iResult - $oConfig->iLossyCorrection);
		$oResult->lossWeightAllowed = $oResult->lossWeight >= $oConfig->iMinCaloriesPerDay;
	}
}

// sending header and result
header('Content-Type: application/json');
echo json_encode($oResult);
exit();
