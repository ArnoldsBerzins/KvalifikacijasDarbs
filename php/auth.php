<?php

include_once "func-user.php";

if (isset($_POST['email']) && isset($_POST['password'])) {

    include "../db_conn.php";

    include "func-validation.php";

    $email = $_POST['email'];
    $password = $_POST['password'];
    $text = "'E-pasts'";
    $location = "../login.php";
    $ms = "error";
    is_empty($email, $text, $location, $ms, "");

    $text = "'Parole'";
    $location = "../login.php";
    $ms = "error";
    is_empty($password, $text, $location, $ms, "");

    $sql = "SELECT * FROM user WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    if($stmt->rowCount() === 1) {
        $user = $stmt->fetch();

        $user_id = $user['id'];
        $user_name = $user['name'];
        $user_surname = $user['surname'];
        $user_email = $user['email'];
        $user_password = $user['password'];
        $user_type = $user['user_type']; 
        if ($email === $user_email) {
            if (password_verify($password, $user_password)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_email'] = $user_email;
                if ($userStatus == 0) {
                    header("Location: ../index.php");
                    exit();
                } else if ($userStatus == 1) {
                    header("Location: ../admin.php");
                    exit();
                } 
                else if ($userStatus == 2) {
                    header("Location: ../login.php");
                    echo "dirsaa";
                    exit();
                }
            } else {
                $em = "Nepareizs e-pasts vai parole!";
                header("Location: ../login.php?error=$em");
                exit();
            }
        } else {
            $em = "Nepareizs e-pasts vai parole!";
            header("Location: ../login.php?error=$em");
            exit();
        }
    } else {
        $em = "Nepareizs e-pasts vai parole!";
        header("Location: ../login.php?error=$em");
        exit();
    }

} else {
    header("Location: ../login.php");
    exit();
}