<?php
require_once "includes/header.php"; 

if(isset($_POST['class_time']) && isset($_POST['teacher_email'])) {
	$class_time = $_POST['class_time'];
	$teacher_email = $_POST['teacher_email'];

	$week_days = ["Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday"];
	$booked_days =  [];
	$booked_days_encoded = "";

	$query = "SELECT class_days FROM class_teacher WHERE teacher_email='$teacher_email' AND class_time='$class_time'";
	$result = mysqli_query($conn, $query);  
	while ($row = mysqli_fetch_assoc($result)) {
		$booked_days_encoded = $row['class_days'];

		$booked_days_decoded = json_decode($booked_days_encoded);

		$booked_days = array_merge($booked_days, $booked_days_decoded);
	}

	$available_days = [];
	$avaialble_days = array_diff($week_days, $booked_days);

	if(!empty($avaialble_days)) {
		foreach ($avaialble_days as $key => $value) { ?>
		<input type="checkbox" id="<?php echo strtolower($value); ?>" name="week_days[]" value="<?php echo $value?>">
		<label for="<?php echo strtolower($value); ?>" class="switch"><?php echo $value; ?></label>
		<br>
<?php		
		}
	} else {
		return false;
	}
}