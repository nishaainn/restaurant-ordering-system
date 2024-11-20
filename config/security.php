<?php

if (!isset($_SESSION['loggedin'])) {
   session_destroy();
   header("Location : ../admins/index.php");
   exit();
}

$user = $_SESSION['username'];

?>