<?php
include ('admin/connect.php');

$sessionUser=' ';
if(isset($_SESSION['userName'])){
    $sessionUser=$_SESSION['userName'];
}

//directories
$tpl = 'includes/templates/'; //templates directory
$css = 'layout/css/'; //css directory
$js = 'layout/js/'; //js directory
$language = 'includes/languages/'; //languages directory
$func = 'includes/functions/'; //functions directory



include $func . ('functions.php');
include $func . ('model.php');
include $tpl . ('header.php');






