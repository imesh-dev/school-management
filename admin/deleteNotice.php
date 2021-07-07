<?php
require_once "includes/header.php"; 
if(isset($_GET['action']) && $_GET['action'] == "delete_notice") {

	$notice_id = $_GET['n_id'];

	$query = "DELETE FROM notice WHERE id=$notice_id";
	$result = mysqli_query($conn,  $query);

	if($result) {
		header("Location: allNotices.php");
	}
}