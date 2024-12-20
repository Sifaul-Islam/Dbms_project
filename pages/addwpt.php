<?php 
include "db.php";

// Handle form submission for adding new product transfer details
if (isset($_POST['submit'])) {
    // Fetch and escape the input values to prevent SQL injection
    $Product_Name = mysqli_real_escape_string($conn, $_POST['Product_Name']);
    $Farm_Name = mysqli_real_escape_string($conn, $_POST['Farm_Name']);
    $Warehouse_Name = mysqli_real_escape_string($conn, $_POST['Warehouse_Name']);
    $Farm_Location = mysqli_real_escape_string($conn, $_POST['Farm_Location']);
    $Warehouse_Location = mysqli_real_escape_string($conn, $_POST['Warehouse_Location']);
    $Distributor_address = mysqli_real_escape_string($conn, $_POST['Distributor_address']);
    $Transfer_Date = mysqli_real_escape_string($conn, $_POST['Transfer_Date']);

    // Step 1: Get the farm ID
    $sql_farm = "SELECT farmID FROM farm WHERE farmname = ? AND location = ?";
    $stmt_farm = $conn->prepare($sql_farm);
    $stmt_farm->bind_param('ss', $Farm_Name, $Farm_Location);
    $stmt_farm->execute();
    $result_farm = $stmt_farm->get_result();
    if ($result_farm->num_rows > 0) {
        $farm_row = $result_farm->fetch_assoc();
        $farmID = $farm_row['farmID'];
    } else {
        // Insert farm if not found
        $sql_insert_farm = "INSERT INTO farm (farmname, location) VALUES (?, ?)";
        $stmt_insert_farm = $conn->prepare($sql_insert_farm);
        $stmt_insert_farm->bind_param('ss', $Farm_Name, $Farm_Location);
        if ($stmt_insert_farm->execute()) {
            $farmID = $conn->insert_id; // Get the inserted farmID
        } else {
            echo "Error: " . $conn->error;
            exit;
        }
    }

    // Step 2: Get the warehouse ID
    $sql_warehouse = "SELECT warehouseID FROM warehouse WHERE warehousename = ? AND location = ?";
    $stmt_warehouse = $conn->prepare($sql_warehouse);
    $stmt_warehouse->bind_param('ss', $Warehouse_Name, $Warehouse_Location);
    $stmt_warehouse->execute();
    $result_warehouse = $stmt_warehouse->get_result();
    if ($result_warehouse->num_rows > 0) {
        $warehouse_row = $result_warehouse->fetch_assoc();
        $warehouseID = $warehouse_row['warehouseID'];
    } else {
        // Insert warehouse if not found
        $sql_insert_warehouse = "INSERT INTO warehouse (warehousename, location) VALUES (?, ?)";
        $stmt_insert_warehouse = $conn->prepare($sql_insert_warehouse);
        $stmt_insert_warehouse->bind_param('ss', $Warehouse_Name, $Warehouse_Location);
        if ($stmt_insert_warehouse->execute()) {
            $warehouseID = $conn->insert_id; // Get the inserted warehouseID
        } else {
            echo "Error: " . $conn->error;
            exit;
        }
    }

    // Step 3: Get the distributor ID
    $sql_distributor = "SELECT distributorID FROM distributor WHERE address = ?";
    $stmt_distributor = $conn->prepare($sql_distributor);
    $stmt_distributor->bind_param('s', $Distributor_address);
    $stmt_distributor->execute();
    $result_distributor = $stmt_distributor->get_result();
    if ($result_distributor->num_rows > 0) {
        $distributor_row = $result_distributor->fetch_assoc();
        $distributorID = $distributor_row['distributorID'];
    } else {
        // Insert distributor if not found
        $sql_insert_distributor = "INSERT INTO distributor (address) VALUES (?)";
        $stmt_insert_distributor = $conn->prepare($sql_insert_distributor);
        $stmt_insert_distributor->bind_param('s', $Distributor_address);
        if ($stmt_insert_distributor->execute()) {
            $distributorID = $conn->insert_id; // Get the inserted distributorID
        } else {
            echo "Error: " . $conn->error;
            exit;
        }
    }

    // Step 4: Get the product ID
    $sql_product = "SELECT productID FROM product WHERE name = ?";
    $stmt_product = $conn->prepare($sql_product);
    $stmt_product->bind_param('s', $Product_Name);
    $stmt_product->execute();
    $result_product = $stmt_product->get_result();
    if ($result_product->num_rows > 0) {
        $product_row = $result_product->fetch_assoc();
        $productID = $product_row['productID'];
    } else {
        echo "Error: Product not found!";
        exit;
    }

    // Step 5: Get the lotnumber from harvestbatch table using farmID and productID
    $sql_lotnumber = "SELECT lotnumber FROM harvestbatch WHERE farmID = ? AND productID = ?";
    $stmt_lotnumber = $conn->prepare($sql_lotnumber);
    $stmt_lotnumber->bind_param('ii', $farmID, $productID);
    $stmt_lotnumber->execute();
    $result_lotnumber = $stmt_lotnumber->get_result();
    if ($result_lotnumber->num_rows > 0) {
        $lotnumber_row = $result_lotnumber->fetch_assoc();
        $lotnumber = $lotnumber_row['lotnumber'];
    } else {
        echo "Error: Lot number not found!";
        exit;
    }

    // Step 6: Check if the record already exists in batchtransfer
    $sql_check_transfer = "SELECT * FROM batchtransfer WHERE lotnumber = ? AND warehouseID = ?";
    $stmt_check_transfer = $conn->prepare($sql_check_transfer);
    $stmt_check_transfer->bind_param('ii', $lotnumber, $warehouseID);
    $stmt_check_transfer->execute();
    $result_check_transfer = $stmt_check_transfer->get_result();
    if ($result_check_transfer->num_rows > 0) {
        echo "This transfer already exists!";
        exit;
    }

    // Step 7: Insert into batchtransfer table
    $sql_insert_transfer = "INSERT INTO batchtransfer (lotnumber, warehouseID, transferdate) 
                            VALUES (?, ?, ?)";
    $stmt_insert_transfer = $conn->prepare($sql_insert_transfer);
    $stmt_insert_transfer->bind_param('iis', $lotnumber, $warehouseID, $Transfer_Date);

    if ($stmt_insert_transfer->execute()) {
        echo '<div class="alert alert-success" role="alert">Product transfer added successfully!</div>';
        header("refresh:0; url='https://localhost/Dbms_project/pages/warehouse_product_tracking.php?success=1'");
    } else {
        echo "Error: " . $conn->error;
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
          <h5 class="modal-title" id="addProductTrackingModalLabel">Add New Product Transfer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="addpd.php" method="POST">
            <div class="mb-3">
              <label for="Product_Name" class="form-label">Product Name</label>
              <input type="text" class="form-control" id="Product_Name" name="Product_Name" required>
            </div>
            <div class="mb-3">
              <label for="Farm_Name" class="form-label">Farm Name</label>
              <input type="text" class="form-control" id="Farm_Name" name="Farm_Name" required>
            </div>
            <div class="mb-3">
              <label for="Warehouse_Name" class="form-label">Warehouse Name</label>
              <input type="text" class="form-control" id="Warehouse_Name" name="Warehouse_Name" required>
            </div>
            <div class="mb-3">
              <label for="Farm_Location" class="form-label">Farm Location</label>
              <input type="text" class="form-control" id="Farm_Location" name="Farm_Location" required>
            </div>
            <div class="mb-3">
              <label for="Warehouse_Location" class="form-label">Warehouse Location</label>
              <input type="text" class="form-control" id="Warehouse_Location" name="Warehouse_Location" required>
            </div>
            <div class="mb-3">
              <label for="Distributor_address" class="form-label">Distributor Address</label>
              <input type="text" class="form-control" id="Distributor_address" name="Distributor_address" required>
            </div>
            <div class="mb-3">
              <label for="Transfer_Date" class="form-label">Transfer Date</label>
              <input type="date" class="form-control" id="Transfer_Date" name="Transfer_Date" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="submit">Save</button>
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
