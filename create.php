<?php
include('db.php');

// Fetch data from the database
$sql = "SELECT * FROM expense";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Display</title>
    <style>
        /* Basic CSS Styling */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px 12px; border: 1px solid #ddd; text-align: center; }
        .action-btn { cursor: pointer; color: blue; }
        .action-btn:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h2>Quotation Management</h2>
    <table>
        <thead>
            <tr>
                <th>Select</th>
                <th>Date</th>
                <th>Quotation No</th>
                <th>Quotation To</th>
                <th>S.No</th>
                <th>Item</th>
                <th>Expense Price</th>
                <th>Selling Price</th>
                <th>Qty</th>
                <th>Total Expense</th>
                <th>Total Selling</th>
                <th>Subtotal Expense</th>
                <th>Subtotal Selling</th>
                <th>Profit</th>
                <th>Loss</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><input type="checkbox" name="select[]" value="<?php echo htmlspecialchars($row['id']); ?>"></td>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo htmlspecialchars($row['quotation_no']); ?></td>
                        <td><?php echo htmlspecialchars($row['quotation_to']); ?></td>
                        <td><?php echo htmlspecialchars($row['sno']); ?></td>
                        <td><?php echo htmlspecialchars($row['item']); ?></td>
                        <td><?php echo number_format($row['expense_price'], 2); ?></td>
                        <td><?php echo number_format($row['selling_price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($row['qty']); ?></td>
                        <td><?php echo number_format($row['total_expense'], 2); ?></td>
                        <td><?php echo number_format($row['total_selling'], 2); ?></td>
                        <td><?php echo number_format($row['subtotal_expense'], 2); ?></td>
                        <td><?php echo number_format($row['subtotal_selling'], 2); ?></td>
                        <td><?php echo number_format($row['profit'], 2); ?></td>
                        <td><?php echo number_format($row['loss'], 2); ?></td>
                        <td>
                            <span class="action-btn" onclick="editRecord(<?php echo $row['id']; ?>)">Edit</span> 
                            <span class="action-btn" onclick="copyRecord(<?php echo $row['id']; ?>)">Copy</span> 
                            <span class="action-btn" onclick="deleteRecord(<?php echo $row['id']; ?>)">Delete</span>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="16">No records found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Check all / With selected options -->
    <div style="margin-top: 10px;">
        <input type="checkbox" id="checkAll" onclick="toggleSelectAll()"> Check all
        <button onclick="applySelectedAction()">With selected</button>
    </div>

    <script>
        // Toggle check all checkboxes
        function toggleSelectAll() {
            const checkboxes = document.querySelectorAll('input[name="select[]"]');
            checkboxes.forEach(cb => cb.checked = document.getElementById('checkAll').checked);
        }

        // Functions for Edit, Copy, Delete actions
        function editRecord(id) {
            window.location.href = 'edit.php?id=' + id;
        }
        function copyRecord(id) {
            window.location.href = 'copy.php?id=' + id;
        }
        function deleteRecord(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = 'delete.php?id=' + id;
            }
        }

        // Apply action to selected checkboxes
        function applySelectedAction() {
            const selectedIds = Array.from(document.querySelectorAll('input[name="select[]"]:checked')).map(cb => cb.value);
            if (selectedIds.length > 0) {
                console.log("Selected IDs:", selectedIds);
                // Further logic for selected actions can be added here
            } else {
                alert("No records selected.");
            }
        }
    </script>
</body>
</html>

<?php $con->close(); ?>
