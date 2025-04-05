
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

    

    public function create($data) {
        return $this->repository->create($data);
    }

    public function delete($id) {
        return $this->repository->delete($id);
    }
}
