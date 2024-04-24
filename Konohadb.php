<?php 
    class DBconn {
        private $db_server, $db_user, $db_pass, $db_name, $conn; 

        public function __construct () {
            $this->db_server = "localhost";
            $this->db_user = "root";
            $this->db_pass = "Solarity45sql";
            $this->db_name = "konohadb";
            $this->conn = mysqli_connect($this->db_server, $this->db_user, $this->db_pass, $this->db_name);
        }

        public function getConn () {
            return $this->conn;
        }
    }
?>