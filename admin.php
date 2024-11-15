<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve main quotation details
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $quotationNo = isset($_POST['quotationNo']) ? $_POST['quotationNo'] : '';
    $quotationTo = isset($_POST['quotationTo']) ? $_POST['quotationTo'] : '';
    $quotationAmount = isset($_POST['quotationAmount']) ? $_POST['quotationAmount'] : '';
    $subtotal = isset($_POST['subtotal']) ? $_POST['subtotal'] : '';
    $profit = isset($_POST['profit']) ? $_POST['profit'] : '';
    $loss = isset($_POST['loss']) ? $_POST['loss'] : '';

    // Insert main quotation into the Admin table
    $sql = "INSERT INTO Admin (date, `quotation No`, `quotation To`, `quotation Amount`, subtotal, profit, loss)
            VALUES ('$date', '$quotationNo', '$quotationTo', '$quotationAmount', '$subtotal', '$profit', '$loss')";

    if ($con->query($sql) === TRUE) {
        $last_id = $con->insert_id; // Get the last inserted ID

        // Loop through items in the quotation
        $rows = 0; // Initialize row count
        while (isset($_POST["item" . ($rows + 1)])) {
            $item = isset($_POST["item" . ($rows + 1)]) ? $_POST["item" . ($rows + 1)] : '';
            $price = isset($_POST["price" . ($rows + 1)]) ? $_POST["price" . ($rows + 1)] : 0; // Default to 0 if not set
            $qty = isset($_POST["qty" . ($rows + 1)]) ? $_POST["qty" . ($rows + 1)] : 0; // Default to 0 if not set
            $total = isset($_POST["total" . ($rows + 1)]) ? $_POST["total" . ($rows + 1)] : 0; // Default to 0 if not set

            // Insert only if item is not empty (to avoid inserting blank rows)
            if (!empty($item)) {
                $sql2 = "INSERT INTO Admin2 (quotation_id, item, price, qty, total) 
                         VALUES ('$last_id', '$item', '$price', '$qty', '$total')";
                $con->query($sql2);
            }

            $rows++; // Increment row counter
        }

        // Redirect after successful insertion
        header("Location: display.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}
?>
