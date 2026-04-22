<?php
@include "config.php";

$type = $_POST['type'] ?? '';
$from = $_POST['from'] ?? '';

if(empty($from)){
    echo "<option value=''>Select a valid start city</option>";
    exit();
}

if($type && $from){
    if ($type == "to") {
        $stmt = $conn->prepare("SELECT DISTINCT To_end FROM train_trips WHERE From_start = ?");
        $stmt->execute([$from]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row){
            echo "<option value='".$row['To_end']."'>".$row['To_end']."</option>";
        }
    }
    elseif ($type == "depart") {
        $stmt = $conn->prepare("SELECT DISTINCT Date_trip FROM train_trips WHERE From_start = ? ORDER BY Date_trip ASC");
        $stmt->execute([$from]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row){
            echo "<option value='".$row['Date_trip']."'>".$row['Date_trip']."</option>";
        }
    }
    elseif ($type == "time") {
        $stmt = $conn->prepare("SELECT DISTINCT Time_trip FROM train_trips WHERE From_start = ? ORDER BY Time_trip ASC");
        $stmt->execute([$from]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row){
            echo "<option value='".$row['Time_trip']."'>".$row['Time_trip']."</option>";
        }
    }
}
?>
