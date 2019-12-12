<?php

require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

$notificationSql = "SELECT * FROM GAME_NOTIFICATION WHERE Notification_Delete=0 AND Notification_To=".$_SESSION['ux-admin-id']." ORDER BY Notification_CreatedOn DESC";
$notificationData = $functionsObj->RunQueryFetchObject($notificationSql);
// echo "<pre>"; print_r($notificationData); exit;

include_once doc_root.'ux-admin/view/notification.php';
?>