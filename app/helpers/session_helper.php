<?php
    session_start();

    class Session {
        // Flash message helper
        // EXAMPLE - flash('register_success', 'you are now registered', 'alert alert-danger');
        public static function flash($name = '', $message = '', $class = 'alert alert-success') {
            // Needs a name to work
            if (empty($name)) return;
    
            if(!empty($message) && empty($_SESSION[$name])) {
                self::setFlash($name, $message, $class);
            } elseif (empty($message) && !empty($_SESSION[$name])) {
                self::renderFlash($name);
                self::unsetFlashSession($name);
            }
        }    

        private static function setFlash($name, $message, $class) {
            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        }

        private static function renderFlash($name) {  
            // get class if exists in session
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';

            echo '
                <div class="'. $class .'" id="msg-flash">
                    '. $_SESSION[$name] .'
                </div>
            ';
        }

        private static function unsetFlashSession($name) {
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }

        public static function isLoggedIn() {
            return isset($_SESSION['user_id']);
        }
    } 