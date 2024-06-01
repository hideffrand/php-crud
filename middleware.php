<!-- 
Proyek UAS Lab - PW IBDA2012
Deffrand Farera
222201312
-->

<?php
session_start();
if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}
