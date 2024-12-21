<?php
// Database connection
include "db.php";

// Check if 'Storage_Room' is passed in the URL and fetch the data from the database
if (isset($_GET['Storage_Room'])) {
    $Storage_Room = $conn->real_escape_string($_GET['Storage_Room']); // Sanitize input to prevent SQL injection

    // SQL query to fetch data for the specified Storage_Room
    $sql = "
        SELECT 
            s.roomNo AS `Storage_Room`,
            GROUP_CONCAT(DISTINCT p.name ORDER BY p.name ASC) AS `Products`,
            s.temperature AS `Temperature`,
            s.humidity AS `Humidity`,
            MAX(s.timestamp) AS `Time_Stamp`,
            s.oxygen AS `Oxygen`,
            s.`light intensity` AS `Light_Intensity`
        FROM 
            sensor s
        JOIN 
            warehouse w ON s.warehouseID = w.warehouseID
        JOIN 
            harvestbatch hb ON w.lotnumber = hb.lotnumber
        JOIN 
            product p ON hb.productID = p.productID
        WHERE
            s.roomNo = '$Storage_Room'
        GROUP BY 
            s.roomNo
        LIMIT 1
    ";

    // Execute the query and fetch data
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Storage_Room = htmlspecialchars($row['Storage_Room']);
        $Products = htmlspecialchars($row['Products']);
        $Temperature = htmlspecialchars($row['Temperature']);
        $Humidity = htmlspecialchars($row['Humidity']);
        $Time_Stamp = htmlspecialchars($row['Time_Stamp']);
        $Oxygen = htmlspecialchars($row['Oxygen']);
        $Light_Intensity = htmlspecialchars($row['Light_Intensity']);
    } else {
        echo '<div class="alert alert-danger" role="alert">No record found for the specified room number.</div>';
        exit;
    }
}

// Handle form submission for updating sensor data
if (isset($_POST['update'])) {
    $Storage_Room = $conn->real_escape_string($_POST['Storage_Room']);
    $Temperature = $conn->real_escape_string($_POST['Temperature']);
    $Humidity = $conn->real_escape_string($_POST['Humidity']);
    $Oxygen = $conn->real_escape_string($_POST['oxygen']);
    $Light_Intensity = $conn->real_escape_string($_POST['light_intensity']);

    // Update query
    $update_sql = "
        UPDATE sensor 
        SET oxygen = '$Oxygen', 
            `light intensity` = '$Light_Intensity', 
            Temperature = '$Temperature', 
            Humidity = '$Humidity' 
        WHERE roomNo = '$Storage_Room'
    ";

    // Execute the update query
    if ($conn->query($update_sql) === TRUE) {
        echo '<div class="alert alert-success" role="alert">Sensor data updated successfully.</div>';
        header("refresh:1; url=warehouse_storage.php");
        exit;
    } else {
        echo '<div class="alert alert-danger" role="alert">Error updating sensor data: ' . $conn->error . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storage Room Update</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/nucleo/2.0.6/css/nucleo-icons.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/nucleo/2.0.6/css/nucleo-icons.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
</head>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Storage Room Update Form</h2>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Update Storage Room Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="Storage_Room" class="form-label">সংরক্ষণ কক্ষ</label>
                            <input type="text" class="form-control" name="Storage_Room" id="Storage_Room" value="<?php echo $Storage_Room; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="Products" class="form-label">পণ্যসমূহ</label>
                            <input type="text" class="form-control" name="Products" id="Products" value="<?php echo $Products; ?>" >
                        </div>
                        <div class="mb-3">
                            <label for="Temperature" class="form-label">তাপমাত্রা (°C)</label>
                            <input type="text"  class="form-control" name="Temperature" id="Temperature" value="<?php echo $Temperature; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Humidity" class="form-label">আর্দ্রতা (%)</label>
                            <input type="text"  class="form-control" name="Humidity" id="Humidity" value="<?php echo $Humidity; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="oxygen" class="form-label">অক্সিজেন</label>
                            <input type="text" class="form-control" name="oxygen" id="oxygen" value="<?php echo $Oxygen; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="light_intensity" class="form-label">আলোর তীব্রতা</label>
                            <input type="text" class="form-control" name="light_intensity" id="light_intensity" value="<?php echo $Light_Intensity; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="timestamp" class="form-label">সময় স্ট্যাম্প</label>
                            <input type="text" class="form-control" name="timestamp" id="timestamp" value="<?php echo $Time_Stamp; ?>" readonly>
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
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Auto-open Modal -->
    <?php if (isset($_GET['Storage_Room'])): ?>
    <script>
        const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
        editModal.show();
    </script>
    <?php endif; ?>
</body>
</html>
