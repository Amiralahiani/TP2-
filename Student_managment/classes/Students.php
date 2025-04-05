
<?php
class Student {
    private $repository;

    public function __construct() {
        $this->repository = new Repository('students');  
    }

        public function findAll($search = '') {
            $sql = "SELECT * FROM students";
            
            if ($search) {
                $sql .= " WHERE name LIKE :search";
            }
            
            $stmt = $this->repository->getPdo()->prepare($sql);
            
            if ($search) {
                $stmt->execute(['search' => '%' . $search . '%']);
            } else {
                $stmt->execute();
            }
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function findBySection($section_id) {
            $stmt = $this->repository->getPdo()->prepare("SELECT * FROM students WHERE section_id = :section_id");
            $stmt->execute(['section_id' => $section_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function find($id) {
            
            $stmt = $this->repository->getPdo()->prepare("SELECT * FROM students WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
        public function update($id, $name, $birthday, $section) {
        
            $stmt = $this->repository->getPdo()->prepare("UPDATE students SET name = :name, birthday = :birthday, section = :section WHERE id = :id");
            $stmt->execute([
                'id' => $id,
                'name' => $name,
                'birthday' => $birthday,
                'section' => $section
            ]);
        }
        

        public function create($data) {
        return $this->repository->create($data);
    }

    public function delete($id) {
        return $this->repository->delete($id);
    }
}
