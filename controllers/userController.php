<?php
    if(isset($_GET['logout'])){
        session_destroy();
        header('location:index.php');
        exit;
    }
    if(isset($_POST['login'])){
        if(isset($_POST['username']) && isset($_POST['password'])){
            $db = DB::connect();
            $username = $_POST['username'];
            $q = "SELECT * FROM USERS WHERE name = '".$username."'";
            $result = $db->query($q);
            if($row = $result->fetch_assoc()){
                if($row['password'] == md5($_POST['password'])){
                    $userId = $row['user_id'];
                    $userName = $row['name'];
                    $userRol = $row['rol'];
                    $_SESSION['user'] = new User($userId, $userName, $userRol);
                }
            }
        }
        header('location:index.php');
        exit;
    }
    if(isset($_POST['register'])){
        if(isset($_POST['username']) && isset($_POST['password'])
            && isset($_POST['password2'])
            && $_POST['password'] == $_POST['password2']){
            $db = DB::connect();
            $username = $_POST['username'];
            $password = $_POST['password'];
            $check = $db->query("SELECT * FROM USERS WHERE name = '".$username."'");
            if(strtolower(trim($username)) == 'admin'){
                header('location:index.php?register');
                exit;
            }
            $q = "INSERT INTO USERS (name, password, rol) VALUES ('".$username."', md5('".$password."'),
            'user')";
            $db->query($q);
            if($db->insert_id){
                header('location:index.php?login');
                exit;
            }
        }
    }
    header('location:index.php');
    exit;
?>