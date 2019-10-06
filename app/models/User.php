<?php
    class User {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        // Find user by email
        public function findUserByEmail($email) {
            $this->db->query('SELECT * FROM users WHERE email = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();

            // Check row
            return $this->db->rowCount() > 0;
        }

        // Register user
        public function Register($data) {
            $this->db->query('insert into users (name, email, password) values (:name, :email, :password)');
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);

            return $this->db->execute();
        }

        public function login($email, $password) {
            $this->db->query('select * from users where email = :email');
            $this->db->bind(':email', $email);

            $row = $this->db->single();
            $hashed_password = $row->password;

            return (password_verify($password, $hashed_password)) ? $row : false;
        }

        public function getUserById($id) {
            $this->db->query('select id, name, email from users where id = :id');
            $this->db->bind(':id', $id);

            return $this->db->single();
        }
    }