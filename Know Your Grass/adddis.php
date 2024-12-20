<?php 

include "db.php";

// Handle form submission for adding new product tracking details
if (isset($_POST['submit'])) {
    // Fetch the input values
    $Product_Name = $_POST['Product_Name'];
    $Stock_Quantity = $_POST['Stock_Quantity'];
    $Disbursement_Amount = $_POST['Disbursement_Amount'];
    $Store_Name = $_POST['Store_Name'];
    $Status = $_POST['Status'];
    $Date = $_POST['Date'];

    // Insert data into the database
    $sql = "INSERT INTO `distribution` 
            (`Product_Name`, `Stock_Quantity`, `Disbursement_Amount`, `Store_Name`, `Status`, `Date`) 
            VALUES 
            ('$Product_Name', '$Stock_Quantity', '$Disbursement_Amount', '$Store_Name', '$Status', '$Date')";

    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo '<div class="alert alert-success" role="alert">Product added successfully!</div>';
        echo "<script>console.log('New product added successfully!');</script>";
        header( "refresh:0; url=/Dbms_project/Know Your Grass/distributors.php?success=1" );
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
              <label for="Product_Name" class="form-label">পণ্যের নাম</label>
              <input type="text" class="form-control" id="Product_Name" name="Product_Name" required>
            </div>
            <div class="mb-3">
              <label for="Stock_Quantity" class="form-label">স্টক পরিমাণ</label>
              <input type="number" class="form-control" id="Stock_Quantity" name="Stock_Quantity" required>
            </div>
            <div class="mb-3">
              <label for="Disbursement_Amount" class="form-label">বিতরণ পরিমাণ</label>
              <input type="number" class="form-control" id="Disbursement_Amount" name="Disbursement_Amount" required>
            </div>
            <div class="mb-3">
              <label for="Store_Name" class="form-label">দোকানের নাম</label>
              <input type="text" class="form-control" id="Store_Name" name="Store_Name" required>
            </div>
            <div class="mb-3">
            <label for="Status" class="form-label">অবস্থা</label>
                <select class="form-control" id="Status" name="Status" required>
                    <option value="" disabled selected>Select status</option>
                    <option value="delivered">Delivered</option>  
                    <option value="in the warehouse">In the warehouse</option>
                </select>

              <!-- <input type="select" class="form-control" id="Status" name="Status" required> -->
            </div>
            <div class="mb-3">
              <label for="Date" class="form-label">তারিখ</label>
              <input type="date" class="form-control" id="Date" name="Date" required>
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
