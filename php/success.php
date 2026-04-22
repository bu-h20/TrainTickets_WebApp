<?php
@include 'config.php';
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login_form.php");
    exit();
}

$id = $_SESSION['id_res'];
$select = "SELECT * FROM reservation WHERE res_ID = '$id'";
$result = mysqli_query($conn, $select);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Ticket</title>
</head>
<body>

<h2>Your Ticket</h2>

<?php
$rows = mysqli_fetch_assoc($result);
if($rows){
    echo "<div>";
    echo "<img src='images_train/ticket.png' alt='Ticket Image' width='200'><br>";
    echo "From: ".htmlspecialchars($rows['From_city'])."<br>";
    echo "To: ".htmlspecialchars($rows['To_city'])."<br>";
    echo "Depart: ".htmlspecialchars($rows['Depart'])."<br>";
    echo "Return: ".htmlspecialchars($rows['Return_Trip'])."<br>";
    echo "Seat No.: ".htmlspecialchars($rows['Seat_No'])."<br>";
    echo "Bag Weight: ".htmlspecialchars($rows['Bag_Wh'])."<br>";
    echo "Class: ".htmlspecialchars($rows['Travel_Class'])."<br>";
    echo "Way: ".htmlspecialchars($rows['travel_way'])."<br>";
    echo "</div>";
}else{
    echo "<p>No reservation found.</p>";
}
?>

<div style="margin-top:20px;">
    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</div>

</body>
</html>
