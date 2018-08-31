<?php
include_once '../../../config/settings.php';
include_once doc_root.'config/functions.php';

$funObj = new Functions();

if( isset( $_POST['formula'] ) && isset( $_POST['formula_string'] ) ){
	
	if(!empty($_POST['formula_id'])){
		
		$strresult ='';
		$prev = '';
		$str = explode(" ",$_POST['formula']);
		
		foreach($str as $value)
		{			
			$value =  trim($value);
			if(!is_numeric($prev)) 
			{
				if(trim($prev)!=".")
				{
					$strresult .= ' ';
				}
			}
			elseif(!is_numeric($value)){
				if(trim($value)!=".")
				{
					$strresult .= ' ';
				}
			}
			$streval .= "Value : ".$value.", Prev: ".$prev." strresult: ".$strresult."<\br>";
			$strresult .=  $value;
			$prev = $value;
		}
		
		$array = array(
			"formula_title"		=>	$_POST['formula_title'],
			"expression_string"	=>	$_POST['formula_string'],
			"expression"			=>	$strresult
			//$_POST['formula']
			//str_replace(' ', '', $_POST['formula'])
		);
		
		$result = $funObj->UpdateData(formulas, $array, 'f_id', $_POST['formula_id'], 0);
		if($result === true){
			$_SESSION['msg'] = "Formula updated successfully";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			$msg = array(
				"status"	=>	1,
				"msg"		=>	$streval
			);
			
		}else{
			$msg = array(
				"status"	=>	0,
				"msg"		=>	"Error while updating formula"
			);
		}
		
	}
	else{
		
		$strresult ='';
		$prev = '';
		$str = explode(" ",$_POST['formula']);
		
		foreach($str as $value)
		{
			$value =  trim($value);
			if(!is_numeric($prev)) 
			{
				if(trim($prev)!=".")
				{
					$strresult .= ' ';
				}
				
			}
			elseif(!is_numeric($value)){
				if(trim($value)!=".")
				{
					$strresult .= ' ';
				}				
			}
			$strresult .=  $value;
			$prev = $value;
		}
		
		$array = array(
			"formula_title"		=>	$_POST['formula_title'],
			"expression_string"	=>	$_POST['formula_string'],
			"expression"			=>	$strresult,
			//$_POST['formula'],
			//str_replace(' ', '', $_POST['formula']),
			"status"					=>	1,
			"date_time"				=>	date("Y-m-d H:i:s")
		);

		$result = $funObj->InsertData(formulas, $array, 0, 0);
		if( $result ){
			$_SESSION['msg'] = "Formula Added";
			$_SESSION['type[0]']	=	'inputSuccess';
			$_SESSION['type[1]']	=	'has-success';
			
			$msg = array(
				"status"	=>	1,
				"msg"		=> $strresult 
			);
		} else {
			$msg = array(
				"status"	=>	0,
				"msg"		=>	"Error while adding formula"
			);
		}
	}
	echo json_encode( $msg );
}