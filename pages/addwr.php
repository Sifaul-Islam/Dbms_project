<?php 

include "db.php";

// Handle form submission for adding new product tracking details
if (isset($_POST['submit'])) {
    // Fetch the input values
    $barcode = $_POST['barcode'];
    $lotnumber = $_POST['lotnumber'];
    $packagingdate = $_POST['packagingdate'];
    $expirydate = $_POST['expirydate'];
    $number_of_total_package = $_POST['number_of_total_package'];
    $number_of_damaged_package = $_POST['number_of_damaged_package'];

    // Insert data into the database
    $sql = "INSERT INTO `batchpackagedetails` 
            (`barcode`, `lotnumber`, `packagingdate`, `expirydate`, `number_of_total_package`, `number_of_damaged_package`) 
            VALUES 
            ('$barcode', '$lotnumber', '$packagingdate', '$expirydate', '$number_of_total_package', '$number_of_damaged_package')";

    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo '<div class="alert alert-success" role="alert">Product added successfully!</div>';
        echo "<script>console.log('New product added successfully!');</script>";
        header( "refresh:0; url=https://localhost/Dbms_project/pages/warehouse_report.php?success=1" );
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Product Tracking</title>
  <!-- Include Bootstrap 5 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/nucleo/2.0.6/css/nucleo-icons.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
</head>

<body>
  <!-- Add Product Tracking Modal -->
  <div class="modal fade" id="addProductTrackingModal" tabindex="-1" aria-labelledby="addProductTrackingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProductTrackingModalLabel">নতুন পণ্য যোগ করুন</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="POST">
            <div class="mb-3">
              <label for="barcode" class="form-label">বারকোড</label>
              <input type="text" class="form-control" id="barcode" name="barcode" required>
            </div>
            <div class="mb-3">
              <label for="lotnumber" class="form-label">লটনম্বর</label>
              <input type="text" class="form-control" id="lotnumber" name="lotnumber" required>
            </div>
            <div class="mb-3">
              <label for="packagingdate" class="form-label">প্যাকেজিং তারিখ</label>
              <input type="date" class="form-control" id="packagingdate" name="packagingdate" required>
            </div>
            <div class="mb-3">
              <label for="expirydate" class="form-label">মেয়াদ</label>
              <input type="date" class="form-control" id="expirydate" name="expirydate" required>
            </div>
            <div class="mb-3">
              <label for="number_of_total_package" class="form-label">মোট প্যাকেজের সংখ্যা</label>
              <input type="number" class="form-control" id="number_of_total_package" name="number_of_total_package" required>
            </div>
            <div class="mb-3">
              <label for="number_of_damaged_package" class="form-label">ক্ষতিগ্রস্ত প্যাকেজের সংখ্যা</label>
              <input type="number" class="form-control" id="number_of_damaged_package" name="number_of_damaged_package" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
              <button type="submit" class="btn btn-primary" name="submit">সংরক্ষণ করুন</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Include Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

  <!-- Trigger Modal for demonstration -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const addProductModal = new bootstrap.Modal(document.getElementById('addProductTrackingModal'));
      addProductModal.show();
    });
  </script>
</body>

</html>
