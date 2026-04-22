<?php
@include 'config.php';
session_start();
$error = [];

if(isset($_POST['submit'])){
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM user_form WHERE email = ?");
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row && password_verify($pass, $row['password'])){
        $_SESSION['user_name'] = $row['f_name'];
        $_SESSION['user_id'] = $row['id_user'];
        header('Location: user_page.php'); 
        exit();
    } else {
        $error[] = 'Incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <link rel="stylesheet" href="css/style-css.css">
    <style>
        body { background-color: LavenderBlush; font-family: Arial, sans-serif; }
    </style>
</head>
<body>
<div class="form-container">
    <form action="" method="POST">
        <h3>Login Now</h3>
        <?php
        if(!empty($error)){
            foreach($error as $err){
                echo '<span class="error-msg">'.$err.'</span>';
            }
        }

        if(isset($_GET['register']) && $_GET['register'] === 'success'){
            echo '<p style="color:green;">Registration successful! Please login.</p>';
        }
        ?>
        <input type="email" name="email" required placeholder="Enter your email">
        <input type="password" name="password" required placeholder="Enter your password">
        <input type="submit" name="submit" value="Login Now" class="form-btn">
        <p>Don't have an account? <a href="register_form.php">Register Now</a></p>
    </form>
</div>
</body>
</html>
