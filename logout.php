<?php
session_start();
session_destroy();
header("Location: index.html"); // change to your login page
exit;
?>
