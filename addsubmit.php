<?php
include('db.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $item_name = $con->real_escape_string($_POST['item_name']);

    $sql = "INSERT INTO add_item (item_name) VALUES ('$item_name')";

    if ($con->query($sql) === TRUE) {
        header("Location: add.php");
        exit(); 
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

$con->close();
?>
