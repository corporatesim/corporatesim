<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
//require_once doc_root.'includes/PHPExcel/Writer/Excel2007.php';
//require('../../includes/PHPExcel.php');

$functionsObj = new Model();

// $object   = $functionsObj->SelectData(array(), 'GAME_SITESETTINGS', array('id=1'), '', '', '', '', 0);
// $sitename = $functionsObj->FetchObject($object);
$file          = 'UserReport.php';
$header        = 'User Report';
// adding this variable to enable date range for end date
$enableEndDate = 'enableEndDate';

// selcting all games for dropdown
$object   = $functionsObj->SelectData(array('Game_ID','Game_Name'), 'GAME_GAME', array('Game_Delete=0'), 'Game_Name', '', '', '', 0);
if($object->num_rows > 0)
{
	while($gameDetails = mysqli_fetch_object($object))
	{
		$gameName[] = $gameDetails;
	}
	// echo "<pre>"; print_r($gameName); exit;
}

// selcting all scenario linked with the games for dropdown
$object   = $functionsObj->SelectData(array('Game_ID','Game_Name'), 'GAME_GAME', array('Game_Delete=0'), '', '', '', '', 0);
if($object->num_rows > 0)
{
	while($gameDetails = mysqli_fetch_object($object))
	{
		$gameScenario[] = $gameDetails;
	}
	// echo "<pre>"; print_r($gameName); exit;
}

if(isset($_POST['downloadReport']) && $_POST['downloadReport'] == 'DownloadUserReport')
{
	// echo "<pre>";	print_r($_POST);	echo "<br> $EndDate";
	$gamename        = $_POST['gamename'];
	$scenarioname    = $_POST['scenarioname'];
	$gameId          = $_POST['game_game'];
	$scenarioId      = $_POST['game_scenario'];
	$StartDate       = $_POST['StartDate'];
	$EndDate         = $_POST['EndDate'];
	$add_user_filter = $_POST['user_filter'];
	$linkid          = $_POST['linkid'];
	$user_id         = $_POST['user_id'];

	if(empty($EndDate))
	{
		$EndDate = date('Y-m-d H:i:s');
	}

	$sql = "SELECT * FROM GAME_SITE_USER_REPORT_NEW WHERE linkid=".$linkid." AND (date_time BETWEEN '".$StartDate."' AND '".$EndDate."')";


	if($add_user_filter == 'select_users' )
	{

		if(count($user_id) > 0)
		{
			$user_id = implode(',',$user_id);
			// echo "apply filter";
			$sql .= " AND uid IN ($user_id)  ";
		}

	}

	// $dateStr for date filter (date_time BETWEEN '2010-01-30 14:15:55' AND '2010-09-29 10:15:55')
	$sql .= " order by id desc";

	//die($sql);

	$objPHPExcel = new PHPExcel;
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter   = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
	ob_end_clean();
	$currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';
	$numberFormat   = '#,#0.##;[Red]-#,#0.##';	
	$objSheet       = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Linkage');
	$objSheet->getStyle('A2:L2')->getFont()->setBold(true)->setSize(12);

	$objSheet->getCell('A1')->setValue($gamename);
	$objSheet->getCell('D1')->setValue($scenarioname);
	$objSheet->getStyle('A1:L1')->getFont()->setBold(true)->setSize(16);
	
	$objSheet->getCell('A2')->setValue('Sr. No.');
	$objSheet->getCell('B2')->setValue('Name of User');

	$sqlComp = "SELECT ls.SubLink_ID, CONCAT(c.Comp_Name, '/', COALESCE(s.SubComp_Name,'')) AS Comp_Subcomp 
	FROM `GAME_LINKAGE_SUB` ls 
	LEFT OUTER JOIN GAME_SUBCOMPONENT s ON SubLink_SubCompID=s.SubComp_ID
	LEFT OUTER JOIN GAME_COMPONENT c on SubLink_CompID=c.Comp_ID
	WHERE SubLink_LinkID=".$linkid ." 
	ORDER BY SubLink_ID";
	
	$objcomp = $functionsObj->ExecuteQuery($sqlComp);	
	$letter  = "C";
	
	if($objcomp->num_rows > 0){
		while($rowcomp = $objcomp->fetch_object()){			
			$s     = $letter . '2';
			$first = $letter . '1';

			$objSheet->setCellValue($s, strip_tags($rowcomp->Comp_Subcomp));
			$objSheet->getColumnDimension($s)->setWidth(20);	

			$letter++;
		}
	}
	
	$objSheet->getStyle('A2:'.$letter.'2')->getFont()->setBold(true)->setSize(12);

	// $sql = "SELECT * FROM GAME_SITE_USER_REPORT_NEW WHERE linkid=".$linkid." $dateStr  order by id desc";
	// die($sql);
	$objlink = $functionsObj->ExecuteQuery($sql);
	if($objlink->num_rows > 0){
		$i=3;
		while($row = $objlink->fetch_object()){
			$objSheet->getCell('A'.$i)->setValue($i-2);
			$objSheet->getCell('B'.$i)->setValue($row->user_name);

			$userdata = json_decode($row->user_data, true);
			$letter   = "C";
			foreach($userdata as $keydata=>$valdata){
				$s = $letter . $i;
				$objSheet->setCellValue($s, $valdata);
				$objSheet->getColumnDimension($letter)->setAutoSize(true);
				$letter++;
			}
			$i++;
		}
	}
	
	$objSheet->getColumnDimension('A')->setAutoSize(true);
	$objSheet->getColumnDimension('B')->setAutoSize(true);
	
	//exit();
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="UserDataNew.xlsx"');
	header('Cache-Control: max-age=0');
	$objWriter->save('php://output');

}

include_once doc_root.'ux-admin/view/'.$file;