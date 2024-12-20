<!-- read -->

<?php 

include "./db.php";

$sql = "SELECT * FROM `distribution`";

$result = $conn->query($sql);

?>

 <!--delete -->
 <?php
if (isset($_GET['Product_Name'])) {
    $Product_Name = $_GET['Product_Name'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'safe_food_traceability');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to delete the record
    $sql = "DELETE FROM distribution WHERE Product_Name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $Product_Name);

    if ($stmt->execute()) {
        header("Location: distributors.php?success=1");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "";
}
?>



<!DOCTYPE html>
<html lang="bn">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>ড্যাশবোর্ড - বিতরণকারী</title>

  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/nucleo/2.0.6/css/nucleo-icons.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="#" target="_blank">
                <img src="kng1.png" class="navbar-brand-img h-100" alt="main_logo">
            </a>
        </div>
    
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main" style="height: auto;">
            <ul class="navbar-nav">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link active" href="../Know Your Grass/distributors.html">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-tachometer-alt text-primary"></i>
                        </div>
                        <span class="nav-link-text ms-1">ড্যাশবোর্ড</span>
                    </a>
                </li>
    
                <!-- Inventory Management -->
                <!-- <li class="nav-item">
                    <a class="nav-link" href="../pages/বিতরণকারী গুদাম ব্যবস্থাপনা.html">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-warehouse text-info"></i>
                        </div>
                        <span class="nav-link-text ms-1">গুদাম ব্যবস্থাপনা</span>
                    </a>
                </li> -->
    
                <!-- Storage Conditions -->
                <!-- <li class="nav-item">
                    <a class="nav-link" href="..//pages/বিতরণকারী সংরক্ষণ অবস্থা.html">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-thermometer-half text-primary"></i>
                        </div>
                        <span class="nav-link-text ms-1">সংরক্ষণ অবস্থা</span>
                    </a>
                </li> -->
    
                <!-- Quality Control -->
                <!-- <li class="nav-item">
                    <a class="nav-link" href="../pages/বিতরণকারী গুণমান যাচাইকরণ.html">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-check-circle text-danger"></i>
                        </div>
                        <span class="nav-link-text ms-1">গুণমান যাচাইকরণ</span>
                    </a>
                </li> -->

                <!-- Product Tracking -->
                <li class="nav-item">
                    <a class="nav-link" href="../pages/বিতরণকারী পণ্য ট্র্যাকিং.php">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-route text-warning"></i>
                        </div>
                        <span class="nav-link-text ms-1">পণ্য ট্র্যাকিং</span>
                    </a>
                </li>
    
                <!-- Data Reports -->
                <li class="nav-item">
                    <a class="nav-link" href="../pages/বিতরণকারী প্রতিবেদন এবং বিশ্লেষণ.php">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-chart-bar text-secondary"></i>
                        </div>
                        <span class="nav-link-text ms-1">প্রতিবেদন এবং বিশ্লেষণ</span>
                <!-- Logout -->
                <li class="nav-item">
                    <a class="nav-link" href="../Know Your Grass/login.html">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                             <i class="fas fa-sign-out-alt text-danger"></i>
                        </div>
                        <span class="nav-link-text ms-1">লগ আউট</span>                        
                    </a>
                </li>
              </li>
            </ul>
        </div>
    </aside>
    

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">পৃষ্ঠা</a></li>
                  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">ড্যাশবোর্ড</li>
                </ol>
                <h6 class="font-weight-bolder mb-0">বিতরণকারী</h6>
              </nav>
            
              <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                  <div class="input-group">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" placeholder="এখানে টাইপ করুন...">
                  </div>
                </div>
                <ul class="navbar-nav justify-content-end">
                  <li class="nav-item d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                      <i class="fa fa-user me-sm-1"></i>
                      <span class="d-sm-inline d-none">প্রোফাইল</span>
                    </a>
                  </li>
                  <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                      <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                      </div>
                    </a>
                  </li>
                </ul>
            </div>
            </div>
          </nav>
          
          <div class="container-fluid py-4">
            <!-- Inventory Status Cards -->
            <div class="row">
              <div class="col-lg-4 col-md-6 col-12 mb-4">
                <div class="card">
                  <div class="card-body p-3">
                    <div class="d-flex">
                      <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                        <i class="fas fa-boxes text-lg text-white opacity-10"></i>
                      </div>
                      <div class="ms-3">
                        <p class="text-sm mb-0 text-capitalize">মোট জিনিসপত্র</p>
                        <h5 class="font-weight-bolder mb-0">১,৮০০ আইটেম</h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                  <div class="card-body p-3">
                    <div class="d-flex">
                      <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                        <i class="fas fa-clock"></i> <!-- Pending Icon -->
                      </div>
                      <div class="ms-3">
                        <p class="text-sm mb-0 text-capitalize">মজুদে থাকা পণ্য</p>
                        <h5 class="font-weight-bolder mb-0">৮০০</h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
    
              <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card">
                  <div class="card-body p-3">
                    <div class="d-flex">
                      <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                        <i class="fas fa-check-circle text-lg text-white opacity-10"></i>
                      </div>
                      <div class="ms-3">
                        <p class="text-sm mb-0 text-capitalize">বিতরণ করা আইটেম</p>
                        <h5 class="font-weight-bolder mb-0">১০০০</h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
                        <!-- Product Tracking Table -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card mb-4">
                                    <div class="card-header pb-0 d-flex justify-content-between">
                                        <h6>পণ্যের তালিকা</h6>
                                        <a class="btn btn-sm btn-success" href="adddis.php">নতুন পণ্য যোগ করুন</a>
                                    </div>
                                    
                                    <div class="card-body px-0 pt-0 pb-2">
                                        <div class="table-responsive p-0">
                                            <table class="table align-items-center mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">পণ্যের নাম</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">স্টক পরিমাণ</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">বিতরণ পরিমাণ</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">দোকানের নাম</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">অবস্থা</th>
                                                        
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">তারিখ</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">অবস্থা পরিবর্তন</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>

        <tr>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Product_Name']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Stock_Quantity']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Disbursement_Amount']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center "><?php echo $row['Store_Name']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center " ><?php echo $row['Status']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Date']; ?></td>

        <td class="text-center">
        <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
        
        

        <a class="btn btn-sm btn-primary edit-btn" href="updatedis.php?Product_Name=<?php echo $row['Product_Name']; ?>">
            সম্পাদনা
        </a>
        <button 
            class="btn btn-danger btn-sm text-center" 
             
            onclick="confirmDelete('<?php echo $row['Product_Name']; ?>')">
            মুছে ফেলুন
        </button>
    

        </td>


        </tr>                       

<?php   }
}
$conn->close();

?>              
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
          
            <!-- Inventory Bar Chart -->
            <div class="row mt-4">
              <div class="col-lg-6">
                <div class="card h-100">
                  <div class="card-header pb-0">
                    <h6>জিনিসপত্রের সংরক্ষণ স্তরের বার চার্ট</h6>
                  </div>
                  <div class="card-body p-3">
                    <canvas id="inventoryBarChart" height="300"></canvas>
                  </div>
                </div>
              </div>

              <!-- Temperature and Humidity Line Chart -->
              <div class="col-lg-6">
                <div class="card h-100">
                  <div class="card-header pb-0">
                    <h6>তাপমাত্রা এবং আর্দ্রতার চার্ট</h6>
                  </div>
                  <div class="card-body p-3">
                    <canvas id="temperatureHumidityChart" height="300"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </main>
 
 
    
    

  <!-- Delete Product Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">পণ্য মুছে ফেলুন</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>আপনি কি নিশ্চিত যে আপনি এই আইটেমটি মুছে ফেলতে চান?</p>
                <p id="deleteProductMessage" class="text-danger"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
                <a id="confirmDeleteButton" class="btn btn-sm btn-danger" href="#">মুছে ফেলুন</a>
            </div>
        </div>
    </div>
</div>

<!-- Script to handle deletion -->
<script>
    // Function to set up delete confirmation
    function confirmDelete(Product_Name, productName) {
        // Set the confirmation message
        // document.getElementById('deleteProductMessage').textContent = `আইটেম: ${productName} (বারকোড: ${Product_Name})`;
        
        // Set the delete link with the correct Product_Name
        const deleteUrl = `distributors.php?Product_Name=${Product_Name}`;
        document.getElementById('confirmDeleteButton').setAttribute('href', deleteUrl);

        // Show the modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteProductModal'));
        deleteModal.show();
    }
</script>
  <!-- JS Scripts -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.1.0"></script>
  <script>
    function populateEditModal(name, rfid, status, source, date) {
        document.getElementById('editTrackingProductName').value = name;
        document.getElementById('editTrackingRFID').value = rfid;
        document.getElementById('editTrackingStatus').value = status;
        document.getElementById('editTrackingSource').value = source;
        document.getElementById('editTrackingDate').value = date;
    }

    // Product Tracking Pie Chart
    var ctxProductTrackingChart = document.getElementById('productTrackingChart').getContext('2d');
    new Chart(ctxProductTrackingChart, {
      type: 'pie',
      data: {
        labels: ['আসছে', 'গুদামে', 'বিতরণ করা হয়েছে'],
        datasets: [{
          data: [30, 50, 20],
          backgroundColor: [
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)'
          ],
          borderColor: [
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true
      }
    });
</script>


  <script>
    // Inventory Bar Chart
    var ctxInventoryBar = document.getElementById('inventoryBarChart').getContext('2d');
    new Chart(ctxInventoryBar, {
      type: 'bar',
      data: {
        labels: ['Stored', 'In Transit', 'Awaiting Inspection'],
        datasets: [{
          label: 'Inventory Levels',
          data: [55, 25, 20],
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    // Temperature and Humidity Line Chart
    var ctxTempHumidity = document.getElementById('temperatureHumidityChart').getContext('2d');
    new Chart(ctxTempHumidity, {
      type: 'line',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
        datasets: [
          {
            label: 'Temperature (°C)',
            data: [7, 8, 9, 10, 11, 9],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
          },
          {
            label: 'Humidity (%)',
            data: [60, 62, 58, 57, 56, 59],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
          }
        ]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.1.0"></script>
</body>

</html>