<?php 

include "./db.php";

// SQL query to join tables and fetch required data
$sql = "
    SELECT 
    bp.barcode AS `Barcode`,
    bp.lotnumber AS `Lot Number`,
    p.name AS `Product Name`,
    COALESCE(sd.quantity, 0) AS `Total Number of Batches`,
    pk.quantity AS `Package Quantity`,
    bp.number_of_total_package AS `Total Number of Packages`,
    bp.number_of_damaged_package AS `Number of Damaged Packages`
FROM 
    batchpackagedetails bp
JOIN 
    harvestbatch hb ON bp.lotnumber = hb.lotnumber
JOIN 
    product p ON hb.productID = p.productID
LEFT JOIN 
    `seed distribution batch` sd ON bp.lotnumber = sd.`lot number`
LEFT JOIN 
    package pk ON bp.barcode = pk.barcode;

";

$result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>ড্যাশবোর্ড - Agri Officer</title>

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
            <br><span class="ms-1 font-weight-bold">Agri Officer</span>
        </a>
    </div>

    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="../Know Your Grass/agri_officer_dashboard.html">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-tachometer-alt text-primary"></i>
                    </div>
                    <span class="nav-link-text ms-1">কৃষি অফিসার ড্যাশবোর্ড</span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="../pages/agri_officer_add_product.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-seedling text-warning"></i>
                    </div>
                    <span class="nav-link-text ms-1">পণ্যের তথ্য যোগ</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../pages/track_product_update.html">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-truck text-info"></i>
                    </div>
                    <span class="nav-link-text ms-1">পণ্য ট্র্যাক</span>
                </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../pages/agri_officer_harvestBatch_details.php">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="fas fa-exclamation-triangle text-danger"></i>
                  </div>
                  <span class="nav-link-text ms-1">ব্যাচের বিবরণ যোগ</span>
              </a>
          </li>

            <li class="nav-item">
                <a class="nav-link active" href="../pages/agri_add_affected_batches_details.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-exclamation-triangle text-danger"></i>
                    </div>
                    <span class="nav-link-text ms-1">প্রভাবিত ব্যাচের বিবরণ যোগ</span>
                </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="../Know Your Grass/login.html">
                  <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                       <i class="fas fa-sign-out-alt text-danger"></i>
                  </div>
                  <span class="nav-link-text ms-1">লগ আউট</span>                        
              </a>
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
                  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">কৃষি অফিসার</li>
              </ol>
              <h6 class="font-weight-bolder mb-0">প্রভাবিত ব্যাচের বিবরণ যোগ</h6>
          </nav>
          <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
              <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group">
                  <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                  <input type="text" class="form-control" placeholder="এখানে টাইপ করুন...">
                </div>
              </div>
              
      </div>
  </nav>

  <div class="container-fluid py-4">
    <!-- Overview Section -->
    <div class="row">
        <!-- Section 1 -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="fas fa-shopping-cart" style="font-size: 24px; color: white;"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-sm mb-0 text-capitalize">মোট ব্যাচ</p>
                            <h5 class="font-weight-bolder mb-0">৫০০০</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Section 2 -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex">
                        <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                            <i class="fas fa-times-circle" style="font-size: 24px; color: white;"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-sm mb-0 text-capitalize">ক্ষতিগ্রস্ত ব্যাচ</p>
                            <h5 class="font-weight-bolder mb-0">৩০০০</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Section 3 -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="fas fa-shopping-cart" style="font-size: 24px; color: white;"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-sm mb-0 text-capitalize">মোট প্যাকেজ</p>
                            <h5 class="font-weight-bolder mb-0">৭০০০</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Section 4 -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body p-2">
                    <div class="d-flex">
                        <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                            <i class="fas fa-times-circle" style="font-size: 24px; color: white;"></i>
                        </div>
                        <div class="ms-3">
                            <p class="text-sm mb-0 text-capitalize">ক্ষতিগ্রস্ত প্যাকেজ</p>
                            <h5 class="font-weight-bolder mb-0">৩০০০</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
          <!-- <div class="col-lg-4 col-md-6 col-12 mb-4">
              <div class="card">
                  <div class="card-body p-3">
                      <div class="d-flex">
                          <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                              <i class="ni ni-tag text-lg text-white opacity-10"></i>
                              <i class="fas fa-warehouse text-4xl text-white opacity-10" style="font-size: 24px; color: white;"></i>
                          </div>
                          <div class="ms-3">
                              <p class="text-sm mb-0 text-capitalize">মজুদে থাকা পণ্য</p>
                              <h5 class="font-weight-bolder mb-0">২০০০</h5>
                          </div>
                      </div>
                  </div>
              </div>
          </div> -->
      </div>
<!-- Product Tracking Table -->
<div class="row">
<div class="col-12">
  <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between">
          <h6>পণ্যের তালিকা</h6>
          <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addProductTrackingModal">নতুন পণ্য যোগ করুন</button>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                  <thead>
                      <tr>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder">বারকোড</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder">লটনম্বর</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder">পণ্যের নাম</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder">মোট ব্যাচের সংখ্যা </th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">প্যাকেজের পরিমাণ</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder">মোট প্যাকেজের সংখ্যা</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">ক্ষতিগ্রস্ত প্যাকেজের সংখ্যা</th>
                          <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">অবস্থা পরিবর্তন</th> -->
                      </tr>
                  </thead>
                  <tbody>
                  <?php

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>

        <tr>
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Barcode']; ?></td>
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Lot Number']; ?></td>
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Product Name']; ?></td>
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Total Number of Batches']; ?></td>
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Package Quantity']; ?></td>
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Total Number of Packages']; ?></td>
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Number of Damaged Packages']; ?></td>
        


        <td class="text-center">
        <div style="display: flex; justify-content: center; align-items: center; gap: 10px;"></div>

        <td>
          <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal" >সম্পাদনা</button>
          <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProductModal" >মুছে ফেলুন</button>
        </td>

        </tr>                       

<?php   }
}
$conn->close(); 
?>  
                      <!-- Add more rows as needed -->
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>
</div>

   <!-- JS Scripts -->
   <script src="../assets/js/core/popper.min.js"></script>
   <script src="../assets/js/core/bootstrap.min.js"></script>
   <script src="../assets/js/plugins/chartjs.min.js"></script>
   <script src="../assets/js/soft-ui-dashboard.min.js?v=1.1.0"></script>
   <script>
       // Temperature and Humidity Multi-Bar Chart
       var ctxTempHumidityChart = document.getElementById('tempHumidityChart').getContext('2d');
       var tempHumidityChart = new Chart(ctxTempHumidityChart, {
           type: 'bar',
           data: {
               labels: ['Room A', 'Room B', 'Room C'],
               datasets: [
                   {
                       label: 'তাপমাত্রা (°C)',
                       data: [8, 10, 12],
                       backgroundColor: 'rgba(54, 162, 235, 0.6)',
                       borderColor: 'rgba(54, 162, 235, 1)',
                       borderWidth: 1
                   },
                   {
                       label: 'আর্দ্রতা (%)',
                       data: [65, 70, 75],
                       backgroundColor: 'rgba(255, 206, 86, 0.6)',
                       borderColor: 'rgba(255, 206, 86, 1)',
                       borderWidth: 1
                   }
               ]
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

       function filterTempHumidityChart() {
           var startDate = document.getElementById('tempHumidityStartDate').value;
           var endDate = document.getElementById('tempHumidityEndDate').value;
           // Logic to filter chart based on date range
           alert('Filtering Temp and Humidity chart from ' + startDate + ' to ' + endDate);
       }

       // Product Quality Status Pie Chart
       var ctxProductQualityPieChart = document.getElementById('productQualityPieChart').getContext('2d');
       new Chart(ctxProductQualityPieChart, {
           type: 'pie',
           data: {
               labels: ['প্যাকেজ', 'পরিবহন', 'ইনভেন্টরি '],
               datasets: [{
                   data: [50, 30, 20],
                   backgroundColor: [
                       'rgba(75, 192, 192, 0.6)',
                       'rgba(255, 205, 86, 0.6)',
                       'rgba(255, 99, 132, 0.6)'
                   ],
                   borderColor: [
                       'rgba(75, 192, 192, 1)',
                       'rgba(255, 205, 86, 1)',
                       'rgba(255, 99, 132, 1)'
                   ],
                   borderWidth: 1
               }]
           },
           options: {
               responsive: true
           }
       });

       // Product Entry and Distribution Over Time Chart
       var ctxEntryDistributionChart = document.getElementById('entryDistributionChart').getContext('2d');
       new Chart(ctxEntryDistributionChart, {
           type: 'line',
           data: {
               labels: ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন'],
               datasets: [
                   {
                       label: 'পণ্য প্রবেশ',
                       data: [500, 700, 800, 600, 750, 900],
                       borderColor: 'rgba(54, 162, 235, 1)',
                       backgroundColor: 'rgba(54, 162, 235, 0.2)',
                       borderWidth: 2
                   },
                   {
                       label: 'পণ্য বিতরণ',
                       data: [300, 500, 700, 400, 650, 800],
                       borderColor: 'rgba(255, 99, 132, 1)',
                       backgroundColor: 'rgba(255, 99, 132, 0.2)',
                       borderWidth: 2
                   }
               ]
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

       function filterEntryDistributionChart() {
           var startDate = document.getElementById('entryDistributionStartDate').value;
           var endDate = document.getElementById('entryDistributionEndDate').value;
           // Logic to filter chart based on date range
           alert('Filtering Entry and Distribution chart from ' + startDate + ' to ' + endDate);
       }

       function exportReport(type) {
           if (type === 'pdf') {
               alert('Exporting report as PDF');
           } else if (type === 'excel') {
               alert('Exporting report as Excel');
           }
       }
       
   </script>
      <!-- Graphs and Analytics Section -->
      <div class="row mt-4">
          <!-- Temperature and Humidity Overview Chart -->
          <div class="col-lg-6">
              <div class="card h-100">
                  <div class="card-header pb-0">
                      <h6>পণ্যের অবস্থা</h6>
                      <!-- <div class="d-flex justify-content-end">
                          <input type="date" id="tempHumidityEndDate" class="form-control form-control-sm mx-1" />
                          <button class="btn btn-sm btn-primary" onclick="filterTempHumidityChart()">ফিল্টার করুন</button>
                      </div> -->
                  </div>
                  <div class="card-body p-3">
                      <canvas id="tempHumidityChart" height="300"></canvas>
                  </div>
              </div>
          </div>
          
          <!-- Product Quality Status Pie Chart -->
          <div class="col-lg-6">
              <div class="card h-100">
                  <div class="card-header pb-0">
                      <h6>ক্ষতিগ্রস্ত পণ্যের পরিমাণ</h6>
                  </div>
                  <div class="card-body p-3">
                      <canvas id="productQualityPieChart" height="300"></canvas>
                  </div>
              </div>
          </div>
      </div>

<!-- Product Entry and Distribution Over Time Chart -->
<div class="row mt-2">
          
<div class="card h-30">
  <div class="card-header pb-0">
      <div class="card-header pb-0">
          <h6>প্রভাবিত ব্যাচের স্থিতি</h6>
        </div>
  </div>
  <div class="card-body p-3">
      <canvas id="batchStatusChart" width="400" height="200"></canvas>
  </div>
</div>
</div>
</div>
<!-- Include Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Initializing the Batch Status Chart
const ctx = document.getElementById('batchStatusChart').getContext('2d');
const batchStatusChart = new Chart(ctx, {
type: 'bar',
data: {
labels: ['খামার', 'প্রসেসিং', 'স্টোরেজ', 'বিতরণ'], // Labels for stages
datasets: [{
label: 'প্রভাবিত ব্যাচের সংখ্যা',
data: [5, 10, 3, 8], // Sample data for affected batches at each stage
backgroundColor: ['#28a745', '#17a2b8', '#ffc107', '#dc3545'],
borderColor: ['#28a745', '#17a2b8', '#ffc107', '#dc3545'],
borderWidth: 1
}]
},
options: {
responsive: true,
plugins: {
legend: {
display: true,
position: 'top'
}
},
scales: {
y: {
beginAtZero: true,
title: {
display: true,
text: 'প্রভাবিত ব্যাচের সংখ্যা'
}
},
x: {
title: {
display: true,
text: 'ধাপসমূহ'
}
}
}
}
});
</script>

      <!-- Product Distribution Report -->
      <div class="row mt-4">
          <div class="col-12">
              <div class="card h-100">
                  <div class="card-header pb-0 d-flex justify-content-between">
                      <h6>বিতরণ প্রতিবেদন</h6>
                      <button class="btn btn-sm btn-success" onclick="exportReport('pdf')">PDF হিসেবে ডাউনলোড করুন</button>
                      <button class="btn btn-sm btn-success ms-2" onclick="exportReport('excel')">Excel হিসেবে ডাউনলোড করুন</button>
                  </div>
                  <div class="card-body px-0 pt-0 pb-2">
                      <div class="table-responsive p-0">
                          <table class="table align-items-center mb-0">
                              <thead>
                                  <tr>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder">পণ্যের নাম</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder">বিতরণ সংখ্যা</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder">তারিখ</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td class="align-middle">
                                          <span class="text-xs font-weight-bold">আপেল</span>
                                      </td>
                                      <td class="align-middle">
                                          <span class="text-xs font-weight-bold">১০০০</span>
                                      </td>
                                      <td class="align-middle">
                                          <span class="text-xs font-weight-bold">২০/১১/২০২৪</span>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td class="align-middle">
                                          <span class="text-xs font-weight-bold">আলু</span>
                                      </td>
                                      <td class="align-middle">
                                          <span class="text-xs font-weight-bold">৮০০</span>
                                      </td>
                                      <td class="align-middle">
                                          <span class="text-xs font-weight-bold">২১/১১/২০২৪</span>
                                      </td>
                                  </tr>
                                  <!-- Add more rows as needed -->
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>




  <!-- Add Product Tracking Modal -->
  <div class="modal fade" id="addProductTrackingModal" tabindex="-1" aria-labelledby="addProductTrackingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductTrackingModalLabel">নতুন পণ্য যোগ করুন</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form>
                <div class="mb-3">
                    <label for="editProductName" class="form-label">বারকোড</label>
                    <input type="text" class="form-control" id="editProductName">
                </div>
                <div class="mb-3">
                    <label for="editProductStock" class="form-label">লটনম্বর</label>
                    <input type="text" class="form-control" id="editProductStock">
                </div>
                <div class="mb-3">
                    <label for="editProductStock" class="form-label">পণ্যের নাম</label>
                    <input type="text" class="form-control" id="editProductStock">
                </div>
                <!-- <div class="mb-3">
                    <label for="editProductCondition" class="form-label">প্যাকেজিং তারিখ</label>
                    <select class="form-control" id="editProductCondition">
                        <option value="ভাল">ভাল</option>
                        <option value="মধ্যম">মধ্যম</option>
                        <option value="খারাপ">খারাপ</option>
                    </select>
                </div> -->
                <div class="mb-3">
                    <label for="editProductHumidity" class="form-label">মোট ব্যাচের সংখ্যা </label>
                    <input type="number" class="form-control" id="editProductHumidity">
                </div>
                <div class="mb-3">
                    <label for="editProductTemperature" class="form-label">ক্ষতিগ্রস্ত ব্যাচের সংখ্যা</label>
                    <input type="number" class="form-control" id="editProductTemperature">
                </div>
                <div class="mb-3">
                    <label for="editProductTemperature" class="form-label">মোট প্যাকেজের সংখ্যা</label>
                    <input type="number" class="form-control" id="editProductTemperature">
                </div>
                <div class="mb-3">
                  <label for="editProductTemperature" class="form-label">ক্ষতিগ্রস্ত প্যাকেজের সংখ্যা</label>
                  <input type="number" class="form-control" id="editProductTemperature">
              </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
                <button type="button" class="btn btn-primary">সংরক্ষণ করুন</button>
            </div>
        </div>
    </div>
</div>    
  <!-- Delete Product Modal -->
  <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">পণ্য মুছে ফেলুন</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="deleteProductMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
                <button type="button" class="btn btn-danger">মুছে ফেলুন</button>
            </div>
        </div>
    </div>
</div> 

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">পণ্য সম্পাদনা করুন</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">বারকোড</label>
                            <input type="text" class="form-control" id="editProductName">
                        </div>
                        <div class="mb-3">
                            <label for="editProductStock" class="form-label">লটনম্বর</label>
                            <input type="text" class="form-control" id="editProductStock">
                        </div>
                        <div class="mb-3">
                            <label for="editProductStock" class="form-label">পণ্যের নাম</label>
                            <input type="text" class="form-control" id="editProductStock">
                        </div>
                        <!-- <div class="mb-3">
                            <label for="editProductCondition" class="form-label">প্যাকেজিং তারিখ</label>
                            <select class="form-control" id="editProductCondition">
                                <option value="ভাল">ভাল</option>
                                <option value="মধ্যম">মধ্যম</option>
                                <option value="খারাপ">খারাপ</option>
                            </select>
                        </div> -->
                        <div class="mb-3">
                            <label for="editProductHumidity" class="form-label">মোট ব্যাচের সংখ্যা </label>
                            <input type="number" class="form-control" id="editProductHumidity">
                        </div>
                        <div class="mb-3">
                            <label for="editProductTemperature" class="form-label">ক্ষতিগ্রস্ত ব্যাচের সংখ্যা</label>
                            <input type="number" class="form-control" id="editProductTemperature">
                        </div>
                        <div class="mb-3">
                            <label for="editProductTemperature" class="form-label">মোট প্যাকেজের সংখ্যা</label>
                            <input type="number" class="form-control" id="editProductTemperature">
                        </div>
                        <div class="mb-3">
                          <label for="editProductTemperature" class="form-label">ক্ষতিগ্রস্ত প্যাকেজের সংখ্যা</label>
                          <input type="number" class="form-control" id="editProductTemperature">
                      </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
                    <button type="button" class="btn btn-primary">সংরক্ষণ করুন</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Product Modal -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductModalLabel">পণ্য মুছে ফেলুন</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="deleteProductMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
                    <button type="button" class="btn btn-danger">মুছে ফেলুন</button>
                </div>
            </div>
        </div>
    </div>
<!-- JS Scripts -->
<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>
<script src="../assets/js/plugins/chartjs.min.js"></script>
<script src="../assets/js/soft-ui-dashboard.min.js?v=1.1.0"></script>
<script>
    // Temperature and Humidity Multi-Bar Chart
    var ctxTempHumidityChart = document.getElementById('tempHumidityChart').getContext('2d');
    var tempHumidityChart = new Chart(ctxTempHumidityChart, {
        type: 'bar',
        data: {
            labels: ['আপেল', 'আলু', 'দুধ'],
            datasets: [
                {
                    label: 'ক্ষতির পরিমাণ(টন)',
                    data: [8, 10, 12],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'উৎপাদনের পরিমাণ(টন)',
                    data: [65, 70, 75],
                    backgroundColor: 'rgba(255, 206, 86, 0.6)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                }
            ]
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

    function filterTempHumidityChart() {
        var startDate = document.getElementById('tempHumidityStartDate').value;
        var endDate = document.getElementById('tempHumidityEndDate').value;
        // Logic to filter chart based on date range
        alert('Filtering Temp and Humidity chart from ' + startDate + ' to ' + endDate);
    }

    // Product Quality Status Pie Chart
    var ctxProductQualityPieChart = document.getElementById('productQualityPieChart').getContext('2d');
    new Chart(ctxProductQualityPieChart, {
        type: 'pie',
        data: {
            labels: ['প্যাকেজ', 'পরিবহন', 'ইনভেন্টরি '],
            datasets: [{
                data: [50, 30, 20],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 205, 86, 0.6)',
                    'rgba(255, 99, 132, 0.6)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

    // Product Entry and Distribution Over Time Chart
    var ctxEntryDistributionChart = document.getElementById('entryDistributionChart').getContext('2d');
    new Chart(ctxEntryDistributionChart, {
        type: 'line',
        data: {
            labels: ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন'],
            datasets: [
                {
                    label: 'পণ্য প্রবেশ',
                    data: [500, 700, 800, 600, 750, 900],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 2
                },
                {
                    label: 'পণ্য বিতরণ',
                    data: [300, 500, 700, 400, 650, 800],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2
                }
            ]
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

    function filterEntryDistributionChart() {
        var startDate = document.getElementById('entryDistributionStartDate').value;
        var endDate = document.getElementById('entryDistributionEndDate').value;
        // Logic to filter chart based on date range
        alert('Filtering Entry and Distribution chart from ' + startDate + ' to ' + endDate);
    }

    function exportReport(type) {
        if (type === 'pdf') {
            alert('Exporting report as PDF');
        } else if (type === 'excel') {
            alert('Exporting report as Excel');
        }
    }
</script>
</body>

</html>
