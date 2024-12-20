<?php
// Database connection
include "db.php";

// Handle form submission for updating a record
if (isset($_POST['update'])) {
    $Product_Name = $_POST['Product_Name'];
    $Stock_Quantity = $_POST['Stock_Quantity'];
    $Disbursement_Amount = $_POST['Disbursement_Amount'];
    $Store_Name = $_POST['Store_Name'];
    $Status = $_POST['Status'];
    $Date = $_POST['Date'];

    // Corrected SQL query with backticks for column names
    $sql = "UPDATE `distribution` 
            SET `Product_Name` = '$Product_Name',
                `Stock_Quantity` = '$Stock_Quantity',
                `Disbursement_Amount` = '$Disbursement_Amount',
                `Store_Name` = '$Store_Name',
                `Status` = '$Status',
                `Date` = '$Date' 
            WHERE `Product_Name` = '$Product_Name'";

    $result = $conn->query($sql);

    if ($result == TRUE) {
        echo '<div class="alert alert-success" role="alert">Record updated successfully.</div>';
        header("refresh:0; url=/Dbms_project/Know Your Grass/distributors.php?success=1");
    } else {
        echo '<div class="alert alert-danger" role="alert">Error updating record: ' . $conn->error . '</div>';
    }
}

// Fetch data for the modal form
if (isset($_GET['Product_Name'])) {
    $Product_Name = $_GET['Product_Name'];

    $sql = "SELECT * FROM `distribution` WHERE `Product_Name`='$Product_Name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Stock_Quantity = $row['Stock_Quantity'];
        $Disbursement_Amount = $row['Disbursement_Amount'];
        $Store_Name = $row['Store_Name'];
        $Status = $row['Status'];
        $Date = $row['Date'];
    } else {
        echo '<div class="alert alert-danger" role="alert">No record found with the specified Product_Name.</div>';
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batch Package Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/nucleo/2.0.6/css/nucleo-icons.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Batch Package Update Form</h2>
        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal">
            Edit Batch Package
        </button> -->
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">পণ্য সম্পাদনা করুন</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="Product_Name" class="form-label">পণ্যের নাম</label>
                            <input type="text" class="form-control" name="Product_Name" id="Product_Name" value="<?php echo $Product_Name; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="Stock_Quantity" class="form-label">স্টক পরিমাণ</label>
                            <input type="number" class="form-control" name="Stock_Quantity" id="Stock_Quantity" value="<?php echo $Stock_Quantity; ?>" >
                        </div>
                        <div class="mb-3">
                            <label for="Disbursement_Amount" class="form-label">বিতরণ পরিমাণ</label>
                            <input type="number" class="form-control" name="Disbursement_Amount" id="Disbursement_Amount" value="<?php echo $Disbursement_Amount; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="Store_Name" class="form-label">দোকানের নাম</label>
                            <input type="text" class="form-control" name="Store_Name" id="Store_Name" value="<?php echo $Store_Name; ?>">
                        </div>
                        <div class="mb-3">
                        <label for="Status" class="form-label">অবস্থা</label>
                                <select class="form-control" id="Status" name="Status" required>
                                <option value="" disabled selected>Select status</option>
                                <option value="delivered">Delivered</option>  
                                <option value="in the warehouse">In the warehouse</option>
                                </select>

                        </div>
                        <div class="mb-3">
                            <label for="Date" class="form-label">তারিখ</label>
                            <input type="date" class="form-control" name="Date" id="Date" value="<?php echo $Date; ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
                            <button type="submit" class="btn btn-primary" name="update">সংরক্ষণ করুন</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Auto-open Modal -->
    <?php if (isset($_GET['Product_Name'])): ?>
    <script>
        const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
        editModal.show();
    </script>
    <?php endif; ?>
</body>
</html>
