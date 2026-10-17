<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
session_destroy();
header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/'));
exit;
?>
