<?php
    class Config{
        private $HOST = "localhost";
        private $USERNAME = "root";
        private $PASSWORD = "";
        private $DB_NAME = "school";
        private $connection;

        public function initDB(){
            $this->connection = mysqli_connect($this->HOST, $this->USERNAME, $this->PASSWORD, $this->DB_NAME);

            return $this->connection;
        }

        public function insertData($name, $age, $course){
            $this->initDB();

            $query = "INSERT INTO students (name, age, course) VALUES ('$name', $age, '$course')";

            //mysqli_query(connection_obj, query); // return bool
            return mysqli_query($this->connection, $query);
        }

        public function featchData(){
            $this->initDB();
            $query = "SELECT * FROM students";

            return mysqli_query($this->connection, $query);
        }

        public function deleteData($id){
            $this->initDB();

            $result = $this->getStudentById($id);

            $record = mysqli_fetch_assoc($result);

            if($record){
                $query = "DELETE FROM students WHERE id=$id";

                return mysqli_query($this->connection, $query); //Return num of deleted data
            }else{
                return false;
            }
        }

        public function getStudentById($id){
            $this->initDB();
            $query = "SELECT * FROM students WHERE id=$id";
            $result = mysqli_query($this->connection, $query);
            return mysqli_fetch_assoc($result);
        }
        
        public function updateStudent($id, $name, $age, $course){
            $this->initDB();
            $query = "UPDATE students SET name='$name', age=$age, course='$course' WHERE id=$id";
            return mysqli_query($this->connection, $query);
        }
        
        public function registerUser($username, $email, $password){
            $this->initDB(); 

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

            return mysqli_query($this->connection, $query);//Return bool
        }

        public function loginUser($email, $password){
            $this->initDB();

            $query = "SELECT * FROM users WHERE email='$email'";

            $result = mysqli_query($this->connection, $query);

            $record = mysqli_fetch_assoc($result);

            if($record){
                return password_verify($password, $record['password']);
            }else{
                return false;
            }

        }

        public function insertDepartment($name){
            $this->initDB();

            $query = "INSERT INTO department (name) VALUES ('$name')";

            //mysqli_query(connection_obj, query); // return bool
            return mysqli_query($this->connection, $query);
        }

        public function insertEmployee($name, $id){
            $this->initDB();

            $query = "SELECT * FROM department WHERE id=$id";

            $result = mysqli_query($this->connection, $query);

            $record = mysqli_fetch_assoc($result);

            if ($record) {
                $query = "INSERT INTO employee (name, department_id) VALUES ('$name', $id)";

                //mysqli_query(connection_obj, query); // return bool
                return mysqli_query($this->connection, $query);
            } else {
                return false;
            }
            
        }

        public function insertMedia($name){
            $this->initDB();

            $query = "INSERT INTO media (name) VALUES ('$name')";

            //mysqli_query(connection_obj, query); // return bool
            return mysqli_query($this->connection, $query);
        }

        public function deleteMedia($id){
            $this->initDB();

            $query = "SELECT * FROM media WHERE id=$id";

            $result = mysqli_query($this->connection, $query);

            $record = mysqli_fetch_assoc($result);

            if ($record) {
                
                $isDeleted = unlink("../../image/" . $record['name']);

                if ($isDeleted) {
                    $query = "DELETE FROM media WHERE id=$id";

                    return mysqli_query($this->connection, $query); //Return num of deleted data
                } else {
                    return false;
                }

            } else {
                return false;
            }
            
        }

    }
?>