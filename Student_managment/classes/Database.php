<?php
class Database {
    public static function connect() {
        // Paramètres de connexion à la base de données
        $host = 'localhost';
        $db = 'student_managment1g';
        $user = 'root';
        $pass = 'amiLAra123';
        
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    public static function createTables() {
        $pdo = self::connect();
    
        try {
            // Check if the 'users' table exists
            $result = $pdo->query("SHOW TABLES LIKE 'users'");
            if ($result->rowCount() == 0) {
                // Create users table if it doesn't exist
                $pdo->exec("CREATE TABLE IF NOT EXISTS users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(255) NOT NULL UNIQUE,
                    email VARCHAR(255) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    role ENUM('admin', 'user') DEFAULT 'user'
                )");
            }
    
            // Check if the 'sections' table exists
            $result = $pdo->query("SHOW TABLES LIKE 'sections'");
            if ($result->rowCount() == 0) {
                // Create sections table if it doesn't exist
                $pdo->exec("CREATE TABLE IF NOT EXISTS sections (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    designation VARCHAR(255) NOT NULL,
                    description TEXT
                )");
            }
    
            // Check if the 'students' table exists
            $result = $pdo->query("SHOW TABLES LIKE 'students'");
            if ($result->rowCount() == 0) {
                // Create students table if it doesn't exist
                $pdo->exec("CREATE TABLE IF NOT EXISTS students (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    birthday DATE,
                    section VARCHAR(100),
                    image VARCHAR(1000) NOT NULL
                )");
            }
    
            return true;
        } catch (PDOException $e) {
            die("Table creation failed: " . $e->getMessage());
        }
    }
    
    
    public static function insertInitialData() {
        $pdo = self::connect();
    
        try {
            // Check if there are any users in the 'users' table
            $result = $pdo->query("SELECT COUNT(*) FROM users");
            $row = $result->fetch(PDO::FETCH_ASSOC);
            if ($row['COUNT(*)'] == 0) {
                // Insert initial users if no users exist
                $pdo->exec("INSERT INTO users (username, email, password, role) VALUES 
                    ('admin', 'admin@example.com', 'admin123', 'admin'),
                    ('user', 'user@example.com', 'user123', 'user')");
            }
    
            // Check if there are any sections in the 'sections' table
            $result = $pdo->query("SELECT COUNT(*) FROM sections");
            $row = $result->fetch(PDO::FETCH_ASSOC);
            if ($row['COUNT(*)'] == 0) {
                // Insert initial sections if no sections exist
                $pdo->exec("INSERT INTO sections (designation, description) VALUES
                    ('GL', 'Genie Logiciel'),
                    ('RT', 'Reseau et Teleecommunication')");
            }
    
            // Check if there are any students in the 'students' table
            $result = $pdo->query("SELECT COUNT(*) FROM students");
            $row = $result->fetch(PDO::FETCH_ASSOC);
            if ($row['COUNT(*)'] == 0) {
                // Insert initial students if no students exist
                $pdo->exec("INSERT INTO students (name, image, birthday, section) VALUES
                    ('Mohamed', 'https://scontent.cdninstagram.com/v/t51.2885-19/464260860_1339279210371330_3686701439434257025_n.jpg?stp=cp0_dst-jpg_s110x80_tt6&_nc_cat=109&ccb=1-7&_nc_sid=bf7eb4&_nc_ohc=hwjhAaEn_GEQ7kNvwEClLlJ&_nc_oc=AdmZ6wXoEgC1MHMAem0FWB4IX3OSN8YcJURWtGGmSNofBUufwPs7pItRnSHIAAHcuMYVdxqzo2fT9ojpmEEJaZKE&_nc_zt=24&_nc_ht=scontent.cdninstagram.com&oh=00_AYEQV2IqL_1A9FB0weCGF9DCo6WvnhY6l8iTGHFUYvNW7w&oe=67F70652','2004-09-06','GL'),
                    ('Amira', 'https://scontent.cdninstagram.com/v/t51.2885-19/453347193_810533611221828_2994440042122449472_n.jpg?stp=cp0_dst-jpg_s110x80_tt6&_nc_cat=110&ccb=1-7&_nc_sid=bf7eb4&_nc_ohc=MiCa3Z7I-_oQ7kNvwFo0KcQ&_nc_oc=AdnX2S5-KKrsunWlzubZJLulDyVgN7l9NHS641rFupvXO1trlpZuOMur9OX-VAlj35sEDa2x_qwuNUsRvm7zA9do&_nc_zt=24&_nc_ht=scontent.cdninstagram.com&oh=00_AYFC6jh2MMWO6yZGUYgMERHbyLKkYzMmaimDunDsKGcy1Q&oe=67F71C8C','2004-07-19','GL'),
                    ('Mariem', 'https://scontent.cdninstagram.com/v/t51.2885-19/419931114_7536801856332571_7009352721309489361_n.jpg?stp=cp0_dst-jpg_s110x80_tt6&_nc_cat=111&ccb=1-7&_nc_sid=bf7eb4&_nc_ohc=yIQ1LEsMM_AQ7kNvwH1lDO0&_nc_oc=AdksWPtalYvxVW80arGysKpHsZO3BJZ7jCp1CJnu325E-hwnUNpQpDbHGh3Dku5Wy6Nhc2aK2Q3lCqkGUHGCW6kz&_nc_zt=24&_nc_ht=scontent.cdninstagram.com&oh=00_AYGZKqJJplWpugwgHedgQxYmt3LAIf20VFo7yij1FemjPg&oe=67F6EFBD','2004-03-21','RT'),
                    ('Sadok', 'https://scontent.cdninstagram.com/v/t51.2885-19/73241007_397057977838092_4688093941889761280_n.jpg?stp=cp0_dst-jpg_s110x80_tt6&_nc_cat=105&ccb=1-7&_nc_sid=bf7eb4&_nc_ohc=N7o665cBl9QQ7kNvwEKa0mR&_nc_oc=AdlwoZwafBGP-zTmHmTIHncJqn69-ZjNIg6FEF3ZwdOSDvcq3QH4aSnz44lHFqjD6UHOKFdp8sys3Q7oTCPZJzc7&_nc_zt=24&_nc_ht=scontent.cdninstagram.com&oh=00_AYHSrjrBVI1aFHbrViesTbuxA7AdHbaOPrJuYlIpjWrBJQ&oe=67F719F3','2005-01-01','RT')
                ");
            }
    
            return true;
        } catch (PDOException $e) {
            die("Data insertion failed: " . $e->getMessage());
        }
    }
    
    
    public static function dropStudentsTable() {
        $pdo = self::connect();
        
        try {
            $pdo->exec("DROP TABLE IF EXISTS students");
            return true;
        } catch (PDOException $e) {
            die("Table drop failed: " . $e->getMessage());
        }
    }
}