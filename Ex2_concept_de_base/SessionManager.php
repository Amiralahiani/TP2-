<?php

class SessionManager {
    public function __construct() {
        session_start();
    }

    public function incrementerVisite() {
        if (!isset($_SESSION['visites'])) {
            $_SESSION['visites'] = 1;
        } else {
            $_SESSION['visites']++;
        }
    }

    public function getNombreVisites() {
        return $_SESSION['visites'] ?? 0;
    }

    public function estPremiereVisite() {
        return $this->getNombreVisites() === 1;
    }

    public function reinitialiser() {
        session_destroy();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>
