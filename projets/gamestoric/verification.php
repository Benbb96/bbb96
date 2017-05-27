<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 12/05/2017
 * Time: 23:05
 */

session_start();

if (!isset($_SESSION['connected'])) {
    if (isset($_POST["password"]) && strcmp($_POST["password"], "rocket") == 0) {

        $_SESSION['connected'] = true;
    } else {
        $_SESSION['connected'] = false;
    }
} else {
    if (isset($_POST["password"]) && strcmp($_POST["password"], "rocket") == 0) {
        $_SESSION['connected'] = true;
    }
}

if (isset($_GET['deco'])) {
    $_SESSION['connected'] = false;
}