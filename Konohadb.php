<?php 
    class DBconn {
        private $db_server, $db_user, $db_pass, $db_name, $conn; 

        public function __construct () {
            $this->db_server = "localhost";
            $this->db_user = "root";
<<<<<<< HEAD
            $this->db_pass = "fishball04";
=======
            $this->db_pass = "Solarity45sql";
>>>>>>> b8c840c8d6b9da925b2aef81297e1856ee426804
            $this->db_name = "konohadb";
            $this->conn = mysqli_connect($this->db_server, $this->db_user, $this->db_pass, $this->db_name);
        }

        public function getConn () {
            return $this->conn;
        }
    }
?>