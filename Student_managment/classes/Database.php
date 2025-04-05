
<?php
class Database {
    public static function connect() {
        // Paramètres de connexion à la base de données
        $host = 'localhost';
        $db = 'student_management';
        $user = 'root';
        $pass = 'amiLAra123';
        
        try {
            return new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}
