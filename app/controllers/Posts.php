<?php
    class Posts extends Controller {
        public function __construct() {
            // Protected route
            if(!Session::isLoggedIn()) redirect('/users/login'); 

            // Load model
            $this->postModel = $this->model('Post');
            $this->userModel = $this->model('User');
        }

        public function index() {
            $posts = $this->postModel->getPosts();

            $data = [
                'title' => 'Posts',
                'posts' => $posts
            ];

            $this->view('posts/index', $data);
        }

        public function add() {
           
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'body_err' => ''
                ];

                // Validate data
                if(empty($data['title'])) {
                    $data['title_err'] = 'Please enter a title';
                }

                if(empty($data['body'])) {
                    $data['body_err'] = 'Please enter body text';
                }

                if (empty($data['title_err']) && empty($data['body_err'])) {
                    // Validated
                    if($this->postModel->addPost($data)) {
                        Session::flash('post_message', 'Post created');
                        redirect('/posts');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    // Load view with errors
                    $this->view('posts/add', $data);
                }
            } else {
                $data = [
                    'title' => '',
                    'body' => ''
                ];
    
                $this->view('posts/add', $data);
            }
        }

        public function edit($id) {
           
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'title' => trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'id' => $id,
                    'title_err' => '',
                    'body_err' => ''
                ];

                // Validate data
                if(empty($data['title'])) {
                    $data['title_err'] = 'Please enter a title';
                }

                if(empty($data['body'])) {
                    $data['body_err'] = 'Please enter body text';
                }

                if (empty($data['title_err']) && empty($data['body_err'])) {
                    // Validated
                    if($this->postModel->updatePost($data)) {
                        Session::flash('post_message', 'Post updated');
                        redirect('/posts');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    // Load view with errors
                    $this->view('posts/edit', $data);
                }
            } else {
                // Get existing post from model
                $post = $this->postModel->getPostById($id);

                // Check for owner
                if($post->user_id !== $_SESSION['user_id']) {
                    redirect('/posts');
                }

                $data = [
                    'id' => $id,
                    'title' => $post->title,
                    'body' => $post->body,
                ];
    
                $this->view('posts/edit', $data);
            }
        }

        public function show($id) {
            $post = $this->postModel->getPostById($id);
            $user = $this->userModel->getUserById($post->user_id);

            $data = [
                'post' => $post,
                'user' => $user
            ];

            $this->view('posts/show', $data);
        }

        public function delete($id) {
            // Check for owner
            if($post->user_id !== $_SESSION['user_id']) {
                redirect('/posts');
            }
            
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                if($this->postModel->deletePost($id)) {
                    Session::flash('post_message', 'Post deleted');
                    redirect('/posts');
                } else {
                    die('Something went wrong');
                }
            } else {
                redirect('posts');
            }
        }
    }