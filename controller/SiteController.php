<?php

class SiteController
{
    public function runApplication(){

        $admin = "";

        if(isset($_SESSION['admin'])) {
            $admin = $_SESSION['admin'];
        }

        if(isset($_POST['logout'])){
            unset($_SESSION['admin']);
            $admin = "";
        }

        if(isset($_POST['auth'])){
            $login = $_POST['login'];
            $password = $_POST['password'];

            $admin_login = "admin";
            $admin_password = "123";

            if($login == $admin_login && $password == $admin_password){
                $_SESSION['admin'] = 'admin';
                $admin = $_SESSION['admin'];
            }
        }

        if(isset($_POST['submit'])){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];
            date_default_timezone_set("Europe/Kiev");
            $date = date("Y-m-d H:i:s");
            Response::addResponse($name, $email, $message, $date);
        }

        $responses = Response::getResponses();

        require_once (ROOT . '/view/feedback.php');
        return true;
    }

    public function loadResponses($sort, $offset){
        $admin = "";

        if(isset($_SESSION['admin'])) {
            $admin = $_SESSION['admin'];
        }

        $responses = Response::getResponses($sort, $offset);

        require_once (ROOT . "/view/template/responses.php");
        return true;
    }

    public function editResponse($id, $message){
        $admin = "";

        if(isset($_SESSION['admin'])) {
            $admin = $_SESSION['admin'];
        }

        Response::editResponse($id, $message);

        return true;
    }

    public function deleteResponse($id){
        $admin = "";

        if(isset($_SESSION['admin'])) {
            $admin = $_SESSION['admin'];
        }

        Response::deleteResponse($id);

        return true;
    }
}