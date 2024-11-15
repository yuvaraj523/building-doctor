<?php
include('db.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve non-array fields
    $date = $con->real_escape_string($_POST['date'] ?? '');
    $quotation_no = $con->real_escape_string($_POST['quotation_no'] ?? '');
    $quotation_to = $con->real_escape_string($_POST['quotation_to'] ?? '');
    $subtotal_expense = $con->real_escape_string($_POST['subtotal_expense'] ?? '');
    $subtotal_selling = $con->real_escape_string($_POST['subtotal_selling'] ?? '');
    $profit = $con->real_escape_string($_POST['profit'] ?? '');
    $loss = $con->real_escape_string($_POST['loss'] ?? '');

    // Retrieve array fields for each row
    $items = $_POST['item'] ?? [];
    $expense_prices = $_POST['expense_price'] ?? [];
    $selling_prices = $_POST['selling_price'] ?? [];
    $quantities = $_POST['qty'] ?? [];
    $total_expenses = $_POST['total_expense'] ?? [];
    $total_sellings = $_POST['total_selling'] ?? [];

    // Loop through each row and insert into the database
    foreach ($items as $index => $item) {
        $sno = $index + 1;  // Assuming S.No is the index + 1
        $item = $con->real_escape_string($item);
        $expense_price = $con->real_escape_string($expense_prices[$index] ?? 0);
        $selling_price = $con->real_escape_string($selling_prices[$index] ?? 0);
        $qty = $con->real_escape_string($quantities[$index] ?? 0);
        $total_expense = $con->real_escape_string($total_expenses[$index] ?? 0);
        $total_selling = $con->real_escape_string($total_sellings[$index] ?? 0);

        // Insert each row's data into the database
        $sql = "INSERT INTO expense (date, quotation_no, quotation_to, sno, item, expense_price, selling_price, qty, total_expense, total_selling, subtotal_expense, subtotal_selling, profit, loss)
                VALUES ('$date', '$quotation_no', '$quotation_to', '$sno', '$item', '$expense_price', '$selling_price', '$qty', '$total_expense', '$total_selling', '$subtotal_expense', '$subtotal_selling', '$profit', '$loss')";

        if ($con->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }

    // Redirect after successful insertion
    header("Location: success.php");
    exit();
}

$con->close();
?>
