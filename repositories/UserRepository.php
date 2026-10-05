<?php

class UserRepository {
    public static function getUSerById($id){
        $db = DB::connect();
        $query = "SELECT * FROM users WHERE id = $id";
        $user = $db->query($query);
        return $user;
    }
}

?>