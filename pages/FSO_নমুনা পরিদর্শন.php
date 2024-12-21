<?php 

include "./db.php";

// SQL query to join tables and fetch required data
$sql = "
  SELECT 
    hb.lotnumber AS `Lot Number`,
    p.name AS `Product Name`,
    f.location AS `Place of Origin`,
    sd.quantity AS `Quantity`,
    f.farmname AS `Farm Name`,
    s.receiveDate AS `Date of Receive Sample`,
    s.result AS `Results`
FROM 
    harvestbatch hb
JOIN 
    product p ON hb.productID = p.productID
JOIN 
    `seed distribution batch` sd ON hb.lotnumber = sd.`lot number`
JOIN 
    farm f ON hb.farmID = f.farmID
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
  <title>নমুনা পরিদর্শন - Know Your Grass</title>

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
          <a class="nav-link active" href="../pages/FSO_নমুনা পরিদর্শন.html">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-box-open text-info"></i>
            </div>
            <span class="nav-link-text ms-1">নমুনা পরিদর্শন</span>
          </a>
        </li>

        <!-- Quality Control Logs -->
        <li class="nav-item">
          <a class="nav-link" href="../pages/FSO_মান নিয়ন্ত্রণ প্রতিবেদন.html">
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
          <a class="nav-link" href="../pages/FSO_প্রত্যাহার ব্যবস্থাপনা.html">
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
              <li class="breadcrumb-item text-sm text-dark active" aria-current="page">নমুনা পরিদর্শন</li>
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
        <!-- Quality Verification Dashboard -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <h6>নমুনা পণ্যের তালিকা</h6>
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">নতুন নমুনা পরীক্ষা যোগ করুন</button>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">লট নম্বর</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">পণ্যের নাম</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                          উৎপত্তিস্থল</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                          পরিমাণ</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                          খামারের নাম</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">নমুনা প্রাপ্তির তারিখ</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                          ফলাফল</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>

        <tr>
        
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Lot Number']; ?></td>
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Product Name']; ?></td>
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Place of Origin']; ?></td>
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Quantity']; ?></td>
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Farm Name']; ?></td>
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Date of Receive Sample']; ?></td>
        <td class="text-uppercase text-secondary text-xs font-weight-bolder text-center"><?php echo $row['Results']; ?></td>


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

  </main>

  <!-- Add Product Modal -->
  <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">নতুন পণ্য যোগ করুন</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                  <div class="mb-3">
                    <label for="lotNumber" class="form-label">লট নম্বর</label>
                    <input type="text" class="form-control" id="lotNumber">
                  </div>
                  <div class="mb-3">
                    <label for="productName" class="form-label">পণ্যের নাম</label>
                    <input type="text" class="form-control" id="productName">
                  </div>
                  <div class="mb-3">
                    <label for="farmID" class="form-label">খামার আইডি</label>
                    <input type="text" class="form-control" id="farmID">
                  </div>
                  <div class="mb-3">
                    <label for="farmName" class="form-label">খামারের নাম</label>
                    <input type="text" class="form-control" id="farmName">
                  </div>
                  <div class="mb-3">
                    <label for="origin" class="form-label">উৎপত্তিস্থল</label>
                    <input type="text" class="form-control" id="origin">
                  </div>
                  <div class="mb-3">
                    <label for="quality" class="form-label">গুণমান</label>
                    <input type="text" class="form-control" id="quality">
                  </div>
                  
                  <div class="mb-3">
                    <label for="hygiene" class="form-label">পরিচ্ছন্নতার অবস্থা</label>
                    <input type="text" class="form-control" id="hygiene">
                </div>
                <div class="mb-3">
                    <label for="sustainability" class="form-label">পরিবেশ বান্ধবতা</label>
                    <input type="text" class="form-control" id="sustainability">
                </div>
                <div class="mb-3">
                    <label for="healthSafetyStandards" class="form-label">স্বাস্থ্য ও সুরক্ষা মান</label>
                    <input type="text" class="form-control" id="healthSafetyStandards">
                </div>
                <div class="mb-3">
                    <label for="validityEndDate" class="form-label">
                      সার্টিফিকেট মেয়াদ শেষ হওয়ার তারিখ</label>
                    <input type="date" class="form-control" id="validityEndDate">
                </div>
                <div class="mb-3">
                    <label for="harvestDate" class="form-label">শস্য সংগ্রহ তারিখ</label>
                    <input type="date" class="form-control" id="harvestDate">
                </div>
                <div class="mb-3">
                    <label for="harvestQuantity" class="form-label">পরিমাণ (কেজি)</label>
                    <input type="number" class="form-control" id="harvestQuantity">
                </div>
                <div class="mb-3">
                    <label for="proteins" class="form-label">প্রোটিন (%)</label>
                    <input type="number" class="form-control" id="proteins">
                </div>
                <div class="mb-3">
                    <label for="fats" class="form-label">চর্বি (%)</label>
                    <input type="number" class="form-control" id="fats">
                </div>
                <div class="mb-3">
                    <label for="carbohydrates" class="form-label">কার্বোহাইড্রেট (%)</label>
                    <input type="number" class="form-control" id="carbohydrates">
                </div>
                <div class="mb-3">
                    <label for="minerals" class="form-label">খনিজ পদার্থ (%)</label>
                    <input type="number" class="form-control" id="minerals">
                </div>
                <div class="mb-3">
                    <label for="waterContent" class="form-label">জলীয় উপাদান (%)</label>
                    <input type="number" class="form-control" id="waterContent">
                </div>
                <div class="mb-3">
                    <label for="vitamins" class="form-label">ভিটামিন</label>
                    <input type="text" class="form-control" id="vitamins">
                </div>
                <div class="mb-3">
                    <label for="maxTemperature" class="form-label">সর্বোচ্চ তাপমাত্রা (°C)</label>
                    <input type="number" class="form-control" id="maxTemperature">
                </div>
                <div class="mb-3">
                    <label for="minTemperature" class="form-label">সর্বনিম্ন তাপমাত্রা (°C)</label>
                    <input type="number" class="form-control" id="minTemperature">
                </div>
                <div class="mb-3">
                    <label for="lowHumidity" class="form-label">ন্যূনতম আর্দ্রতা (%)</label>
                    <input type="number" class="form-control" id="lowHumidity">
                </div>
                <div class="mb-3">
                    <label for="highHumidity" class="form-label">সর্বোচ্চ আর্দ্রতা (%)</label>
                    <input type="number" class="form-control" id="highHumidity">
                </div>
                <div class="mb-3">
                    <label for="salmonella" class="form-label">স্যালমোনেলা (CFU/গ্রাম)</label>
                    <input type="text" class="form-control" id="salmonella">
                </div>
                <div class="mb-3">
                    <label for="eColi" class="form-label">ই.কোলাই (CFU/গ্রাম)</label>
                    <input type="text" class="form-control" id="eColi">
                </div>
                <div class="mb-3">
                    <label for="pesticides" class="form-label">কীটনাশক (মি.গ্রা./কেজি)</label>
                    <input type="number" class="form-control" id="pesticides">
                </div>
                <div class="mb-3">
                    <label for="heavyMetals" class="form-label">ভারী ধাতু (মি.গ্রা./কেজি)</label>
                    <input type="number" class="form-control" id="heavyMetals">
                </div>
                <div class="mb-3">
                    <label for="herbicides" class="form-label">উদ্ভিদনাশক (মি.গ্রা./কেজি)</label>
                    <input type="number" class="form-control" id="herbicides">
                </div>
                <div class="mb-3">
                    <label for="additives" class="form-label">কেমিক্যালস্ (মি.গ্রা./কেজি)</label>
                    <input type="number" class="form-control" id="additives">
                </div>
                <div class="mb-3">
                    <label for="preservatives" class="form-label">সংরক্ষক পদার্থ (মি.গ্রা./কেজি)</label>
                    <input type="number" class="form-control" id="preservatives">
                </div>
                <div class="mb-3">
                    <label for="unauthorizedSubstances" class="form-label">অননুমোদিত পদার্থ</label>
                    <input type="text" class="form-control" id="unauthorizedSubstances">
                </div>
                <div class="mb-3">
                    <label for="productionDate" class="form-label">উৎপাদনের তারিখ</label>
                    <input type="date" class="form-control" id="productionDate">
                </div>
                <div class="mb-3">
                    <label for="expiryDate" class="form-label">মেয়াদ উত্তীর্ণ তারিখ</label>
                    <input type="date" class="form-control" id="expiryDate">
                </div>
                <div class="mb-3">
                    <label for="productId" class="form-label">পণ্যের আইডি</label>
                    <input type="text" class="form-control" id="productId">
                </div>
                <div class="mb-3">
                    <label for="EmployeeId" class="form-label">খাদ্য নিরাপত্তা কর্মকর্তা আইডি</label>
                    <input type="text" class="form-control" id="EmployeeId">
                </div>
                <div class="mb-3">
                    <label for="seedDistributionId" class="form-label">বীজ বিতরণ আইডি</label>
                    <input type="text" class="form-control" id="seedDistributionId">
                </div>

                <div class="mb-3">
                    <label for="Condition" class="form-label">অবস্থা</label>
                    <select class="form-control" id="Condition">
                        <option value="যাচাইয়ের অপেক্ষায়">যাচাইয়ের অপেক্ষায়</option>
                        <option value="অনুমোদিত">অনুমোদিত</option>
                        <option value="অননুমোদিত">অননুমোদিত</option>
                    </select>
                </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
                <!-- <button type="button" class="btn btn-primary">সংরক্ষণ করুন</button> -->
                <button type="button" class="btn btn-primary" onclick="addSample()">সংরক্ষণ করুন</button>

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
                    <label for="editLotNumber" class="form-label">লট নাম্বার</label>
                    <input type="text" class="form-control" id="editLotNumber">
                </div>
                <div class="mb-3">
                  <label for="editProductName" class="form-label">পণ্যের নাম</label>
                  <input type="text" class="form-control" id="editProductName">
                </div>
                <div class="mb-3">
                    <label for="editFarmId" class="form-label">খামার আইডি</label>
                    <input type="text" class="form-control" id="editFarmId">
                </div>
                <div class="mb-3">
                  <label for="editFarmName" class="form-label">খামারের নাম</label>
                  <input type="text" class="form-control" id="editFarmName">
                </div>
                <div class="mb-3">
                    <label for="editOrigin" class="form-label">উৎপত্তি</label>
                    <input type="text" class="form-control" id="editOrigin">
                </div>
                <div class="mb-3">
                    <label for="editQuality" class="form-label">গুণমান</label>
                    <input type="text" class="form-control" id="editQuality">
                </div>
                <div class="mb-3">
                    <label for="editHygiene" class="form-label">পরিচ্ছন্নতার অবস্থা</label>
                    <input type="text" class="form-control" id="editHygiene">
                </div>
                <div class="mb-3">
                    <label for="editSustainability" class="form-label">পরিবেশ বান্ধবতা</label>
                    <input type="text" class="form-control" id="editSustainability">
                </div>
                <div class="mb-3">
                    <label for="editHealthSafetyStandards" class="form-label">স্বাস্থ্য ও সুরক্ষা মান</label>
                    <input type="text" class="form-control" id="editHealthSafetyStandards">
                </div>
                <div class="mb-3">
                    <label for="editValidityEndDate" class="form-label">সার্টিফিকেট মেয়াদ শেষ হওয়ার তারিখ</label>
                    <input type="date" class="form-control" id="editValidityEndDate">
                </div>
                <div class="mb-3">
                    <label for="editHarvestDate" class="form-label">শস্য সংগ্রহ তারিখ</label>
                    <input type="date" class="form-control" id="editHarvestDate">
                </div>
                <div class="mb-3">
                    <label for="editHarvestQuantity" class="form-label">পরিমাণ (কেজি)</label>
                    <input type="number" class="form-control" id="editHarvestQuantity">
                </div>
                <div class="mb-3">
                    <label for="editProteins" class="form-label">প্রোটিন (%)</label>
                    <input type="number" class="form-control" id="editProteins">
                </div>
                <div class="mb-3">
                    <label for="editFats" class="form-label">চর্বি (%)</label>
                    <input type="number" class="form-control" id="editFats">
                </div>
                <div class="mb-3">
                    <label for="editCarbohydrates" class="form-label">কার্বোহাইড্রেট (%)</label>
                    <input type="number" class="form-control" id="editCarbohydrates">
                </div>
                <div class="mb-3">
                    <label for="editMinerals" class="form-label">খনিজ পদার্থ (%)</label>
                    <input type="number" class="form-control" id="editMinerals">
                </div>
                <div class="mb-3">
                    <label for="editWaterContent" class="form-label">জলীয় উপাদান (%)</label>
                    <input type="number" class="form-control" id="editWaterContent">
                </div>
                <div class="mb-3">
                    <label for="editVitamins" class="form-label">ভিটামিন</label>
                    <input type="number" class="form-control" id="editVitamins">
                </div>
                <div class="mb-3">
                    <label for="editMaxTemperature" class="form-label">সর্বোচ্চ তাপমাত্রা (°C)</label>
                    <input type="number" class="form-control" id="editMaxTemperature">
                </div>
                <div class="mb-3">
                    <label for="editMinTemperature" class="form-label">সর্বনিম্ন তাপমাত্রা (°C)</label>
                    <input type="number" class="form-control" id="editMinTemperature">
                </div>
                <div class="mb-3">
                    <label for="editLowHumidity" class="form-label">ন্যূনতম আর্দ্রতা (%)</label>
                    <input type="number" class="form-control" id="editLowHumidity">
                </div>
                <div class="mb-3">
                    <label for="editHighHumidity" class="form-label">সর্বোচ্চ আর্দ্রতা (%)</label>
                    <input type="number" class="form-control" id="editHighHumidity">
                </div>
                <div class="mb-3">
                    <label for="editSalmonella" class="form-label">স্যালমোনেলা (CFU/গ্রাম)</label>
                    <input type="text" class="form-control" id="editSalmonella">
                </div>
                <div class="mb-3">
                    <label for="editEColi" class="form-label">ই.কোলাই (CFU/গ্রাম)</label>
                    <input type="text" class="form-control" id="editEColi">
                </div>
                <div class="mb-3">
                    <label for="editPesticides" class="form-label">কীটনাশক (মি.গ্রা./কেজি)</label>
                    <input type="number" class="form-control" id="editPesticides">
                </div>
                <div class="mb-3">
                    <label for="editHeavyMetals" class="form-label">ভারী ধাতু (মি.গ্রা./কেজি)</label>
                    <input type="number" class="form-control" id="editHeavyMetals">
                </div>
                <div class="mb-3">
                    <label for="editHerbicides" class="form-label">উদ্ভিদনাশক (মি.গ্রা./কেজি)</label>
                    <input type="number" class="form-control" id="editHerbicides">
                </div>
                <div class="mb-3">
                    <label for="editAdditives" class="form-label">কেমিক্যালস্ (মি.গ্রা./কেজি)</label>
                    <input type="number" class="form-control" id="editAdditives">
                </div>
                <div class="mb-3">
                    <label for="editPreservatives" class="form-label">সংরক্ষক পদার্থ (মি.গ্রা./কেজি)</label>
                    <input type="number" class="form-control" id="editPreservatives">
                </div>
                <div class="mb-3">
                    <label for="editUnauthorizedSubstances" class="form-label">অননুমোদিত পদার্থ</label>
                    <input type="text" class="form-control" id="editUnauthorizedSubstances">
                </div>
                <div class="mb-3">
                    <label for="editProductionDate" class="form-label">উৎপাদনের তারিখ</label>
                    <input type="date" class="form-control" id="editProductionDate">
                </div>
                <div class="mb-3">
                    <label for="editExpiryDate" class="form-label">মেয়াদ উত্তীর্ণ তারিখ</label>
                    <input type="date" class="form-control" id="editExpiryDate">
                </div>
                <div class="mb-3">
                    <label for="editProductId" class="form-label">পণ্যের আইডি</label>
                    <input type="text" class="form-control" id="editProductId">
                </div>
                <div class="mb-3">
                    <label for="editFarmEmployeeId" class="form-label">খাদ্য নিরাপত্তা কর্মকর্তা আইডি</label>
                    <input type="text" class="form-control" id="editFarmEmployeeId">
                </div>
                <div class="mb-3">
                    <label for="editSeedDistributionId" class="form-label">বীজ বিতরণ আইডি</label>
                    <input type="text" class="form-control" id="editSeedDistributionId">
                </div>
                
                <div class="mb-3">
                  <label for="editCondition" class="form-label">অবস্থা</label>
                  <select class="form-control" id="editCondition">
                      <option value="যাচাইয়ের অপেক্ষায়">যাচাইয়ের অপেক্ষায়</option>
                      <option value="অনুমোদিত">অনুমোদিত</option>
                      <option value="অননুমোদিত">অননুমোদিত</option>
                  </select>
                </div>
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ করুন</button>
              <button type="button" class="btn btn-primary" onclick="updateSample()">সংরক্ষণ করুন</button>
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
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.1.0"></script>
  <script>

    function addSample() {
      // Get input values
      const lotNumber = document.getElementById('lotNumber').value;
      const productName = document.getElementById('productName').value;
      const origin = document.getElementById('origin').value;
      const harvestQuantity = document.getElementById('harvestQuantity').value;
      const farmName = document.getElementById('farmName').value;
      const productionDate = document.getElementById('productionDate').value;
      const Condition = document.getElementById('Condition').value;

      // Add a new row to the table
      const table = document.querySelector('table tbody');
      const newRow = document.createElement('tr');

      newRow.innerHTML = `
          <td class="align-middle">${lotNumber}</td>
          <td class="align-middle">${productName}</td>
          <td class="align-middle">${origin}</td>
          <td class="align-middle">${harvestQuantity}</td>
          <td class="align-middle">${farmName}</td>
          <td class="align-middle">${productionDate}</td>
          <td class="align-middle">${Condition}</td>
          <td class="align-middle text-center">
            <button class="btn btn-sm btn-primary edit-button">সম্পাদনা</button>
          </td>
      `;

      // Append the new row to the table
      table.appendChild(newRow);

      // Clear the form
      document.getElementById('lotNumber').value = '';
      document.getElementById('productName').value = '';
      document.getElementById('origin').value = '';
      document.getElementById('harvestQuantity').value = '';
      document.getElementById('farmName').value = '';
      document.getElementById('productionDate').value = '';
      document.getElementById('Condition').value = 'যাচাইয়ের অপেক্ষায়';

      // Close the modal
      document.querySelector('#addProductModal .btn-close').click();
    }


    document.querySelector('table tbody').addEventListener('click', function (event) {
    if (event.target.classList.contains('edit-button')) {
      const row = event.target.closest('tr');

      // Extract data from the row
      const lotNumber = row.children[0].textContent.trim();
      const productName = row.children[1].textContent.trim();
      const origin = row.children[2].textContent.trim();
      const harvestQuantity = row.children[3].textContent.trim();
      const farmName = row.children[4].textContent.trim();
      const productionDate = row.children[5].textContent.trim();
      const Condition = row.children[6].textContent.trim();

      console.log('Edit button clicked:', {
        lotNumber,
        productName,
        origin,
        harvestQuantity,
        farmName,
        productionDate,
        Condition,
      });

      // Call the function to populate modal
      populateEditModal(lotNumber, productName, origin, harvestQuantity, farmName, productionDate, Condition);

      // Trigger the modal
      const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
      editModal.show();
    }
  });



    function populateEditModal(lotNumber, productName, origin, harvestQuantity, farmName, productionDate, Condition) {
    console.log('Populating modal with:', {
      lotNumber,
      productName,
      origin,
      harvestQuantity,
      farmName,
      productionDate,
      Condition,
    });

    document.getElementById('editLotNumber').value = lotNumber;
    document.getElementById('editProductName').value = productName;
    document.getElementById('editOrigin').value = origin;
    document.getElementById('editHarvestQuantity').value = harvestQuantity;
    document.getElementById('editFarmName').value = farmName;
    document.getElementById('editProductionDate').value = productionDate;
    document.getElementById('editCondition').value = Condition;

    // Save reference to the row being edited
    editingRow = [...document.querySelectorAll('table tbody tr')].find(
      row => row.children[0].textContent.trim() === lotNumber
    );
  }



    let editingRow = null; // Global variable to store the row being edited

    function updateSample() {
      if (!editingRow) {
        console.error('No row selected for editing.');
        return;
      }

      // Get updated values from the form
      const lotNumber = document.getElementById('editLotNumber').value;
      const productName = document.getElementById('editProductName').value;
      const origin = document.getElementById('editOrigin').value;
      const harvestQuantity = document.getElementById('editHarvestQuantity').value;
      const farmName = document.getElementById('editFarmName').value;
      const productionDate = document.getElementById('editProductionDate').value;
      const Condition = document.getElementById('editCondition').value;

      console.log('Updating row with:', {
        lotNumber,
        productName,
        origin,
        harvestQuantity,
        farmName,
        productionDate,
        Condition,
      });

      // Update the row's cells
      editingRow.children[0].textContent = lotNumber;
      editingRow.children[1].textContent = productName;
      editingRow.children[2].textContent = origin;
      editingRow.children[3].textContent = harvestQuantity;
      editingRow.children[4].textContent = farmName;
      editingRow.children[5].textContent = productionDate;
      editingRow.children[6].textContent = Condition;

      // Clear the editingRow reference
      editingRow = null;

      // Close the modal
      const editModal = bootstrap.Modal.getInstance(document.getElementById('editProductModal'));
      editModal.hide();

      console.log('Row updated successfully!');
    }


    function populateDeleteModal(lotNumber) {
        document.getElementById('deleteProductMessage').textContent = `আপনি কি নিশ্চিত যে আপনি লট নাম্বার "${lotNumber}" এর পণ্যটি মুছে ফেলতে চান?`;
    }
</script>
</body>

</html>
