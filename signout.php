<!-- 
Proyek UAS Lab - PW IBDA2012
Deffrand Farera
222201312
-->

<?php
session_start();
if (isset($_SESSION['email'])) {
  session_unset();
  session_destroy();
  header("Location: login.php");
  exit();
}
