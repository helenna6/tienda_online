<?php
    class UserRepository{
        public static function getUserById($id){
            $db=DB::connect();
            $query="SELECT * FROM USERS WHERE user_id=$id";
            $result=$db->query($query);
            if($user=$result->fetch_assoc()){
                return new User($user['user_id'], $user['name']);
            }else{
                return null;
            }
        }
    }
?>