<?php
session_start();
$acc = $_GET['acc'];
echo $acc;
if(isset($_SESSION['$acc']) && $_SESSION['$acc'] == true) {
    unset($_SESSION['$acc']);
}
?>