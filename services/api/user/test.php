<?php
session_start();

echo 'name: ' . $_SESSION['name'] .'<br>';
echo 'user_id: ' . $_SESSION['user_id'];