<?php

if(isset($_POST['login'])){
    if(isset($_POST['username']) && isset($_POST['password'])){
        $q = "SELECT * FROM users WHERE username = '".$_POST['username']."'";
        $db = DB::connect();
        $result = $db->query($q);
        if($result && $row = $result->fetch_assoc()){
            if($row['password'] == md5($_POST['password'])){
                $_SESSION['user'] = new User(
                    $row['id'] ?? ($row['user_id'] ?? 0),
                    $row['username'],
                    $row['password'] ?? '',
                    $row['email'] ?? '',
                    $row['role'] ?? 'user'
                );
            }
        }
    }
    header("Location: index.php");
    exit;
}
?>