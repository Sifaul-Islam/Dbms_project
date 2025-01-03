<?php 

include "./db.php";

// SQL query to join tables and fetch required data
$sql = "
   SELECT 
    p.name AS ProductName,
    h.lotnumber AS LotNumber,
    s.rejectReason AS RejectReason,
    s.receiveDate AS ReceiveDate,
    s.state AS State
FROM 
    harvestbatch h
JOIN 
    product p ON h.productID = p.productID
JOIN 
    sample s ON p.productID = s.productID;





";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>প্রত্যাহার ব্যবস্থাপনা - Know Your Grass</title>

  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/nucleo/2.0.6/css/nucleo-icons.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
  <!-- <style>
    /* Ensure no scrollbars on the sidenav and parent containers */
    body {
      overflow: hidden; /* Prevent scrolling for the entire page */
    }

    #sidenav-main {
      height: 100vh; /* Full height of the viewport */
      overflow: hidden; /* Remove scrollbar */
    }

    #sidenav-collapse-main {
      height: 100%; /* Full height for the navbar collapse */
      overflow: hidden; /* Prevent scrolling within */
    }
  </style> -->
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
          <a class="nav-link" href="../pages/FSO_মান নিয়ন্ত্রণ প্রতিবেদন.php">
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
          <a class="nav-link active" href="../pages/FSO_প্রত্যাহার ব্যবস্থাপনা.php">
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

  <!-- Main Content -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">পৃষ্ঠা</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">প্রত্যাহার ব্যবস্থাপনা</li>
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
      <!-- Recall Statistics -->
      <div class="row">
        <div class="col-lg-3 col-md-6 col-12 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="d-flex">
                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-alert-circle text-lg text-white opacity-10"></i>
                </div>
                <div class="ms-3">
                  <p class="text-sm mb-0 text-capitalize">পরীক্ষিত</p>
                  <h5 class="font-weight-bolder mb-0">১৫</h5>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 col-12 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="d-flex">
                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                  <i class="ni ni-check-bold text-lg text-white opacity-10"></i>
                </div>
                <div class="ms-3">
                  <p class="text-sm mb-0 text-capitalize">অননুমোদিত</p>
                  <h5 class="font-weight-bolder mb-0">৫</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>

      <!-- Recall Table -->
      <div class="row mt-4">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header pb-0">
              <h6>প্রত্যাহার তালিকা</h6>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder">পণ্য</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder">লট নম্বর</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder">কারণ</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder">তারিখ</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">অবস্থা</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>

        <tr>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['ProductName']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['LotNumber']; ?></td>

        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['RejectReason']; ?></td>
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['ReceiveDate']; ?></td>
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['State']; ?></td>

        

        

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
                    <!-- Add more rows as necessary -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
  
    <!-- Add Recall Button -->
    <div class="row mt-4">
        <div class="col-lg-12 text-end">
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRecallModal">নতুন প্রত্যাহার যোগ করুন</button>

        </div>
      </div>
    </div>
</main>

  <!-- Add Recall Modal -->
  <div class="modal fade" id="addRecallModal" tabindex="-1" aria-labelledby="addRecallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addRecallModalLabel">নতুন প্রত্যাহার যোগ করুন</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addRecallForm">
            <div class="mb-3">
              <label for="productName" class="form-label">পণ্যের নাম</label>
              <input type="text" class="form-control" id="productName" required>
            </div>
            <div class="mb-3">
              <label for="lotNumber" class="form-label">লট নম্বর</label>
              <input type="text" class="form-control" id="lotNumber" required>
            </div>
            <div class="mb-3">
              <label for="reason" class="form-label">কারণ</label>
              <input type="text" class="form-control" id="reason" required>
            </div>
            <div class="mb-3">
              <label for="date" class="form-label">তারিখ</label>
              <input type="date" class="form-control" id="date" required>
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">অবস্থা</label>
              <select class="form-select" id="status" required>
                <option value="চলমান">চলমান</option>
                <option value="সম্পন্ন">সম্পন্ন</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
          <button type="button" class="btn btn-primary" onclick="addRecall()">সংরক্ষণ করুন</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    function addRecall() {
      // Get form values
      const productName = document.getElementById('productName').value;
      const lotNumber = document.getElementById('lotNumber').value;
      const reason = document.getElementById('reason').value;
      const date = document.getElementById('date').value;
      const status = document.getElementById('status').value;
  
      // Validate form inputs
      if (!productName || !lotNumber || !reason || !date || !status) {
        alert('সব তথ্য পূরণ করুন।');
        return;
      }
  
      // Find the table body
      const tableBody = document.querySelector('table tbody');
  
      // Create a new row
      const newRow = document.createElement('tr');
      newRow.innerHTML = `
        <td class="align-middle">
          <p class="text-sm font-weight-bold mb-0">${productName}</p>
        </td>
        <td class="align-middle">
          <p class="text-sm mb-0">${lotNumber}</p>
        </td>
        <td class="align-middle">
          <p class="text-sm mb-0">${reason}</p>
        </td>
        <td class="align-middle">
          <p class="text-sm mb-0">${date}</p>
        </td>
        <td class="align-middle text-center">
          <span class="badge badge-sm ${status === 'চলমান' ? 'bg-gradient-warning' : 'bg-gradient-success'}">${status}</span>
        </td>
      `;
  
      // Append the new row to the table
      tableBody.appendChild(newRow);
  
      // Clear the form
      document.getElementById('addRecallForm').reset();
  
      // Close the modal
      const modal = bootstrap.Modal.getInstance(document.getElementById('addRecallModal'));
      modal.hide();
    }
  </script>
  


  <!-- JS Scripts -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.1.0"></script>
</body>

</html>