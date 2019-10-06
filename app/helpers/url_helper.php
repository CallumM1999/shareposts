<?php
    // Sinple page redirect
    function redirect($path) {
        header('Location: ' . URLROOT . $path);
    }