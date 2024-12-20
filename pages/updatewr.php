<?php
// Database connection
include "db.php";

// Handle form submission for updating a record
if (isset($_POST['update'])) {
    $lotnumber = $_POST['lotnumber'];
    $barcode = $_POST['barcode'];
    $packagingdate = $_POST['packagingdate'];
    $expirydate = $_POST['expirydate'];
    $number_of_total_package = $_POST['number_of_total_package'];
    $number_of_damaged_package = $_POST['number_of_damaged_package'];

    $sql = "UPDATE `batchpackagedetails` 
            SET `lotnumber`='$lotnumber',
                `packagingdate`='$packagingdate',
                `expirydate`='$expirydate',
                `number_of_total_package`='$number_of_total_package',
                `number_of_damaged_package`='$number_of_damaged_package' 
            WHERE `barcode`='$barcode'";

    $result = $conn->query($sql);

    if ($result == TRUE) {
        echo '<div class="alert alert-success" role="alert">Record updated successfully.</div>';
        header("refresh:0; url=https://localhost/Dbms_project/pages/warehouse_report.php?success=1");
    } else {
        echo '<div class="alert alert-danger" role="alert">Error updating record: ' . $conn->error . '</div>';
    }
}

// Fetch data for the modal form
if (isset($_GET['barcode'])) {
    $barcode = $_GET['barcode'];

    $sql = "SELECT * FROM `batchpackagedetails` WHERE `barcode`='$barcode'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lotnumber = $row['lotnumber'];
        $packagingdate = $row['packagingdate'];
        $expirydate = $row['expirydate'];
        $number_of_total_package = $row['number_of_total_package'];
        $number_of_damaged_package = $row['number_of_damaged_package'];
    } else {
        echo '<div class="alert alert-danger" role="alert">No record found with the specified barcode.</div>';
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
                            <label for="barcode" class="form-label">বারকোড</label>
                            <input type="text" class="form-control" name="barcode" id="barcode" value="<?php echo $barcode; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="lotnumber" class="form-label">লটনম্বর</label>
                            <input type="text" class="form-control" name="lotnumber" id="lotnumber" value="<?php echo $lotnumber; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="packagingdate" class="form-label">প্যাকেজিং তারিখ</label>
                            <input type="date" class="form-control" name="packagingdate" id="packagingdate" value="<?php echo $packagingdate; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="expirydate" class="form-label">মেয়াদ</label>
                            <input type="date" class="form-control" name="expirydate" id="expirydate" value="<?php echo $expirydate; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="number_of_total_package" class="form-label">মোট প্যাকেজের সংখ্যা</label>
                            <input type="number" class="form-control" name="number_of_total_package" id="number_of_total_package" value="<?php echo $number_of_total_package; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="number_of_damaged_package" class="form-label">ক্ষতিগ্রস্থ প্যাকেজের সংখ্যা</label>
                            <input type="number" class="form-control" name="number_of_damaged_package" id="number_of_damaged_package" value="<?php echo $number_of_damaged_package; ?>">
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
    <?php if (isset($_GET['barcode'])): ?>
    <script>
        const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
        editModal.show();
    </script>
    <?php endif; ?>
</body>
</html>
