<?php

if(isset($_GET['logout'])){
    session_destroy();
    header('location:index.php');
    exit;
}
if(isset($_POST['login'])){
    if(isset($_POST['name']) && isset($_POST['password'])){
        $q = "SELECT * FROM USERS WHERE name='".$_POST['name']."'";
        $db = DB::connect();
        $result = $db->query($q);
        if($row = $result->fetch_assoc()){
            if($row['password'] == md5($_POST['password'])){
                $_SESSION['user'] = new User($row['user_id'],$row['name']);
                header('location:index.php');
                exit;
            }
        }
    }
    header('location:index.php?login');
    exit;
}
if(isset($_POST['register'])){
    if(isset($_POST['name']) && isset($_POST['password'])){
        $q = "INSERT INTO USERS (name, email, phone, password) VALUES ('".$_POST['name']."','"
        .$_POST['name']."@gmail.com','', md5('".$_POST['password']."'))";
        $db = DB::connect();
        $db->query($q);
        if($db->insert_id){
            header('location:index.php?login');
            exit;
        }
    }
    header('location:index.php?register');
    exit;
}
?>