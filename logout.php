<?php
session_start();
require_once 'classes/functions.php';
func::deleteCookies();

header('location:login.php');


