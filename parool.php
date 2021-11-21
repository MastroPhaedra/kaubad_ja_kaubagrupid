<?php
$parool=12346;
$sool='tavalinetext';
$krypt=crypt($parool, $sool);
echo $krypt;
?>