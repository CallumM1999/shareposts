<?php
    class Post {
        private $db;
        
        public function __construct() {
            $this->db = new Database();
        }

        public function getPosts() {
            $this->db->query('select posts.*, name from posts left join users on posts.user_id = users.id order by created_at desc');

            return $this->db->resultSet();
        }

        public function addPost($data) {
            $this->db->query('insert into posts (user_id, title, body) values (:user_id, :title, :body)');
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':body', $data['body']);

            return $this->db->execute();
        }

        public function getPostById($id) {
            $this->db->query('select * from posts where id = :id');
            $this->db->bind(':id', $id);

            return $this->db->single();
        }

        public function updatePost($data) {
            $this->db->query('update posts set title = :title, body = :body where id = :id');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':body', $data['body']);
            $this->db->bind(':id', $data['id']);

            return $this->db->execute();
        }        

        public function deletePost($id) {
            $this->db->query('delete from posts where id = :id');
            $this->db->bind(':id', $id);

            return $this->db->execute();
        }
    }