<?php
  ob_start();
  require "../../global/DBOperations.php";
  $PageName = $lang['Employees'];
  $Page = 'Employees';
  require "../../global/header.php";
  if (isset($_SESSION['AdminId']))
  {
    ?>
    <!-- Start Breadcrumb -->
    <nav class="p-2 mb-2 rounded navBredcrumb" aria-label="breadcrumb">
      <div class="container">
        <ol class="breadcrumb my-3">
          <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase" href="index.php"><?php echo $lang['ControlPanel']; ?></a></li>
          <li class="breadcrumb-item breadcrumb-link fw-bold text-decoration-none text-uppercase active" aria-current="page"><?php echo $lang['Employees']; ?></li>
        </ol>
      </div>
    </nav>
    <!-- End Breadcrumb -->
    <!-- Start Table Employees -->
    <section class="table-customize-employees my-3">
      <div class="container">
        <h1 class="text-center my-3"><?php echo $lang['Manage'] . $lang['Employees']; ?></h1>
        <!-- Start Modal For Add And Edit Employees -->
        <button  type="submit" class="btn btn-success ButtonFormEmployees my-2 hvr-forward shadow-none" id="ButtonFormEmployees" data-bs-toggle="modal" data-bs-target="#comfirmAddAndEditEmployees" data-balloon-pos="up" data-balloon-nofocus data-ball aria-label="<?php echo $lang['NewEmployee']; ?>">
          <i class="fas fa-plus"></i>
        </button>
        <div class="modal fade CostumizeModalEmployees" id="comfirmAddAndEditEmployees" data-bs-keyboard="false" tabindex="-1" aria-labelledby="HeaderAddEditEmployees" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered flex-column justify-content-center">
            <div class="modal-content" id="AddEditEmployeesTemplate">
              <div class="modal-header">
                <h5 class="modal-title" id="HeaderAddEditEmployees"><?php echo $lang['NewEmployee']; ?></h5>
              </div>
              <div class="modal-body">
                <form class="row was-validated FormNewEmployees" id="FormNewEmployees">
                  <div class="row g-2 mb-3">
                    <div class="col-12">
                      <div class="form-floating m-1">
                        <input type="text" name="UserName" class="form-control" id="UserName" placeholder="UserName" minlength="4" autocomplete="off" required>
                        <label for="UserName"><i class="far fa-user-circle me-1"></i><?php echo $lang['UserName']; ?></label>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-floating m-1">
                        <input type="password" class="form-control" name="Password" id="Password" minlength="8" placeholder="Password" required>
                        <label for="Password"><i class="fas fa-user-lock me-1"></i><?php echo $lang['Password']; ?></label>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer pt-2 pb-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo $lang['Close']; ?></button>
                    <button type="submit" id="ButtonAddEmployees" class="btn btn-outline-success"><?php echo $lang['Add']; ?></button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- End Modal For Add And Edit Employees -->
        <!-- Start Modal For Block -->
        <div class="modal fade" id="confirmTheBlockEmployees" data-bs-keyboard="false" tabindex="-1" aria-labelledby="WarningTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title text-warning" id="WarningTitle"><i class="fas fa-exclamation me-2 fs-5"></i><?php echo $lang['Warning']; ?></h5>
              </div>
              <div class="modal-body">
                <div class="d-flex align-items-center" role="alert">
                  <svg class="mx-2 text-warning" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                  </svg>
                  <div class="content">
                    <?php echo $lang['Warning:AreYouSureAboutThat']; ?>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo $lang['Close']; ?></button>
                <button type="button" class="btn btn-outline-danger" id="ButtonBlockEmployee" ><?php echo $lang['Block']; ?></button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Modal For Block -->
      </div>
    </section>
    <!-- End Table Employees -->
    <?php
  }
  else
  {
    header('location: /Daarna-Hotel/index.php');
  }
  require '../../global/footer.php';
?>