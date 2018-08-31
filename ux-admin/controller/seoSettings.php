<?php
if(isset($_POST['AddSetting'])){
	if(empty($_POST['code_value']) && empty($_FILES['usr_file']['name'])){
		$msg = "Fill any one or all fields";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}else{
		$array = array(
				'type'		=>	$_POST['type'],
				'date_time' => date('Y-m-d H:i:s')
		);
		
		if(!empty($_POST['code_value'])){
			$array['content'] = $_POST['code_value'];
		}
		
		if(!empty($_FILES["usr_file"]["name"])){
			$target_dir = doc_root;
			$target_file = $target_dir . basename($_FILES["usr_file"]["name"]);
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if $uploadOk is set to 0 by an error
			if($imageFileType != "txt" && $imageFileType != "html") {
				$msg = "Sorry, only txt or html file are allowed.";
			}else{
				if ($_FILES["usr_file"]["size"] > 100000) {
					$msg = "Sorry, your file is too large.";
				}else{
					if (file_exists($target_file)) {
						$msg = "Sorry, file named '". basename($_FILES["usr_file"]["name"]) ."' already exists";
					}else{
						if (move_uploaded_file($_FILES["usr_file"]["tmp_name"], $target_file)) {
							$array['code_file'] = basename($_FILES["usr_file"]["name"]);
						} else {
							$msg = "Sorry, there was an error uploading your file.";
						}
					}
				}
			}
		}
		if(empty($msg)){
			$result = $functionsObj->InsertData('GAME_SEOSETTINGS', $array, 0, 0);
			if($result){
				$_SESSION['msg'] = "Uploaded Sucessfully.";
				$_SESSION['type[0]'] = "inputSuccess";
				$_SESSION['type[1]'] = "has-success";
				header("Location:".site_root."ux-admin/SeoSettings");
			}
		}else{
			$msg = $msg;
			$type[0] = "inputError";
			$type[1] = "has-error";
		}
	}
}


$fields = array();
$where = array("id not IN (1,2,3)");
$res = $functionsObj->SelectData($fields, 'GAME_SEOSETTINGS', $where, '', '', '', '', 0);

$res1 = $functionsObj->SelectData($fields, 'GAME_SEOSETTINGS', array(), 'id', '3', '', '', 0);
$i = 0;
while($row = $res1->fetch_assoc()){
	$array[$i] = $row;
	$i++;
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Update'){
	$sql = "INSERT INTO 'GAME_SEOSETTINGS' (id, content) VALUES (1, '".$_POST['title']."'), (2, '".$_POST['keyword']."'), (3, '".$_POST['description']."')
			ON DUPLICATE KEY UPDATE id=VALUES(id),
			content=VALUES(content)";
	$result = $functionsObj->ExecuteQuery($sql);
	$_SESSION['msg'] = "Successfully Updated";
	$_SESSION['type[0]'] = "inputSuccess";
	$_SESSION['type[1]'] = "has-success";
	header("Location:".site_root."ux-admin/SeoSettings");
}
if(isset($_GET['delete'])){
	$id = base64_decode($_GET['delete']);
	$fields = array();
	$where	= array('id='.$id);
	$object = $functionsObj->SelectData($fields, 'GAME_SEOSETTINGS', $where, '', '', '', '', 0);
	$iffile = $functionsObj->FetchData($object);
	if(!empty($iffile['code_file'])){
		unlink(doc_root.$iffile['code_file']);
	}
	$result = $functionsObj->DeleteData('GAME_SEOSETTINGS', 'id', $id, 0);
	$_SESSION['msg'] = "Successfully Deleted";
	$_SESSION['type[0]'] = "inputSuccess";
	$_SESSION['type[1]'] = "has-success";
	header("Location:".site_root."/ux-admin/index.php?q=SeoSettings");
}
if(isset($_GET['addNewSetting'])){
	include_once doc_root.'ux-admin/view/seosettings/addNewSEOSetting.php';
}else{
	include_once doc_root.'ux-admin/view/seosettings/seoSettings.php';
}
?>