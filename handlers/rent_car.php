<!-- 
Proyek UAS Lab - PW IBDA2012
Deffrand Farera
222201312
-->

<?php
include 'connection.php';
include 'uid.php';
include '../middleware.php';

$new_uid = 'R-' . strtoupper(create_uid());
$email = $_SESSION['email'];
$car_id = $_POST['car_id'];

// Set start and finish dates
$start_date = new DateTime($_POST['start_date']);
$finish_date = new DateTime($_POST['finish_date']);

// Convert date to string for SQL
$start_date_str = $start_date->format('Y-m-d H:i:s');
$finish_date_str = $finish_date->format('Y-m-d H:i:s');

// Calculate the total cost
$interval = $start_date->diff($finish_date);
$total_days = $interval->days;
$total = $total_days * $_POST['price_per_day'];

// Get user id
$q = $con->prepare("SELECT id FROM users WHERE email = ?");
$q->bind_param("s", $email);
$q->execute();
$result = $q->get_result();

if ($result->num_rows == 0) {
  echo "<p style='color: red;'>User not found.</p>";
  $q->close();
  exit();
}

$user_id = $result->fetch_assoc()['id'];
$q->close();

// Insert new rent
$status = 'on-going';
$q = $con->prepare("INSERT INTO rents (id, car_id, user_id, start_date, finish_date, total_days, total, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$q->bind_param("sssssiis", $new_uid, $car_id, $user_id, $start_date_str, $finish_date_str, $total_days, $total, $status);
$res = $q->execute();
$q->close();

// Update car status
$status = 'Unvailable';
$q = $con->prepare("UPDATE cars SET status = ? WHERE id = ?");
$q->bind_param("ss", $status, $car_id);
$res = $q->execute();
$q->close();

if (!$res) {
  echo "<p style='color: red;'>Failed to create rent.</p>";
  exit();
}

header("Location: ../profile.php");
exit();
