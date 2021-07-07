<?php

require_once "includes/header.php"; 

if(isset($_POST['classs']) && isset($_POST['datess'])) {

	$dates = $_POST['datess'];
	$global_name_id = $_POST['classs'];

	$query = "SELECT * FROM attendance WHERE dates='$dates' AND global_name_id=$global_name_id";

	$result = mysqli_query($conn, $query);

	if(mysqli_num_rows($result) > 0) {
		$taken = true;
	} else {
		$taken = false;
	}
	echo $taken;
}