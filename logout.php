<?php
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	include "leaveQueue.php";
	session_destroy();
	header("location:index");
?>