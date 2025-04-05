
<?php
require_once 'Repository.php';
class User {
    private $repository;

    public function __construct() {
        $this->repository = new Repository('users');  
    }

    
    public function createUser($username, $email, $password, $role = 'user') {
        $this->repository->create([
            'username' => $username,
            'email' => $email,
            'password' => $password, 
            'role' => $role
        ]);
    }
    

    public function login($username, $password) {
        $stmt = $this->repository->getPdo()->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        var_dump($user);  
    
        if ($user) {
           
            if ($user && $password === $user['password']) {
                $_SESSION['user'] = $user;
                return true;
            } else {
                echo "Mot de passe incorrect.";  
            }
        } else {
            echo "Utilisateur introuvable.";  
        }
    
        return false;
    }
    
    

    public function isAuthenticated() {
        return isset($_SESSION['user']);
    }

    public function isAdmin() {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin';
    }
    public function isUser() {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'user';
    }
    public function logout() {
        session_unset();
        session_destroy();
    }
}
