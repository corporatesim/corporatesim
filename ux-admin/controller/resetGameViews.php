<?php

require_once doc_root . 'ux-admin/model/model.php';
$functionsObj = new Model();
function encode_decode_value($arg_value)
{
	if (base64_encode(base64_decode($arg_value, true)) === $arg_value) {
		if (ctype_alpha($arg_value) || is_numeric($arg_value)) {
			return $arg_value;
		} else {
			return base64_decode($arg_value);
		}
	} else {
		return $arg_value;
	}
}

function findDefaultValue($colVal)
{
	$colVal = json_decode($colVal, true);
	$defaultChecked = $colVal['makeDefaultChecked'];
	array_shift($colVal); // removing question
	foreach ($colVal as $option => $optionValue) {
		$decodedString = encode_decode_value($option);
		if ($decodedString == $defaultChecked) {
			// echo 'For <b>'.$option.'</b> the value text is: <b>'.encode_decode_value($option). '</b> and for default <b>'.$defaultChecked.'</b> With Value: <b>'.$optionValue.'</b><br>';
			// return $decodedString.' for '.$optionValue;
			return $optionValue;
		} else {
			return 'noupdate';
		}
	}
	// print_r($colVal);
}

// function updateDefaultValueForMultipleChoice()
// {
// 	// for updating the default values for user (multiple choice) type
// 	$linkSql = "SELECT gls.SubLink_ID, gls.SubLink_InputMode, gls.SubLink_InputModeType, gls.SubLink_InputModeTypeValue FROM GAME_LINKAGE_SUB gls WHERE gls.SubLink_LinkID IN (SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID=$gameid)";
// 	$subLinkage = $this->functionsObj->RunQueryFetchObject($linkSql);
// 	foreach ($subLinkage as $subLinkageRow) {
// 		if ($subLinkageRow->SubLink_InputMode == 'user' && $subLinkageRow->SubLink_InputModeType == 'mChoice')
// 			// $subLinks[$subLinkageRow->SubLink_ID] = $subLinkageRow->SubLink_InputModeTypeValue;
// 			$defaultValueByAdmin = findDefaultValue($subLinkageRow->SubLink_InputModeTypeValue);
// 		if ($defaultValueByAdmin != 'noupdate' && !empty($defaultValueByAdmin)) {
// 			$updateDefaultValueSql = "UPDATE GAME_VIEWS SET views_current=$defaultValueByAdmin WHERE views_sublinkid=$subLinkageRow->SubLink_ID";
// 			echo $updateDefaultValueSql."<br>";
// 			$updateDefaultValue = $this->functionsObj->ExecuteQuery($updateDefaultValueSql);
// 		}
// 	}
// 	// end of updating the default value by admin to views table
// }

$gameid = $_GET['gameid'];
if (empty($gameid)) {
	die('<span class="alert-danger">gameid is not provided.</span>');
} else {
	if ($gameid == 'all') {
		$subLinks = array();
		$msg = 'Data for <br>';
		$gameData = $functionsObj->RunQueryFetchObject("SELECT * FROM GAME_GAME WHERE Game_Delete=0");
		$gameCount = 0;
		foreach ($gameData as $gameDataRow) {
			$delete   = $functionsObj->ExecuteQuery("DELETE FROM GAME_VIEWS WHERE views_Game_ID=" . $gameDataRow->Game_ID);
			$insert   = $functionsObj->ExecuteQuery("INSERT INTO GAME_VIEWS( `views_Game_ID`, `views_sublinkid`, `views_key`, `views_current` ) SELECT '" . $gameDataRow->Game_ID . "' AS views_Game_ID, gls.SubLink_ID AS views_sublinkid, IF( gv.views_id IS NULL, CONCAT( gls.SubLink_AreaName, '_', IF( gls.SubLink_SubCompID, CONCAT('subc', '_', gls.SubLink_SubCompID), CONCAT('comp', '_', gls.SubLink_CompID) ) ), 'not insert' ) AS views_key, IF(gls.SubLink_InputMode = 'admin', gls.SubLink_AdminCurrent,0) AS views_current FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_VIEWS gv ON gv.views_sublinkid = gls.SubLink_ID AND gv.views_Game_ID = " . $gameDataRow->Game_ID . " WHERE gls.SubLink_LinkID IN( SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = " . $gameDataRow->Game_ID . " ) AND gv.views_id IS NULL ORDER BY `gv`.`views_sublinkid`, gls.SubLink_LinkID, gls.SubLink_SubCompID ASC");
			$msg .= '<b>' . $gameDataRow->Game_Name . '</b>, ';
			$gameCount++;

			// for updating the default values for user (multiple choice) type
			$linkSql = "SELECT gls.SubLink_ID, gls.SubLink_InputMode, gls.SubLink_InputModeType, gls.SubLink_InputModeTypeValue FROM GAME_LINKAGE_SUB gls WHERE gls.SubLink_LinkID IN (SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID=$gameDataRow->Game_ID)";
			$subLinkage = $functionsObj->RunQueryFetchObject($linkSql);
			foreach ($subLinkage as $subLinkageRow) {
				if ($subLinkageRow->SubLink_InputMode == 'user' && $subLinkageRow->SubLink_InputModeType == 'mChoice')
					// $subLinks[$subLinkageRow->SubLink_ID] = $subLinkageRow->SubLink_InputModeTypeValue;
					$defaultValueByAdmin = findDefaultValue($subLinkageRow->SubLink_InputModeTypeValue);
				if ($defaultValueByAdmin != 'noupdate' && !empty($defaultValueByAdmin)) {
					$updateDefaultValueSql = "UPDATE GAME_VIEWS SET views_current=$defaultValueByAdmin WHERE views_sublinkid=$subLinkageRow->SubLink_ID";
					// echo $updateDefaultValueSql . "<br>";
					$updateDefaultValue = $functionsObj->ExecuteQuery($updateDefaultValueSql);
				}
			}
			// end of updating the default value by admin to views table
		}
		die('<span class="alert-success">' . trim($msg, ", ") . '<br> (' . $gameCount . ')views data has been reset successfully. Please replay and check.</span>');
	} else {
		// ExecuteQuery Game_ID Game_Delete
		$gameData = $functionsObj->RunQueryFetchObject("SELECT * FROM GAME_GAME WHERE Game_Delete=0 AND Game_ID=" . $gameid);
		// echo "<pre>"; print_r($gameData);
		if (count($gameData) > 0) {
			$delete   = $functionsObj->ExecuteQuery("DELETE FROM GAME_VIEWS WHERE views_Game_ID=" . $gameid);
			$insert   = $functionsObj->ExecuteQuery("INSERT INTO GAME_VIEWS( `views_Game_ID`, `views_sublinkid`, `views_key`, `views_current` ) SELECT '" . $gameid . "' AS views_Game_ID, gls.SubLink_ID AS views_sublinkid, IF( gv.views_id IS NULL, CONCAT( gls.SubLink_AreaName, '_', IF( gls.SubLink_SubCompID, CONCAT('subc', '_', gls.SubLink_SubCompID), CONCAT('comp', '_', gls.SubLink_CompID) ) ), 'not insert' ) AS views_key, IF(gls.SubLink_InputMode = 'admin', gls.SubLink_AdminCurrent,0) AS views_current FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_VIEWS gv ON gv.views_sublinkid = gls.SubLink_ID AND gv.views_Game_ID = " . $gameid . " WHERE gls.SubLink_LinkID IN( SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = " . $gameid . " ) AND gv.views_id IS NULL ORDER BY `gv`.`views_sublinkid`, gls.SubLink_LinkID, gls.SubLink_SubCompID ASC");
			// for updating the default values for user (multiple choice) type
			$linkSql = "SELECT gls.SubLink_ID, gls.SubLink_InputMode, gls.SubLink_InputModeType, gls.SubLink_InputModeTypeValue FROM GAME_LINKAGE_SUB gls WHERE gls.SubLink_LinkID IN (SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID=$gameid)";
			$subLinkage = $functionsObj->RunQueryFetchObject($linkSql);
			foreach ($subLinkage as $subLinkageRow) {
				if ($subLinkageRow->SubLink_InputMode == 'user' && $subLinkageRow->SubLink_InputModeType == 'mChoice')
					// $subLinks[$subLinkageRow->SubLink_ID] = $subLinkageRow->SubLink_InputModeTypeValue;
					$defaultValueByAdmin = findDefaultValue($subLinkageRow->SubLink_InputModeTypeValue);
				if ($defaultValueByAdmin != 'noupdate' && !empty($defaultValueByAdmin)) {
					$updateDefaultValueSql = "UPDATE GAME_VIEWS SET views_current=$defaultValueByAdmin WHERE views_sublinkid=$subLinkageRow->SubLink_ID";
					echo $updateDefaultValueSql."<br>";
					$updateDefaultValue = $functionsObj->ExecuteQuery($updateDefaultValueSql);
				}
			}
			// end of updating the default value by admin to views table
			if ($insert) {
				die('<span class="alert-success"><b>' . $gameData[0]->Game_Name . '</b> views data has been reset successfully. Please replay and check.</span>');
			} else {
				die('<span class="alert-danger">Connection Error. Please try later.</span>');
			}
		} else {
			die('<span class="alert-danger">Game does not exist or deleted. Please contact admin.</span>');
		}
	}
}
