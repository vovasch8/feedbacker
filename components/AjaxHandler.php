<?php
session_start();

define('ROOT', substr(dirname(__FILE__), 0, -11));
require_once ROOT . "/components/Autoload.php";

$controller = new SiteController();

if($_GET['method'] == "loadResponse"){
    $sort = $_GET['sort'];
    $offset = $_GET['offset'];

    $controller->loadResponses($sort, $offset);
}

if($_GET['method'] == "editResponse"){
    $id = $_GET['id'];
    $message = $_GET['message'];
    $controller->editResponse($id, $message);
}

if($_GET['method'] == "deleteResponse"){
    $id = $_GET['id'];

    $controller->deleteResponse($id);
}

