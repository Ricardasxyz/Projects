<?php
// sesijos pradzia
session_start();
 
// visus variable nuimam
$_SESSION = array();
 
// pabaiga
session_destroy();
 
// i logina page nukeliam
header("location: login.php");
exit;
