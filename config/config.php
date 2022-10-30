<?php
if (PHP_SESSION_NONE === session_status()) {
    session_start();
}
error_reporting(E_ERROR | E_PARSE);
require_once("../config/base.php");
require_once("../controller/functions.php");
//gwadz
