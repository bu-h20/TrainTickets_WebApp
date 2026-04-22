<?php
@include 'config.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login_form.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Page</title>
<link rel="stylesheet" href="css/style-css.css">
<style>
    body {
        font-family: Arial, sans-serif;

        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background-color: LavenderBlush;
    }

    .header {
        width: 100%;
        padding: 20px 30px;
        background-color: #b4c0cdff;
        color: #fff;
        text-align: center;
        font-size: 32px;
        font-weight: bold;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
       
    }

    .header::after {
        content: "";
        display: block;
        width: 100%;
        height: 200px;
        background-image: url('https://i.pinimg.com/originals/bd/e8/31/bde8311914aec4d7812de732d236a1b8.gif');
        background-size: cover;
        background-position: center;
        margin-top: 10px;
        margin-bottom: 10px;
        border-radius: 0 0 15px 15px;
    }

    .top-right {
        position: absolute;
        top: 10px;
        right: 30px;
    }

    .btn-logout {
        background-color: #ff4d4f;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: bold;
        cursor: pointer;
    }
    .btn-logout:hover {
        background-color: #c41d1d;
    }

    .container {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        font-size: 22px;

     
    }

    h3 {
        font-size: 38px;
        margin-bottom: 10px;
        color: #384756ff;
    }

    h1 {
        font-size: 36px;
        margin-bottom: 40px;
    }

    h1 span {
        color: #d63384;
    }

    .btn, .btn-contact {
        display: inline-block;
        padding: 15px 30px;
        margin: 10px;
        border-radius: 25px;
        font-weight: bold;
        text-decoration: none;
        cursor: pointer;
    }

    .btn {
        background-color:#fbd0d9;
        color: #fff;
        border: none;
    }
    .btn:hover {
        background-color: #fbd0d9;
    }

    .btn-contact {
        background-color: orange;
        color: #fff;
        border: none;
        font-size: 18px;
        position: fixed;
        bottom: 30px;
        right: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .btn-contact:hover {
        background-color: red;
    }
</style>
</head>
<body>

<div class="header">Home Page
    <div class="top-right">
        <form action="logout.php" method="post" style="margin:0;">
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    <h3>Welcome</h3>
    <h1><span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span></h1>

    <a href="ticket_details.php" class="btn">Tickets Details</a>
    <a href="reservation.php" class="btn">Take a Reservation</a>
</div>

<a href="contact us.html" class="btn-contact">Contact Center</a>

</body>
</html>
