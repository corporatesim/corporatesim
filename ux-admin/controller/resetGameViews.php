<?php

require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

$gameid = $_GET['gameid'];
if(empty($gameid))
{
	die('<span class="alert-danger">gameid is not provided.</span>');
}
else
{
	// ExecuteQuery Game_ID Game_Delete
	$gameData = $functionsObj->RunQueryFetchObject("SELECT * FROM GAME_GAME WHERE Game_Delete=0 AND Game_ID=".$gameid);
	// echo "<pre>"; print_r($gameData);
	if(count($gameData) > 0)
	{
		$delete   = $functionsObj->ExecuteQuery("DELETE FROM GAME_VIEWS WHERE views_Game_ID=".$gameid);
		$insert   = $functionsObj->ExecuteQuery("INSERT INTO GAME_VIEWS( `views_Game_ID`, `views_sublinkid`, `views_key` ) SELECT '".$gameid."' AS views_Game_ID, gls.SubLink_ID AS views_sublinkid, IF( gv.views_id IS NULL, CONCAT( gls.SubLink_AreaName, '_', IF( gls.SubLink_SubCompID, CONCAT('subc', '_', gls.SubLink_SubCompID), CONCAT('comp', '_', gls.SubLink_CompID) ) ), 'not insert' ) AS views_key FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_VIEWS gv ON gv.views_sublinkid = gls.SubLink_ID AND gv.views_Game_ID = ".$gameid." WHERE gls.SubLink_LinkID IN( SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = ".$gameid." ) AND gv.views_id IS NULL ORDER BY `gv`.`views_sublinkid`, gls.SubLink_LinkID, gls.SubLink_SubCompID ASC");
		if($insert)
		{
			die('<span class="alert-success"><b>'.$gameData[0]->Game_Name.'</b> views data has been reset successfully. Please replay and check.</span>');
		}
		else
		{
			die('<span class="alert-danger">Connection Error. Please try later.</span>');
		}
	}
	else
	{
		die('<span class="alert-danger">Game does not exist or deleted. Please contact admin.</span>');
	}
}

?>