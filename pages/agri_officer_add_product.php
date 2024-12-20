<?php 

include "./db.php";

// SQL query to join tables and fetch required data
$sql = "
   SELECT 
    p.productID AS `Product ID`,
    p.name AS `Product Name`,
    p.variety AS `Species`,
    f.farmname AS `Farm Name`,
    f.location AS `Place of Origin`,
    hb.harvestdate AS `Harvest Time`,
    p.`growing season`,
    p.Calories,
    p.proteins,
    p.fats,
    p.carbohydrates,
    p.vitamins,
    p.minerals,
    p.`nutrient density`,
    p.`glycemi cindex(GI)`
FROM 
    harvestbatch hb
JOIN 
    farm f ON hb.farmID = f.farmID
JOIN 
    product p ON hb.productID = p.productID;



";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="bn">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>ড্যাশবোর্ড - Agri Officer</title>

  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/nucleo/2.0.6/css/nucleo-icons.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
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
                <a class="nav-link active" href="../pages/agri_officer_add_product.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-seedling text-warning"></i>
                    </div>
                    <span class="nav-link-text ms-1">পণ্যের তথ্য যোগ</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="../pages/track_product_update.html">
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
                <a class="nav-link" href="../pages/agri_add_affected_batches_details.php">
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
                  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">পণ্যের তালিকা</li>
              </ol>
              <h6 class="font-weight-bolder mb-0">পণ্যের তালিকা</h6>
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">পণ্যের আইডি</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">পণ্যের নাম</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">প্রজাতি</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">খামারের নাম</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">উৎপত্তিস্থান</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ফসল তোলার সময়</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">পণ্যের বিবরণ</th>
                                    
                                  </tr>
                              </thead>
                              <tbody>
                              <?php

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Button and Modal Generation
        echo '<tr>';
        echo '<td>' . $row['Product ID'] . '</td>';
        echo '<td>' . $row['Product Name'] . '</td>';
        echo '<td>' . $row['Species'] . '</td>';
        echo '<td>' . $row['Farm Name'] . '</td>';
        echo '<td>' . $row['Place of Origin'] . '</td>';
        echo '<td>' . $row['Harvest Time'] . '</td>';
        echo '<td>
                <button 
                    class="btn btn-sm btn-primary" 
                    data-bs-toggle="modal" 
                    data-bs-target="#viewProductDetailsModal" 
                    data-product-details=\'' . json_encode($row) . '\'>বিবরণ</button>
              </td>';
              echo '<td class="text-center">
                <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal">সম্পাদনা</button>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProductModal">মুছে ফেলুন</button>
                </div>
              </td>';
        echo '</tr>';
    }
} else {
    echo "<tr><td colspan='7'>No records found</td></tr>";
}
?>

<!-- JavaScript to Populate Modal -->
<script>
document.querySelectorAll('[data-bs-target="#viewProductDetailsModal"]').forEach(button => {
    button.addEventListener('click', function () {
        const details = JSON.parse(this.getAttribute('data-product-details'));
        const modalBody = document.querySelector('#viewProductDetailsModal .modal-body .product-details-list');
        modalBody.innerHTML = Object.entries(details).map(([key, value]) => 
            `<li class="product-item"><strong class="product-label">${key}:</strong> ${value}</li>`
        ).join('');
    });
});
</script>


                                    
  <!-- Modal Structure -->
  <div class="modal fade" id="viewProductDetailsModal" tabindex="-1" aria-labelledby="viewProductDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title" id="viewProductDetailsModalLabel">পণ্যের বিস্তারিত তথ্য</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- Modal Body -->
        <div class="modal-body">
          <p>Product details will go here. You can add a description, specifications, and any relevant information about the product.</p>
          <!-- Example Product Info -->
          
          <ul class="product-details-list">
            <li class="product-item">
              <strong class="product-label">পণ্যের আইডি:</strong> 
            </li>
            <li class="product-item">
              <strong class="product-label">পণ্যের নাম:</strong> 
            </li>
            <li class="product-item">
              <strong class="product-label">প্রজাতি:</strong> 
            </li>
            <li class="product-item">
              <strong class="product-label">খামারের নাম:</strong> 
            </li>
            <li class="product-item">
              <strong class="product-label">উৎপত্তিস্থান:</strong> 
            </li>
            <li class="product-item">
              <strong class="product-label">ফসল তোলার সময়:</strong> 
            </li>
            <li class="product-item">
              <strong class="product-label">পণ্যের বিবরণ:</strong> 
            </li>
            <li class="product-item">
              <strong class="product-label">পণ্যের ধরণ:</strong> 
            </li>
            <li class="product-item">
              <strong class="product-label">পণ্যের গ্লাইসেমিক সূচক (জিআই):</strong> 
            </li>
            <li class="product-item">
              <strong class="product-label">পণ্যের পুষ্টির ঘনত্ব:</strong> 
            </li>
            <li class="product-item">
              <strong class="product-label">ভিটামিন:</strong> 
            </li>
            <li class="product-item">
              <strong class="product-label">খনিজ:</strong> 
            </li>
            <li class="product-item">
              <strong class="product-label">ক্যালোরি:</strong> 
            </li>
            <li class="product-item">
              <strong class="product-label">প্রোটিন:</strong> 
            </li>
            <li class="product-item">
              <strong class="product-label">চর্বি:</strong> 
            </li>
            <li class="product-item">
              <strong class="product-label">কার্বোহাইড্রেট:</strong> 
            </li>
            <li class="product-item">
              <strong class="product-label">উৎপাদনের মৌসুম:</strong> 
            </li>
          </ul>
          
        </div>
        <!-- Modal Footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
          <button type="button" class="btn btn-primary">সংরক্ষণ করুন</button> 
        </div>
      </div>
    </div>
  </div>


                                    <!-- <td class="align-middle text-center">
                                      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editProductModal" >সম্পাদনা</button>
                                      <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProductModal">মুছে ফেলুন</button>
                                    </td> -->
                                  </tr>
                                  
                                  <!-- Add more rows as needed -->
                              </tbody>
                          </table>
                      </div>
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
                        <label for="editProductName" class="form-label">পণ্যের আইডি</label>
                        <input type="text" class="form-control" id="editProductName">
                    </div>
                    <div class="mb-3">
                        <label for="editProductStock" class="form-label">পণ্যের নাম</label>
                        <input type="text" class="form-control" id="editProductStock">
                    </div>
                    <div class="mb-3">
                        <label for="editProductStock" class="form-label">প্রজাতি</label>
                        <input type="date" class="form-control" id="editProductStock">
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
                        <label for="editProductHumidity" class="form-label">খামারের নাম</label>
                        <input type="date" class="form-control" id="editProductHumidity">
                    </div>
                    <div class="mb-3">
                        <label for="editProductTemperature" class="form-label">উৎপত্তিস্থান</label>
                        <input type="number" class="form-control" id="editProductTemperature">
                    </div>
                    <div class="mb-3">
                        <label for="editProductTemperature" class="form-label">ফসল তোলার সময়</label>
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
     

                  <!-- Pie Chart and Map for Product Tracking Summary -->
<!-- Row for Product Tracking Summary with Map -->
<div class="row mt-4">
  <!-- Pie Chart for Product Tracking Summary -->
  <div class="col-lg-6">
      <div class="card h-100">
          <div class="card-header pb-0">
              <h6>পণ্য ট্র্যাকিং সারাংশ</h6>
          </div>
          <div class="card-body p-3">
              <canvas id="productTrackingChart" height="300"></canvas>
          </div>
      </div>
  </div>
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
                      <label for="trackingProductName" class="form-label">পণ্যের আইডি</label>
                      <input type="text" class="form-control" id="trackingProductName">
                    </div>
                    <div class="mb-3">
                        <label for="trackingProductName" class="form-label">পণ্যের নাম</label>
                        <input type="text" class="form-control" id="trackingProductName">
                    </div>
                    <div class="mb-3">
                        <label for="trackingRFID" class="form-label">প্রজাতি</label>
                        <input type="text" class="form-control" id="trackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="trackingStatus" class="form-label">খামারের নাম</label>
                        <input type="text" class="form-control" id="trackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="trackingSource" class="form-label">উৎপত্তিস্থান</label>
                        <input type="text" class="form-control" id="trackingSource">
                    </div>
                    <div class="mb-3">
                        <label for="trackingSource" class="form-label">ফসল তোলার সময়</label>
                        <input type="text" class="form-control" id="trackingSource">
                    </div>
                    <div class="mb-3">
                        <label for="trackingSource" class="form-label">পণ্যের বিবরণ</label>
                        <input type="text" class="form-control" id="trackingSource">
                    </div>
                    <div class="mb-3">
                        <label for="trackingSource" class="form-label">পণ্যের ধরণ</label>
                        <input type="text" class="form-control" id="trackingSource">
                    </div>
                    <div class="mb-3">
                        <label for="trackingSource" class="form-label">পণ্যের গ্লাইসেমিক সূচক (জিআই)</label>
                        <input type="text" class="form-control" id="trackingSource">
                    </div>
                    <div class="mb-3">
                        <label for="trackingSource" class="form-label">পণ্যের পুষ্টির ঘনত্ব</label>
                        <input type="text" class="form-control" id="trackingSource">
                    </div>
                    <div class="mb-3">
                        <label for="trackingSource" class="form-label">ভিটামিন</label>
                        <input type="text" class="form-control" id="trackingSource">
                    </div>
                    <div class="mb-3">
                        <label for="trackingSource" class="form-label">খনিজ</label>
                        <input type="text" class="form-control" id="trackingSource">
                    </div>
                    <div class="mb-3">
                        <label for="trackingSource" class="form-label">ক্যালোরি</label>
                        <input type="text" class="form-control" id="trackingSource">
                    </div>
                    <div class="mb-3">
                        <label for="trackingSource" class="form-label">প্রোটিন</label>
                        <input type="text" class="form-control" id="trackingSource">
                    </div>
                    <div class="mb-3">
                        <label for="trackingSource" class="form-label">চর্বি</label>
                        <input type="text" class="form-control" id="trackingSource">
                    </div>
                    <div class="mb-3">
                        <label for="trackingSource" class="form-label">কার্বোহাইড্রেট</label>
                        <input type="text" class="form-control" id="trackingSource">
                    </div>
                    <div class="mb-3">
                        <label for="trackingSource" class="form-label">উৎপাদনের মৌসুম</label>
                        <input type="text" class="form-control" id="trackingSource">
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

<!-- Edit Product Tracking Modal -->
<div class="modal fade" id="editProductTrackingModal" tabindex="-1" aria-labelledby="editProductTrackingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductTrackingModalLabel">পণ্য সম্পাদনা করুন</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="editTrackingProductName" class="form-label">পণ্যের নাম</label>
                        <input type="text" class="form-control" id="editTrackingProductName">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">খামারের নাম</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">উৎস</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">বর্তমান অবস্থান</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">গন্তব্য</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>                        <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">উৎস</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">বর্তমান অবস্থান</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">গন্তব্য</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>                        <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">উৎস</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">বর্তমান অবস্থান</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">গন্তব্য</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>                        <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">উৎস</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">বর্তমান অবস্থান</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">গন্তব্য</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>                        <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">উৎস</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">বর্তমান অবস্থান</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">গন্তব্য</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>                        <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">উৎস</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">বর্তমান অবস্থান</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">গন্তব্য</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>                        <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">উৎস</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">বর্তমান অবস্থান</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">গন্তব্য</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>                        <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">উৎস</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">বর্তমান অবস্থান</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">গন্তব্য</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>                        <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">উৎস</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">বর্তমান অবস্থান</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingRFID" class="form-label">গন্তব্য</label>
                        <input type="text" class="form-control" id="editTrackingRFID">
                    </div>
                    </div>
                    <div class="mb-3">
                        <label for="editTrackingDate" class="form-label">তারিখ</label>
                        <input type="date" class="form-control" id="editTrackingDate">
                    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
                <button type="button" class="btn btn-primary">সংরক্ষণ করুন</button>
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
  function populateEditModal(name, temperature, humidity, products) {
      document.getElementById('editStorageRoomName').value = name;
      document.getElementById('editStorageTemperature').value = temperature;
      document.getElementById('editStorageHumidity').value = humidity;
      const productSelect = document.getElementById('editStorageProducts');
      for (let i = 0; i < productSelect.options.length; i++) {
          productSelect.options[i].selected = products.includes(productSelect.options[i].value);
      }
  }

  function deleteStorageRoom(name) {
      if (confirm(`Are you sure you want to delete the storage room: ${name}?`)) {
          // Logic to delete the storage room
          alert(`${name} has been deleted.`);
      }
  }

  // Product Tracking Pie Chart
  var ctxProductTrackingChart = document.getElementById('productTrackingChart').getContext('2d');
  new Chart(ctxProductTrackingChart, {
    type: 'pie',
    data: {
      labels: ['খামার থেকে উৎপাদিত পণ্য', 'ট্রানজিটে', 'বিতরণ করা হয়েছে'],
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

    
<!-- Product Entry and Distribution Over Time Chart -->
<div class="row mt-2">
          
    <div class="card h-30">
      <div class="card-header pb-0">
          <div class="card-header pb-0">
              <h6>অঞ্চলভিত্তিক উৎপাদিত ফসলের বিবরণ স্থিতি</h6>
            </div>
      </div>
      <div class="card-body p-3">
          <canvas id="batchStatusChart" width="400" height="200"></canvas>
      </div>
    </div>
    </div>
    </div>

    <!-- <script>
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
    
    </script> -->
    <script src="../assets/js/soft-ui-dashboard.min.js?v=1.1.0"></script>
    <!-- Include Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    
    <script>
    // Initializing the Batch Status Chart
    const ctx = document.getElementById('batchStatusChart').getContext('2d');
    const batchStatusChart = new Chart(ctx, {
    type: 'bar',
    data: {
    labels: ['রংপুর', 'চিটাগাং', 'মহেশখালি', 'ময়মনসিংহ'], // Labels for stages
    datasets: [{
    label: 'উৎপাদিত ফসলের পরিমান(টন)',
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
    text: 'উৎপাদিত ফসলের পরিমান(টন)'
    }
    },
    x: {
    title: {
    display: true,
    text: 'অঞ্চলের নাম'
    }
    }
    }
    }
    });

    
    </script>

  <!-- Core JS Files -->
  <!-- <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.1.0"></script> -->
</body> 

</html> 
