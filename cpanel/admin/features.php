<?php
  ob_start();
  require "../../global/DBOperations.php";
  $PageName = $lang['Features'];
  $Page = 'Features';
  require "../../global/header.php";
  if (isset($_SESSION['AdminId']))
  {
    ?>
    <!-- Start Breadcrumb -->
    <nav class="p-2 mb-2 rounded navBredcrumb" aria-label="breadcrumb">
      <div class="container">
        <ol class="breadcrumb my-3">
          <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase" href="index.php"><?php echo $lang['ControlPanel']; ?></a></li>
          <li class="breadcrumb-item breadcrumb-link fw-bold text-decoration-none text-uppercase active" aria-current="page"><?php echo $lang['Features']; ?></li>
        </ol>
      </div>
    </nav>
    <!-- End Breadcrumb -->
    <!-- Start Table Features -->
    <section class="table-customize-feature my-3">
      <div class="container">
        <h1 class="text-center my-3"><?php echo $lang['Manage'] . $lang['Features']; ?></h1>
        <!-- Start Modal For Add And Edit Feature -->
        <button  type="submit" class="btn btn-success ButtonFormFeature my-2 hvr-forward shadow-none" id="ButtonFormFeature" data-bs-toggle="modal" data-bs-target="#comfirmAddAndEditFeature" data-balloon-pos="up" data-balloon-nofocus data-ball aria-label="<?php echo $lang['NewFeature']; ?>">
          <i class="fas fa-plus"></i>
        </button>
        <div class="modal fade CostumizeModalFeature" id="comfirmAddAndEditFeature" data-bs-keyboard="false" tabindex="-1" aria-labelledby="HeaderAddEditFeature" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered flex-column justify-content-center">
            <div class="modal-content" id="AddEditFeatureTemplate">
              <div class="modal-header">
                <h5 class="modal-title" id="HeaderAddEditFeature"><?php echo $lang['NewFeature']; ?></h5>
              </div>
              <div class="modal-body">
                <form class="row was-validated FormNewFeature" id="FormNewFeature">
                  <div class="col-md-6 mb-2">
                    <label for="FeatureName" class="form-label"><?php echo $lang['FeatureName']; ?></label>
                    <select class="form-select" name="FeatureName" id="FeatureName" required>
                      <option value="1"><?php echo $lang['Room']; ?></option>
                      <option value="2"><?php echo $lang['Bath']; ?></option>
                      <option value="3"><?php echo $lang['Bed']; ?></option>
                      <option value="4"><?php echo $lang['TV']; ?></option>
                      <option value="5"><?php echo $lang['AC']; ?></option>
                      <option value="6"><?php echo $lang['Stove']; ?></option>
                      <option value="7"><?php echo $lang['Oven']; ?></option>
                      <option value="8"><?php echo $lang['Fridge']; ?></option>
                      <option value="9"><?php echo $lang['Laundry']; ?></option>
                      <option value="10"><?php echo $lang['Cooler']; ?></option>
                    </select>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label for="Price" class="form-label"><?php echo $lang['Price']; ?></label>
                    <input type="number" name="Price" class="form-control" id="Price" min="0.00" step="0.01" placeholder="0.00" autocomplete="off" required>
                  </div>
                  <div class="col-md-12 mb-3">
                    <label for="Details" class="form-label"><?php echo $lang['Details']; ?></label>
                    <textarea name="Details" class="form-control" id="Details" style="height: 150px; resize:none;" autocomplete="off" required></textarea>
                  </div>
                  <div class="modal-footer pt-2 pb-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo $lang['Close']; ?></button>
                    <button type="submit" id="ButtonAddFeature" class="btn btn-outline-success"><?php echo $lang['Add']; ?></button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- End Modal For Add And Edit Feature -->
        <!-- Start Modal For Delete -->
        <div class="modal fade" id="confirmTheDelete" data-bs-keyboard="false" tabindex="-1" aria-labelledby="WarningTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered flex-column justify-content-center">
            <div class="modal-content" id="DeleteFeatureTemplate">
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
                <button type="button" class="btn btn-outline-danger" id="ButtonRemoveFeature" ><?php echo $lang['Delete']; ?></button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Modal For Delete -->
        <!-- Start Table -->
      </div>
    </section>
    <!-- End Table Features -->
    <?php
  }
  else
  {
    header('location: /Daarna-Hotel/index.php');
  }
  require '../../global/footer.php';
?>