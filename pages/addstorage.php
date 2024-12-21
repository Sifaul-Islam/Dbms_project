<?php
// Include your database connection
include "./db.php";  // Adjust the path as necessary

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from POST request (ensure data is sanitized before inserting)
    $productName = htmlspecialchars($_POST['product_name']);  // Product name
    $farmName = htmlspecialchars($_POST['farm_name']);  // Farm name
    $productionDate = $_POST['production_date'];  // Production date
    $expiryDate = $_POST['expiry_date'];  // Expiry date

    // Step 1: Insert into the `farm` table
    $farmQuery = "INSERT INTO farm (farmname) VALUES (?)";
    $farmStmt = $conn->prepare($farmQuery);
    $farmStmt->bind_param("s", $farmName);
    
    if ($farmStmt->execute()) {
        // Step 2: Insert into the `product` table
        $productQuery = "INSERT INTO product (name) VALUES (?)";
        $productStmt = $conn->prepare($productQuery);
        $productStmt->bind_param("s", $productName);

        if ($productStmt->execute()) {
            // Retrieve the last inserted IDs for product and farm
            $farmID = $conn->insert_id;
            $productID = $conn->insert_id;

            // Step 3: Insert into the `harvestbatch` table
            $lotnumber = "HB" . rand(1000, 9999);  // Generate a random lot number (can be changed as needed)
            $harvestQuery = "INSERT INTO harvestbatch (lotnumber, farmID, productiondate, expirydate, productID) 
                             VALUES (?, ?, ?, ?, ?)";
            $harvestStmt = $conn->prepare($harvestQuery);
            $harvestStmt->bind_param("siiss", $lotnumber, $farmID, $productionDate, $expiryDate, $productID);

            if ($harvestStmt->execute()) {
                echo "Data inserted successfully!";
            } else {
                echo "Error inserting data into harvestbatch: " . $conn->error;
            }
        } else {
            echo "Error inserting data into product: " . $conn->error;
        }
    } else {
        echo "Error inserting data into farm: " . $conn->error;
    }

    // Close prepared statements
    $farmStmt->close();
    $productStmt->close();
    $harvestStmt->close();
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data</title>
</head>
<body>
    <form action="your_php_script.php" method="POST">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required><br><br>

        <label for="farm_name">Farm Name:</label>
        <input type="text" id="farm_name" name="farm_name" required><br><br>

        <label for="production_date">Production Date:</label>
        <input type="date" id="production_date" name="production_date" required><br><br>

        <label for="expiry_date">Expiry Date:</label>
        <input type="date" id="expiry_date" name="expiry_date" required><br><br>

        <input type="submit" value="Insert Data">
    </form>
</body>
</html>
