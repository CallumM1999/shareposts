<?php
    class Users extends Controller {
        public function __construct() {
            $this->userModel = $this->model('User');
        }

        private function createUserSession($loggedInUser) {
            $_SESSION['user_id'] = $loggedInUser->id;
            $_SESSION['user_email'] = $loggedInUser->email;
            $_SESSION['user_name'] = $loggedInUser->name;
        }

        public function register() {
            // Check for POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process form

                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                ];

                if (empty($data['email'])) {
                    // Validate Email
                    $data['email_err'] = 'Please enter email';
                } elseif ($this->userModel->findUserByEmail($data['email'])) {
                    // Check email
                    $data['email_err'] = 'Email is already taken';
                }

                // Validate Email
                if (empty($data['name'])) {
                    $data['name_err'] = 'Please enter name';
                }

                // Validate Password
                if (empty($data['password'])) {
                    $data['password_err'] = 'Please enter password';
                } elseif (strlen($data['password']) < 6) {
                    $data['password_err'] = 'Please must be at lease 6 characters';
                }

                // Validate Confirm password
                if (empty($data['confirm_password'])) {
                    $data['confirm_password_err'] = 'Please confirm password';
                } elseif ($data['password'] !== $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }

                // Make sure errors are empty
                if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                    // Validated

                    // Hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    // Register USer
                    if($this->userModel->register($data)) {
                        Session::flash('register_success', 'You are registered and can log in');
                        redirect('/users/login');
                    } else {
                        die('something went wrong');
                    }

                } else {
                    // Load view with errors
                    $this->view('users/register', $data);
                }

            } else {
                // Init data
                $data = [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                ];

                // Load view
                $this->view('users/register', $data);
            }
        }

        public function login() {
            // Check for POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process form

                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_err' => '',
                    'password_err' => '',
                ];

                // Validate Email
                if (empty($data['email'])) {
                    $data['email_err'] = 'Please enter email';
                }

                // Validate Password
                if (empty($data['password'])) {
                    $data['password_err'] = 'Please enter password';
                }

                // Check for user/email
                if ($this->userModel->findUserByEmail($data['email'])) {
                    // User found
                } else {
                    $data['email_err'] = 'No user found';
                }


                // Make sure errors are empty
                if(empty($data['email_err']) && empty($data['password_err'])) {
                    // Validated

                    // check and set logged in user

                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                    if($loggedInUser) {
                        // Create Session
                        $this->createUserSession($loggedInUser);
                        redirect('/posts');
                    } else {
                        $data['password_err'] = ' Password incorrect';
                        $this->view('users/login', $data);
                    }
                } else {
                    // Load view with errors
                    $this->view('users/login', $data);
                }
     
            } else {
                // Init data
                $data = [
                    'email' => '',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => '',
                ];

                // Load view
                $this->view('users/login', $data);
            }
        }

        public function logout() {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            redirect('/users/login');
        }
    }