<?php 

include "./db.php";

// SQL query to join tables and fetch required data
$sql = "
   SELECT 
    product.name AS ProductName,
    sample.state AS State,
    sample.result AS Result
FROM 
    product
JOIN 
    sample
ON 
    product.productID = sample.productID;




";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>মান নিয়ন্ত্রণ প্রতিবেদন - Know Your Grass</title>

  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/nucleo/2.0.6/css/nucleo-icons.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
  <style>
    /* Prevent the sidebar (sidenav) from scrolling */
    #sidenav-main {
      overflow: hidden !important; /* No scrollbars for sidenav */
    }

    /* Make sure the page content can scroll */
    body {
      overflow-y: auto; /* Allow the page to scroll vertically */
    }

    .main-content {
      height: 100vh; /* Ensure the main content takes up the full viewport height */
      overflow-y: auto; /* Enable vertical scrolling for the main content */
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="#" target="_blank">
        <img src="../Know Your Grass/kng1.png" class="navbar-brand-img h-100" alt="main_logo">
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main" style="height: 100vh; overflow: hidden;">
      <ul class="navbar-nav">
        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="../Know Your Grass/food_safety_officer.html">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-tachometer-alt text-primary"></i>
            </div>
            <span class="nav-link-text ms-1">ড্যাশবোর্ড</span>
          </a>
        </li>

        <!-- Sample Inspections -->
        <li class="nav-item">
          <a class="nav-link" href="../pages/FSO_নমুনা পরিদর্শন.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-box-open text-info"></i>
            </div>
            <span class="nav-link-text ms-1">নমুনা পরিদর্শন</span>
          </a>
        </li>

        <!-- Quality Control Logs -->
        <li class="nav-item">
          <a class="nav-link active" href="../pages/FSO_মান নিয়ন্ত্রণ প্রতিবেদন.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-route text-success"></i>
            </div>
            <span class="nav-link-text ms-1">মান নিয়ন্ত্রণ প্রতিবেদন</span>
          </a>
        </li>

        <!-- Product Tracking -->
        <li class="nav-item">
          <a class="nav-link" href="../pages/FSO_পণ্য ট্র্যাকিং.html">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-barcode text-warning"></i>
            </div>
            <span class="nav-link-text ms-1">পণ্য ট্র্যাকিং</span>
          </a>
        </li>

        <!-- Storage Conditions -->
        <!-- <li class="nav-item">
          <a class="nav-link" href="../pages/FSO_সংরক্ষণ অবস্থা.html">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-thermometer-half text-primary"></i>
            </div>
            <span class="nav-link-text ms-1">সংরক্ষণ অবস্থা</span>
          </a>
        </li> -->

        <!-- Quality Control -->
        <li class="nav-item">
          <a class="nav-link" href="../pages/FSO_গুণমান যাচাইকরণ.html">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-check-circle text-danger"></i>
            </div>
            <span class="nav-link-text ms-1">গুণমান যাচাইকরণ</span>
          </a>
        </li>

        <!-- Recall Management -->
        <li class="nav-item">
          <a class="nav-link" href="../pages/FSO_প্রত্যাহার ব্যবস্থাপনা.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-exclamation-triangle text-dark"></i>
            </div>
            <span class="nav-link-text ms-1">প্রত্যাহার ব্যবস্থাপনা</span>
          </a>
        </li>

        <!-- Data Reports -->
        <!-- <li class="nav-item">
          <a class="nav-link" href="../pages/FSO_প্রতিবেদন এবং বিশ্লেষণ.html">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-chart-bar text-secondary"></i>
            </div>
            <span class="nav-link-text ms-1">প্রতিবেদন এবং বিশ্লেষণ</span>
          </a>
        </li> -->

        <!--log out-->
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
              <li class="breadcrumb-item text-sm text-dark active" aria-current="page">মান নিয়ন্ত্রণ প্রতিবেদন</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">খাদ্য নিরাপত্তা কর্মকর্তা</h6>
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
        <!-- Quality Verification Summary Charts -->
        <div class="row mt-0">
            <div class="card h-100" style="max-width: 1000px; margin: 0 auto;"> <!-- Limit width and center -->
                <div class="card-header pb-0">
                    <h6>মান নিয়ন্ত্রণ রিপোর্ট</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-sm">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">পণ্যের নাম</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">অবস্থা</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">পরীক্ষার ফলাফল</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>

        <tr>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['ProductName']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['State']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Result']; ?></td>

        

        

        <td class="text-center">
        <div style="display: flex; justify-content: center; align-items: center; gap: 10px;"></div>

        <!-- <td>
          <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal" >সম্পাদনা</button>
          <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProductModal" >মুছে ফেলুন</button>
        </td> -->

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
    
    <style>
    /* Make the card narrower */
    .card.h-100 {
        max-width: 600px; /* Adjust as needed */
        margin: 0 auto; /* Center the card */
    }
    
    /* Compact table styling */
    .table {
        font-size: 12px; /* Smaller text for compactness */
    }
    
    .table th, .table td {
        padding: 5px 10px; /* Reduce padding */
        text-align: center; /* Align content for better readability */
    }
    
    /* Ensure responsiveness */
    .table-responsive {
        overflow-x: auto; /* Allow horizontal scrolling on small screens */
    }
    </style>
    
    </div>
</div>
  </main>

  <!-- JS Scripts -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.1.0"></script>
</body>

</html>
