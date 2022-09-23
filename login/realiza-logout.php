<?php
ob_start();
session_start();

session_unset();     // unset $_SESSION  
session_destroy();   // destroindo session data 

header("Location: ../login");
?>
