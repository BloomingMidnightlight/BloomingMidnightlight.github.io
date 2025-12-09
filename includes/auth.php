<?php
// includes/auth.php

// Only start session if none is active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


