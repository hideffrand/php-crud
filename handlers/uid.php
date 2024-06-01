<!-- 
Proyek UAS Lab - PW IBDA2012
Deffrand Farera
222201312
-->

<?php

function create_uid($length = 5)
{
  $data = random_bytes($length);
  $hex = bin2hex($data);
  return substr($hex, 0, $length);
}
