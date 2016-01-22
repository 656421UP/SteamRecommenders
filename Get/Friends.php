<?php
	include '../php/steamhelpers.php';
	
	$steamid = $_GET["id"];
	echo getFriendsList($steamid);
?>