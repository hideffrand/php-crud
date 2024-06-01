<!-- 
Proyek UAS Lab - PW IBDA2012
Deffrand Farera
222201312
-->

<?php
include 'connection.php';
include '../middleware.php';

$rent_id = $_POST['rent_id'];
$email = $_SESSION['email'];

// Get user id
$q = $con->prepare("SELECT id FROM users WHERE email = ?");
$q->bind_param("s", $email);
$q->execute();
$user_id = $q->get_result()->fetch_assoc()['id'];
$q->close();

// Delete/cancel rent 
$q = $con->prepare("DELETE FROM rents WHERE id = ? AND user_id = ?");
$q->bind_param("ss", $rent_id, $user_id);
$res = $q->execute();
$q->close();

header("Location: ../profile.php");
exit();
