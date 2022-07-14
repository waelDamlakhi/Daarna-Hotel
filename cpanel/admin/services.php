<?php
  ob_start();
  require "../../global/DBOperations.php";
  $PageName = $lang['Services'];
  $Page = 'Services';
  require "../../global/header.php";
  if (isset($_SESSION['AdminId']))
  {
    ?>
    <!-- Start Breadcrumb -->
    <nav class="p-2 mb-2 rounded navBredcrumb" aria-label="breadcrumb">
      <div class="container">
        <ol class="breadcrumb my-3">
          <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase" href="index.php"><?php echo $lang['ControlPanel']; ?></a></li>
          <li class="breadcrumb-item breadcrumb-link fw-bold text-decoration-none text-uppercase active" aria-current="page"><?php echo $lang['Services']; ?></li>
        </ol>
      </div>
    </nav>
    <!-- End Breadcrumb -->
    <!-- Start Table Services -->
    <section class="table-customize-services my-3">
      <div class="container">
        <h1 class="text-center my-3"><?php echo $lang['Manage'] . $lang['Services']; ?></h1>
        <!-- Start Modal For Add And Edit Services -->
        <button class="btn btn-success ButtonFormAddServices my-2 hvr-forward shadow-none" id="ButtonFormAddServices" data-bs-toggle="modal" data-bs-target="#ComfirmAddService" data-balloon-pos="up" data-balloon-nofocus data-ball aria-label="<?php echo $lang['NewService']; ?>">
          <i class="fas fa-plus"></i>
        </button>
        <div class="modal fade ComfirmAddService" id="ComfirmAddService" data-bs-keyboard="false" tabindex="-1" aria-labelledby="HeaderAddService" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered flex-column justify-content-center">
            <div class="modal-content" id="AddServiceTemplate">
              <div class="modal-header">
                <h5 class="modal-title" id="HeaderAddService"><?php echo $lang['NewService']; ?></h5>
              </div>
              <div class="modal-body">
                <form class="row was-validated FormNewService" id="FormNewService">
                  <div class="col-12 mb-3">
                    <label for="ServiceName" class="form-label"><?php echo $lang['ServiceName']; ?></label>
                    <input type="text" name="ServiceName" class="form-control" id="ServiceName" placeholder="Service" autocomplete="off" required>
                  </div>
                  <div class="modal-footer pt-2 pb-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo $lang['Close']; ?></button>
                    <button type="submit" class="btn btn-outline-success"><?php echo $lang['Add']; ?></button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- End Modal For Add And Edit Services -->
        <!-- Start Modal For Delete -->
        <div class="modal fade" id="confirmTheDelete" data-bs-keyboard="false" tabindex="-1" aria-labelledby="WarningTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered flex-column justify-content-center">
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
                <button type="button" class="btn btn-outline-danger" id="ButtonRemoveService"><?php echo $lang['Delete']; ?></button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Modal For Delete -->
        <!-- Start table -->
      </div>
    </section>
    <!-- End Table Services -->
    <?php
  }
  else
  {
    header('location: /Daarna-Hotel/index.php');
  }
  require '../../global/footer.php';
?>