<?php
@include 'config.php';
$errors = [];

if(isset($_POST['submit'])){
    $f_name = trim($_POST['f_name']);
    $l_name = trim($_POST['l_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Server-side validation
    if(strlen($password) < 6){
        $errors[] = "Password must be at least 6 characters.";
    }
    if(!preg_match('/[A-Z]/', $password)){
        $errors[] = "Password must contain at least one uppercase letter.";
    }
    if(!preg_match('/[a-z]/', $password)){
        $errors[] = "Password must contain at least one lowercase letter.";
    }
    if(!preg_match('/\d/', $password)){
        $errors[] = "Password must contain at least one number.";
    }
    if(!preg_match('/[\W_]/', $password)){
        $errors[] = "Password must contain at least one special character.";
    }
    if($password !== $cpassword){
        $errors[] = "Passwords do not match!";
    }

    $stmt = $conn->prepare("SELECT * FROM user_form WHERE email = ?");
    $stmt->execute([$email]);
    if($stmt->rowCount() > 0){
        $errors[] = "User already exists!";
    }

    if(empty($errors)){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $insert = $conn->prepare("INSERT INTO user_form (f_name, l_name, email, password) VALUES (?, ?, ?, ?)");
        $insert->execute([$f_name, $l_name, $email, $hash]);
        header('Location: login_form.php?register=success');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Form</title>
    <link rel="stylesheet" href="css/style-css.css">
    <style>
        body { background-color: LavenderBlush; font-family: Arial, sans-serif; }
        .error-msg { color: red; display: block; margin-bottom: 5px; }
    </style>
</head>
<body>

<div class="form-container">
    <form name="registerForm" action="" method="post" onsubmit="return validateForm()">
        <h3>Register Now</h3>

        <?php
        if(!empty($errors)){
            foreach($errors as $error){
                echo '<span class="error-msg">'.$error.'</span>';
            }
        }
        ?>

        <input type="text" name="f_name" required placeholder="Enter your first name">
        <input type="text" name="l_name" required placeholder="Enter your last name">
        <input type="email" name="email" required placeholder="Enter your email">
        <input type="password" name="password" required placeholder="Enter your password">
        <input type="password" name="cpassword" required placeholder="Confirm your password">
        <input type="submit" name="submit" value="Register Now" class="form-btn">
        <p>Already have an account? <a href="login_form.php">Login Now</a></p>
    </form>
</div>

<script>
function validateForm() {
    const form = document.forms["registerForm"];
    const password = form["password"].value;
    const cpassword = form["cpassword"].value;

    if(password.length < 6){
        alert("Password should be at least 6 characters");
        return false;
    }
    if(!/[A-Z]/.test(password)){
        alert("Password must contain at least one uppercase letter");
        return false;
    }
    if(!/[a-z]/.test(password)){
        alert("Password must contain at least one lowercase letter");
        return false;
    }
    if(!/\d/.test(password)){
        alert("Password must contain at least one number");
        return false;
    }
    if(!/[\W_]/.test(password)){
        alert("Password must contain at least one special character");
        return false;
    }
    if(password !== cpassword){
        alert("Passwords do not match!");
        return false;
    }

    return true; 
}
</script>

</body>
</html>
