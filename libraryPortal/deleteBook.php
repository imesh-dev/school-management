<?php
require_once "includes/header.php"; 
if(isset($_GET['action']) && $_GET['action'] == "delete_book") {

	$b_id = $_GET['t_id'];


	//delete book info
	$query = "DELETE FROM books WHERE id=$b_id";
	$result = mysqli_query($conn,  $query);

	if($result) {
		header("Location: BookList.php");
	}
}