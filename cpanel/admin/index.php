<?php
  ob_start();
  require "../../global/DBOperations.php";
  $PageName = $lang['ControlPanel'];
  $Page = 'ControlPanel';
  require "../../global/header.php";
  if (isset($_SESSION['AdminId']))
  {
    ?>
    <!-- Start Breadcrumb -->
    <nav class="p-2 mb-4 rounded navBredcrumb" aria-label="breadcrumb">
      <div class="container">
        <ol class="breadcrumb my-3">
          <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase" href="../../index.php"><?php echo $lang['Home']; ?></a></li>
          <li class="breadcrumb-item breadcrumb-link fw-bold text-decoration-none text-uppercase active" aria-current="page"><?php echo $lang['ControlPanel']; ?></li>
        </ol>
      </div>
    </nav>
    <!-- End Breadcrumb -->
    <!-- Start Dashboard -->
    <section class="statsAdmin my-3">
      <div class="container text-center">
        <h1 class="text-center my-4"><?php echo $lang['ControlPanel']; ?></h1>
        <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card my-4 mx-auto px-2 " style="max-width: 18rem;">
              <div class="card-header p-2 d-flex justify-content-end position-relative">
                <div class="icon position-absolute rounded p-4" style="background-color: #E426D5; top: -30px;">
                  <i class="fa fa-building fa-3x fa-fw"></i>
                </div>
                <h5 class="card-title m-0 me-auto">
                  <?php echo $lang['Total'] , $lang['Floors']; ?>
                  <span class="d-block display-6">
                    <?php echo countItems('FloorId', 'floors'); ?>
                  </span>
                </h5>
              </div>
              <div class="card-footer bg-transparent">
                <a href="floors.php" class="btn hvr-bounce-in shadow-none"><?php echo $lang['MoreDetails']; ?></a>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card my-4 mx-auto px-2 " style="max-width: 18rem;">
              <div class="card-header p-2 d-flex justify-content-end position-relative">
                <div class="icon position-absolute rounded p-4" style="background-color: #ffa726; top: -30px;">
                  <i class="fas fa-tasks fa-3x fa-fw"></i>
                </div>
                <h5 class="card-title m-0 me-auto">
                  <?php echo $lang['Total'], $lang['Features']; ?>
                  <span class="d-block display-6">
                    <?php echo countItems('FeatureId', 'hotel_features') ?>
                  </span>
                </h5>
              </div>
              <div class="card-footer bg-transparent">
                <a href="features.php" class="btn hvr-bounce-in shadow-none"><?php echo $lang['MoreDetails']; ?></a>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card my-4 mx-auto px-2 " style="max-width: 18rem;">
              <div class="card-header p-2 d-flex justify-content-end position-relative">
                <div class="icon position-absolute rounded p-4" style="background-color: #66bb6a; top: -30px;">
                  <i class="fas fa-list-ul fa-3x fa-fw"></i>
                </div>
                <h5 class="card-title m-0 me-auto">
                  <?php echo $lang['Total'], $lang['Services']; ?>
                  <span class="d-block display-6">
                    <?php echo countItems('ServiceId', 'services') ?>
                  </span>
                </h5>
              </div>
              <div class="card-footer bg-transparent">
                <a href="services.php" class="btn hvr-bounce-in shadow-none"><?php echo $lang['MoreDetails']; ?></a>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card my-4 mx-auto px-2 " style="max-width: 18rem;">
              <div class="card-header p-2 d-flex justify-content-end position-relative">
                <div class="icon position-absolute rounded p-4 bg-info" style="top: -30px;">
                  <i class="fas fa-user-tie fa-3x"></i>
                </div>
                <h5 class="card-title m-0 me-auto">
                  <?php echo $lang['Total'], $lang['Employees']; ?>
                  <span class="d-block display-6">
                    <?php echo countItems('EmpId', 'employees', "WHERE Job = 'Reception'") ?>
                  </span>
                </h5>
              </div>
              <div class="card-footer bg-transparent">
                <a href="employees.php" class="btn hvr-bounce-in shadow-none"><?php echo $lang['MoreDetails']; ?></a>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card my-4 mx-auto px-2" style="max-width: 18rem;">
              <div class="card-header p-2 d-flex justify-content-end position-relative">
                <div class="icon position-absolute rounded p-4" style="background-color: #5740ec; top: -30px;">
                  <i class="fas fa-users fa-3x fa-fw"></i>
                </div>
                <h5 class="card-title m-0 me-auto">
                  <?php echo $lang['Total'], $lang['Clients']; ?>
                  <span class="d-block display-6">
                    <?php echo countItems('ClientId', 'clients') ?>
                  </span>
                </h5>
              </div>
              <div class="card-footer bg-transparent">
                <a href="clients.php" class="btn hvr-bounce-in shadow-none"><?php echo $lang['MoreDetails']; ?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Dashboard -->
    <?php
  }
  else
  {
    header('location: /Daarna-Hotel/index.php');
  }
  require '../../global/footer.php';
?>