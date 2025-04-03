<?php

class Etudiant {
    public $nom;
    public $notes = [];

    public function __construct($nom, $notes = []) {
        $this->nom = $nom;
        $this->notes = $notes;
    }

    public function afficheNotes() {
        foreach ($this->notes as $note) {
            if ($note > 10) {
                $couleur = "#c8e6c9";
            } elseif ($note == 10) {
                $couleur = "#ffe0b2";
            } else {
                $couleur = "#ffcdd2";
            }
            echo "<div style='background-color: $couleur;padding: 5px; margin: 2px;'>$note</div>";
        }
    }

    public function calculerMoyenne() {
        if (count($this->notes) === 0) {
            return 0;
        }
        return array_sum($this->notes) / count($this->notes);
    }

    public function estAdmis() {
        return $this->calculerMoyenne() >= 10 ? "Admis" : "Non admis";
    }
}

?>