<?php
    session_start();
    
    // Flash message helper
    // EXAMPLE - flash('register_success', 'you are now registered', 'alert alert-danger');
    function flash($name = '', $message = '', $class = 'alert alert-success') {
        // Needs a name to work
        if (empty($name)) return;

        if(!empty($message) && empty($_SESSION[$name])) {
            // set message
            
            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            // render message, then remove session

            // get class if exists in session
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';

            echo '
                <div class="'. $class .'" id="msg-flash">
                    '. $_SESSION[$name] .'
                </div>
            ';

            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }

    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }