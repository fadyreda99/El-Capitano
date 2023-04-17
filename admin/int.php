<?php
include ('connect.php');
//directories
$tpl = 'includes/templates/'; //templates directory
$css = 'layout/css/'; //css directory
$js = 'layout/js/'; //js directory
$language = 'includes/languages/'; //languages directory
$func = 'includes/functions/'; //functions directory



include $func . ('functions.php');
include $func . ('model.php');

//include $language . ('eng.php');
include $tpl . ('header.php');



if(!isset($noNavbar)){include $tpl . "navbar.php";}

