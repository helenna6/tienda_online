<?php
    class UserRepository {
        public static function getUserById($id) {
            $db = DB::connect();
            $id = intval($id);
            $query = "SELECT * FROM users WHERE id = " . $id;
            $result = $db->query($query);
            
            if ($result && $user = $result->fetch_assoc()) {
                $userId = $user['id'] ?? ($user['user_id'] ?? $id);
                $username = $user['username'] ?? ($user['name'] ?? '');
                $rol = $user['rol'] ?? 0;
                return new User($userId, $username, $rol);
            } else {
                return null;
            }
        }
    }
?>