<?php
// Start the session
session_start();

// Include database connection file
include_once "db_conn.php";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $userType = 0;

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $_SESSION['message'] = 'Paroles nesakrīt. Lūdzu mēģiniet atkal';
        header('Location: register.php');
        exit;
    }

    try {
        // Check if the email is already used
        $checkStmt = $conn->prepare("SELECT id FROM user WHERE email = :email");
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            // Email is already used
            $_SESSION['message'] = 'E-pasts jau tiek izmantots';
            header('Location: register.php');
            exit;
        }

        // Hash the password using password_hash
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database
        $insertStmt = $conn->prepare("INSERT INTO user (name, surname, email, password, user_type) VALUES (:name, :surname, :email, :password, :user_type)");

        // Bind parameters
        $insertStmt->bindParam(':name', $name);
        $insertStmt->bindParam(':surname', $surname);
        $insertStmt->bindParam(':email', $email);
        $insertStmt->bindParam(':password', $hashedPassword);
        $insertStmt->bindParam(':user_type', $userType);

        // Execute the statement
        $insertStmt->execute();

        // Registration successful
        $_SESSION['message'] = 'Reģistrācija veiksmīga!';
        header('Location: login.php');
        exit;
    } catch (PDOException $e) {
        // Registration failed
        $_SESSION['message'] = 'Reģistrācija neizdevās. Lūdzu mēģiniet atkal. Kļūda: ' . $e->getMessage();
        echo error_log($e->getMessage());
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Reģistrācija</title>
</head>
<body>
    <div class="container mt-5">
        <?php
        // Display registration message
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-info" role="alert">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
        }
        ?>
        <h2>Reģistrēties</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Vārds</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="surname" class="form-label">Uzvārds</label>
                <input type="text" class="form-control" id="surname" name="surname" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-pasts</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Parole</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Parole Atkārtoti</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Reģistrēties</button>
            <a href="login.php" style="text-decoration:none;">Ieiet</a>
        </form>
    </div>
</body>
</html>