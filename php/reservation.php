/<?php
@include 'config.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login_form.php");
    exit();
}

$stmtTrain = $conn->prepare("SELECT * FROM train_trips");
$stmtTrain->execute();
$resultFrom = $stmtTrain->fetchAll(PDO::FETCH_ASSOC);

$error = [];
$success = [];

if(isset($_POST['submit'])){
    $travel_way = $_POST['radio'];
    $from = $_POST['from'];
    $to = $_POST['to'];
    $depart = $_POST['depart'];
    $return = $_POST['return'] ?? NULL;
    $time = $_POST['time'];
    $Seat_No = $_POST['seat'];
    $Bag_Wh = $_POST['bag'];
    $tr_class = $_POST['travelClass'];

    $stmt = $conn->prepare("SELECT res_ID FROM reservation ORDER BY res_ID DESC LIMIT 1");
    $stmt->execute();
    $last = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $last ? ((int)$last['res_ID'] + 1) : 1;

    $stmtTrip = $conn->prepare("SELECT * FROM train_trips WHERE From_start = ? AND To_end = ? AND Date_trip = ? AND Time_trip = ?");
    $stmtTrip->execute([$from, $to, $depart, $time]);
    $trip = $stmtTrip->fetch(PDO::FETCH_ASSOC);

    if($trip){
        $stmtInsert = $conn->prepare("
            INSERT INTO reservation
            (res_ID, From_city, To_city, Depart, Return_Trip, Seat_No, Bag_Wh, Travel_Class, travel_way, Time_trip)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmtInsert->execute([$id, $from, $to, $depart, $return, $Seat_No, $Bag_Wh, $tr_class, $travel_way, $time]);

        $_SESSION['id_res'] = $id;
        header('Location: success.php');
        exit();
    } 
    else {
        $error[] = "Trip Not Exists!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>reservation Form</title>
<link rel="stylesheet" href="css/reseration-css.css">
<style>
body { background-color: LavenderBlush; }
</style>
</head>

<body>

<div class="content">
<div class="signup-form bg-dark">
<form action="" method="post">
<div class="signup-head bg-warning"><h1>Reserve Your Ticket</h1></div>

<div class="signup-content">
<input type="radio" class="radio" name="radio" required value="One Way" onclick="EnableDisableTB();">
<label class="text-white">One Way</label>

<input type="radio" class="radio" name="radio" id="reID" value="Return" checked onclick="EnableDisableTB();">
<label class="text-white">Return</label>
</div>

<div class="signup-content2">

<label class="text-white travel">From</label>
<select class="bg-dark text-white travel2" style="width:200px;" name="from" id="fromSelect" required>
<option></option>
<?php
foreach($resultFrom as $rows){
    echo "<option value='".$rows['From_start']."'>".$rows['From_start']."</option>";
}
?>
</select><br>

<label class="text-white travel" style="margin-left:30px;">To</label>
<select class="bg-dark text-white travel2" style="width:200px;" name="to" id="toSelect" required>
<option></option>
</select><br>

<label class="text-white travel" style="margin-left:1px;">Depart</label>
<select class="bg-dark text-white travel2" style="width:200px;" name="depart" id="departSelect" required>
<option></option>
</select><br>

<label class="text-white travel" style="margin-left:15px;">Time</label>
<select class="bg-dark text-white travel2" style="width:200px;" name="time" id="timeSelect" required>
<option></option>
</select><br>

<label class="text-white" style="margin-left:10px;">Return</label>
<input type="date" name="return" id="reDa" class="tarikh bg-dark"><br>

<input type="number" name="seat" class="bg-dark person" placeholder="Seat Number" min="1" required>
<input type="number" name="bag" class="bg-dark person" placeholder="Bag Weight" min="0" required><br>

<label class="text-white travel">Travel Class</label>
<select class="bg-dark text-white travel2" name="travelClass" required>
<option></option>
<option>First Class</option>
<option>Second Class</option>
<option>Economy</option>
</select>

<input type="submit" name="submit" value="Reserve" class="submit-btn_bg-warning">

<?php
if(!empty($error)){
    echo "<br><br>";
    foreach($error as $e){ echo $e . "<br>"; }
}
?>
</div>
</form>

<div style="text-align:right; margin:10px;">
<form action="logout.php" method="post">
<button type="submit" class="btn-logout" style="padding:5px 10px; background-color:red; color:white; border:none; border-radius:5px; cursor:pointer;">Logout</button>
</form>
</div>

</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$("#fromSelect").change(function () {
    var fromValue = $(this).val();

    if (fromValue !== "") {
        $.post("ajax_loader.php", {type: "to", from: fromValue}, function (data) {
            $("#toSelect").html(data);
        });

        $.post("ajax_loader.php", {type: "depart", from: fromValue}, function (data) {
            $("#departSelect").html(data);
        });

        $.post("ajax_loader.php", {type: "time", from: fromValue}, function (data) {
            $("#timeSelect").html(data);
        });
    }
});

function EnableDisableTB(){
    let returnRadio = document.getElementById("reID");
    let returnDate = document.getElementById("reDa");
    if(returnRadio.checked){
        returnDate.disabled = false;
    } else {
        returnDate.disabled = true;
        returnDate.value = "";
    }
}

document.getElementById("reDa").addEventListener("change", function () {
    let depart = document.querySelector("select[name='depart']").value;
    let ret = this.value;
    if(depart === "" || ret === "") return;
    let departDate = new Date(depart);
    let returnDate = new Date(ret);
    if(returnDate < departDate){
        alert("Error: The return date must be after or on the same day as departure.");
        this.value = "";
    }
});
</script>

</body>
</html>
