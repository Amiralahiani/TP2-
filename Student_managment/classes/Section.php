
<?php
class Section {
    private $repository;

    public function __construct() {
        $this->repository = new Repository('sections');  // Utilisation du Repository pour la table "sections"
    }

    public function findAll() {
        return $this->repository->findAll();
    }

    public function create($data) {
        return $this->repository->create($data);
    }

    
    public function delete($id) {
        try {
            $stmt = $this->repository->getPdo()->prepare("DELETE FROM sections WHERE id = :id");
            $stmt->execute(['id' => $id]);
    
            // Vérifiez si une ligne a été affectée (supprimée)
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            // Si une erreur survient, vous pouvez la capturer et afficher un message
            echo 'Erreur de suppression : ' . $e->getMessage();
            return false;
        }
    }
    
    
public function getStudentsInSection($sectionId) {
    $stmt = $this->repository->pdo->prepare("SELECT * FROM students WHERE section = :section_id");
    $stmt->execute(['section_id' => $sectionId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
