<?php
require_once "../includes/database.php";
if(isset($_POST['bid'])) {

	//$all_class_time = [];
	$borrower_id = $_POST['bid'];
	$query = "SELECT * FROM books WHERE book_name like '%".$borrower_id."%'";
	$result = mysqli_query($conn, $query);
	if(!$result) {
		die(mysqli_error($conn));
	}
	while ($row = mysqli_fetch_assoc($result)) {
		
			echo "<tr><td>".$row['book_name']."</td><td>".$row['isbn']."</td><td>".$row['category']."</td><td>".$row['author']."</td></tr>";
	}

}


if(isset($_POST['bname'])) {

	//$all_class_time = [];
	$borrower_name = $_POST['bname'];
	$query = "SELECT * FROM students WHERE student_name like '%".$borrower_name."%'";
	$result = mysqli_query($conn, $query);
	if(!$result) {
		die(mysqli_error($conn));
	}
	while ($row = mysqli_fetch_assoc($result)) {
		
			echo "<tr><td>".$row['id']."</td><td>".$row['student_name']."</td><td>".$row['student_class']."</td><td>".$row['student_section']."</td></tr>";
	}

}