<?php
ob_start();
session_start();
include ("../_init.php");
$user->logout();
if (!is_loggedin()) {
  redirect(root_url());
}