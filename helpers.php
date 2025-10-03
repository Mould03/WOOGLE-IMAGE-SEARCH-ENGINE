<?php
function is_admin_logged_in() {
    return !empty($_SESSION['adminID']);
}
function require_admin() {
    if (!is_admin_logged_in()) {
        header('Location: login.php');
        exit;
    }
}
