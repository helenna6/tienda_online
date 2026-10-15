<?php
    class UserRepository {
        public static function getUserById($id) {
            $db = DB::connect();
            $id = intval($id);
            $query = "SELECT * FROM USERS WHERE user_id = " . $id;
            $result = $db->query($query);
            if ($result && $user = $result->fetch_assoc()) {
                $userId = $user['user_id'];
                $username = $user['name'];
                $rol = $user['rol'] ?? 'user';
                return new User($userId, $username, $rol);
            } else {
                return null;
            }
        }
        public static function getAllUsers() {
            $db = DB::connect();
            $query = "SELECT * FROM USERS";
            $result = $db->query($query);
            $users = [];
            if ($result) {
                while ($user = $result->fetch_assoc()) {
                    $users[] = new User($user['user_id'],$user['name'],$user['rol'] ?? 'user');
                }
            }
            return $users;
        }
    }
?>