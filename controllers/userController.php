<?php
    if(isset($_GET['logout'])){
        session_destroy();
        header('location:index.php');
        exit;
    }
    if(isset($_POST['login'])){
        if(isset($_POST['username']) && isset($_POST['password'])){
            $db = DB::connect();
            $q = "SELECT * FROM users WHERE username = '".$_POST['username']."'";
            $result = $db->query($q);
            
            if($row = $result->fetch_assoc()){
                if($row['password'] == md5($_POST['password'])){
                    $userId = isset($row['id']) ? $row['id'] : (isset($row['user_id']) ? $row['user_id'] : null);
                    $userRol = isset($row['rol']) ? $row['rol'] : 0;
                    $userName = $row['username'];
                    
                    $_SESSION['user'] = new User($userId, $userName, $userRol);
                }
            }
        }
        header('location:index.php');
        exit;
    }
    if(isset($_POST['register'])){
        if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2'])
            && $_POST['password'] == $_POST['password2']){
                
                $db = DB::connect();

                $check = $db->query("SELECT * FROM users WHERE username = '".$_POST['username']."'");
                if($check->num_rows > 0){
                    header('location:index.php?register');
                    exit();
                }

                // Eliminamos el campo email que no existe en tu tabla
                $q = "INSERT INTO users (username, password) VALUES ('".$_POST['username']."', md5('".$_POST['password']."'))";
                $db->query($q);
                
                if($db->insert_id){
                    header('location:index.php?login');
                    exit();
                }
        }
    }
    header('location:index.php');
    exit();
?>