<?php
    if(isset($_POST['login'])){
        if(isset($_POST['username']) && isset($_POST['password'])){
            $q = "select * from user where username='".$_POST['username']."'";
            $db=DB->connect();
            $result = $db->query($q);
            $stmt->execute();
            if($row=$result->fetch_assoc()){
                if($row['password']==md5($_POST['password'])){
                    $_SESSION['user'] =new User($row['user_id'],$row['username'],$row['password']);
                }
            }
            
        }
        header('index.php');
        exit;
    }