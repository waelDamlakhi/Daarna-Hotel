<?php
  ob_start();
  require "../../global/DBOperations.php";
  $Page = isset($_GET['Page']) ? $_GET['Page'] : 'Floors';
  if (isset($_SESSION['AdminId']))
  {
    if ($Page == 'Floors')
    {
      $PageName = $lang['Floors'];
      require "../../global/header.php";
      ?>
      <!-- Start Breadcrumb -->
      <nav class="p-2 mb-2 rounded navBredcrumb" aria-label="breadcrumb">
        <div class="container">
          <ol class="breadcrumb my-3">
            <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase" href="index.php"><?php echo $lang['ControlPanel']; ?></a></li>
            <li class="breadcrumb-item breadcrumb-link fw-bold text-decoration-none text-uppercase active" aria-current="page"><?php echo $lang['Floors']; ?></li>
          </ol>
        </div>
      </nav>
      <!-- End Breadcrumb -->
      <!-- Start Table Floors -->
      <section class="table-customize-floor my-3">
        <div class="container">
          <h1 class="text-center my-3"><?php echo $lang['Manage'] . $lang['Floors']; ?></h1>
          <button  type="button" class="btn ButtonAddFloor btn-success m-2 hvr-grow shadow-none" id="ButtonAddFloor" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="<?php echo $lang['NewFloor']; ?>">
            <i class="fas fa-plus"></i>
          </button>
          <!-- Start Modal For Delete -->
          <button  type="button" class="btn ButtonRemoveFloor btn-danger my-2 hvr-shrink shadow-none" data-bs-toggle="modal" data-bs-target="#confirmTheDelete" data-balloon-pos="up" data-balloon-nofocus data-ball aria-label="<?php echo $lang['RemoveAFloor']; ?>">
            <i class="fas fa-minus"></i>
          </button>
          <div class="modal fade" id="confirmTheDelete" data-bs-keyboard="false" tabindex="-1" aria-labelledby="WarningTitle" aria-hidden="true">
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
                  <button type="button" class="btn btn-outline-danger" id="ButtonRemoveFloor" data-bs-dismiss="modal"><?php echo $lang['Delete']; ?></button>
                </div>
              </div>
            </div>
          </div>
          <!-- End Modal For Delete -->
          <!-- Start Table -->
        </div>
      </section>
      <!-- End Table Floors -->
      <?php
    }
    elseif ($Page == 'Flats') 
    {
      $FloorId = isset($_GET['Id']) && is_numeric($_GET['Id']) ? intval($_GET['Id']) : 0;
      $SelectFloor = $con->prepare('SELECT * FROM floors WHERE FloorId = ?');
      $SelectFloor->execute(array($FloorId));
      if ($SelectFloor->rowCount() > 0)
      {
        $PageName = $lang['Flats'];
        require "../../global/header.php";
        ?>
        <!-- Start Breadcrumb -->
        <nav class="p-2 mb-2 rounded navBredcrumb" aria-label="breadcrumb">
          <div class="container">
            <ol class="breadcrumb my-3">
              <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase" href="index.php"><?php echo $lang['ControlPanel']; ?></a></li>
              <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase" href="floors.php"><?php echo $lang['Floors']; ?></a></li>
              <li class="breadcrumb-item breadcrumb-link fw-bold text-decoration-none text-uppercase active FloorId" aria-current="page"><?php echo $lang['Floor'],' [ ', $FloorId, ' ]'; ?></li>
            </ol>
          </div>
        </nav>
        <!-- End Breadcrumb -->
        <!-- Start Table Flats -->
        <section class="table-customize-flat my-3">
          <div class="container">
            <h1 class="text-center my-3"><?php echo $lang['Manage'] . $lang['Flats']; ?></h1>
            <!-- Start Add Flat -->
            <a href="?Page=NewFlat&Id=<?php echo $FloorId; ?>" class="btn btn-success my-2 hvr-grow ButtonFormAddFlat shadow-none" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="<?php echo $lang['NewFlat']; ?>">
              <i class="fas fa-plus"></i>
            </a>
            <!-- End Add Flat -->
            <!-- Start Modal For Delete -->
            <div class="modal fade" id="confirmTheDelete" data-bs-keyboard="false" tabindex="-1" aria-labelledby="WarningTitle" aria-hidden="true">
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
                    <button type="button" class="btn btn-outline-danger" id="ButtonRemoveFlat" data-bs-dismiss="modal"><?php echo $lang['Delete']; ?></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Modal For Delete -->
            <!-- Start Table -->
          </div>
        </section>
        <!-- End Table Flats -->
        <?php
      }
      else
      {
        header('location: /Daarna-Hotel/not-found.php');
      }
    }
    elseif ($Page == 'NewFlat')
    {
      $FloorId = isset($_GET['Id']) && is_numeric($_GET['Id']) ? intval($_GET['Id']) : 0;
      $SelectFloor = $con->prepare('SELECT * FROM floors WHERE FloorId = ?');
      $SelectFloor->execute(array($FloorId));
      if ($SelectFloor->rowCount() > 0)
      {
        $PageName = $lang['NewFlat'];
        require "../../global/header.php";
        ?>
        <!-- Start Breadcrumb -->
        <nav class="p-2 mb-2 rounded navBredcrumb" aria-label="breadcrumb">
          <div class="container">
            <ol class="breadcrumb my-3">
              <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase" href="index.php"><?php echo $lang['ControlPanel']; ?></a></li>
              <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase" href="floors.php"><?php echo $lang['Floors']; ?></a></li>
              <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase FloorId" href="floors.php?Page=Flats&Id=<?php echo $FloorId; ?>"><?php echo $lang['Floor'],' [ ', $FloorId, ' ]'; ?></a></li>
              <li class="breadcrumb-item breadcrumb-link fw-bold text-decoration-none text-uppercase active" aria-current="page"><?php echo $lang['NewFlat'];?></li>
            </ol>
          </div>
        </nav>
        <!-- End Breadcrumb -->
        <!-- Start Modal No Features -->
        <div class="modal fade" id="ComfirmNotFeatureInFlat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="WarningTitle" aria-hidden="true">
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
                    <?php echo $lang['Warning:NoHotelFeaturesHaveBeenIntroducedYet']; ?>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-warning shadow-none" data-bs-dismiss="modal" onclick="history.back();"><?php echo $lang['GoBack']; ?></button>
                <a href="features.php" class="btn btn-outline-danger shadow-none"><?php echo $lang['AddNow']; ?></a>
              </div>
            </div>
          </div>
        </div>
        <!-- End Modal No Features -->
        <!-- Start Modal Flat Features Empty -->
        <div class="modal fade" id="ComfirmFlatFeaturesEmpty" data-bs-keyboard="false" tabindex="-1" aria-labelledby="WarningTitle" aria-hidden="true">
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
                    <?php echo $lang['Warning:NoPrimaryFeaturesHaveBeenSelectedYet.']; ?>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-warning shadow-none" data-bs-dismiss="modal"><?php echo $lang['Close']; ?></button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Modal Flat Features Empty -->
        <!-- Start New Flat -->
        <section class="SectionAddFlat my-3" id="flatfeature">
          <div class="container">
            <h1 class="text-center my-3"><?php echo $lang['NewFlat']; ?></h1>
            <!-- Start Form Add Flat -->
            <form class="row was-validated FormNewFlat" id="FormNewFlat">
              <div class="col-6 mb-2">
                <label for="FlatId" class="form-label"><?php echo $lang['FlatId']; ?></label>
                <input type="number" name="FlatId" class="form-control" id="FlatId" min="1" placeholder="0" autocomplete="off" required>
              </div>
              <div class="col-6 mb-2">
                <label for="FlatArea" class="form-label"><?php echo $lang['FlatArea']; ?></label>
                <input type="number" name="Area" class="form-control" id="FlatArea" min="1" placeholder="m&sup2" autocomplete="off" required>
              </div>
              <div class="col-6 mb-2">
                <label for="View" class="form-label"><?php echo $lang['View']; ?></label>
                <select class="form-select" name="View" id="View" required>
                  <option value="North"><?php echo $lang['North']; ?></option>
                  <option value="East"><?php echo $lang['East']; ?></option>
                  <option value="South"><?php echo $lang['South']; ?></option>
                  <option value="West"><?php echo $lang['West']; ?></option>
                  <option value="NorthEast"><?php echo $lang['NorthEast']; ?></option>
                  <option value="EastSouth"><?php echo $lang['EastSouth']; ?></option>
                  <option value="SouthWest"><?php echo $lang['SouthWest']; ?></option>
                  <option value="WestNorth"><?php echo $lang['WestNorth']; ?></option>
                </select>
              </div>
              <div class="col-6">
                <label class="form-label"><?php echo $lang['MainImage']; ?></label>
                <div class="input-group">
                  <input type="file" class="form-control" name="MainImage" accept="image/webp" id="MainImage" required>
                  <label class="input-group-text uploadImg px-3" for="MainImage"><i class="fas fa-upload" aria-hidden="true"></i></label>
                </div>
              </div>
              <div class="col-12 lineBeforFeature">
                <label class="form-label"><?php echo $lang['OtherImage']; ?></label>
                <div class="input-group">
                  <input type="file" class="form-control" name="OtherImage[]" id="OtherImage" accept="image/webp" multiple required>
                  <label class="input-group-text uploadImg px-3" for="OtherImage"><i class="fas fa-upload" aria-hidden="true"></i></label>
                </div>
              </div>
              <div class="col-12 mb-2" id="singleflatfeature">
                <button class="btn btn-success hvr-wobble-skew shadow-none BottomAddFeatuerToFlat" type="button" data-bs-toggle="modal" data-bs-target="#ComfirmAddFeatureToFlat" aria-label="<?php echo $lang['AddFeature']; ?>" data-balloon-nofocus data-balloon-pos="up"><i class="fas fa-plus"></i></button>
              </div>
              <div class="col-12">
                <button class="btn btn-success hvr-pulse-grow shadow-none" type="submit" id="BottomAddFlat" aria-label="<?php echo $lang['AddFlat']; ?>" data-balloon-nofocus data-balloon-pos="up"><?php echo $lang['Add']; ?></button>
              </div>
            </form>
            <!-- End Form Add Flat -->
            <!-- Start Modal For Add Featuer To Flat -->
            <div class="modal fade ComfirmAddFeatureToFlat" id="ComfirmAddFeatureToFlat" data-bs-keyboard="false" tabindex="-1" aria-labelledby="AddFeatuerTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered flex-column justify-content-center">
                <div class="modal-content" id="AddEditFeatureTemplate">
                  <div class="modal-header">
                    <h5 class="modal-title" id="AddFeatuerTitle"><?php echo $lang['AddFeature']; ?></h5>
                  </div>
                  <div class="modal-body">
                    <form class="row was-validated FormAddFeature" id="FormAddFeature">
                      <div class="col-md-6 mb-2">
                        <label for="FeatureName" class="form-label"><?php echo $lang['FeatureName']; ?></label>
                        <select class="form-select" name="FeatureName" id="FeatureName" required>
                        </select>
                      </div>
                      <div class="col-md-6 mb-2">
                        <label for="Details" class="form-label"><?php echo $lang['Details']; ?></label>
                        <select class="form-select" name="Details" id="Details" required>
                        </select>
                      </div>
                      <div class="col-md-12 mb-3">
                        <label for="Quantity" class="form-label"><?php echo $lang['Quantity']; ?></label>
                        <input type="number" name="Quantity" class="form-control" id="Quantity" min="1" placeholder="1" autocomplete="off" required>
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
            <!-- End Modal For Add Featuer To Flat -->
            <!-- Start Modal For Delete -->
            <div class="modal fade" id="confirmTheDelete" data-bs-keyboard="false" tabindex="-1" aria-labelledby="WarningTitle" aria-hidden="true">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $lang['Close']; ?></button>
                    <button type="button" class="btn btn-outline-danger" id="ButtonRemoveFeatureFromFlat" data-bs-dismiss="modal"><?php echo $lang['Delete']; ?></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Modal For Delete -->
          </div>
        </section>
        <!-- End New Flat -->
        <?php
      }
      else
      {
        header('location: /Daarna-Hotel/not-found.php');
      }
    }
  }
  else
  {
    header('location: /Daarna-Hotel/index.php');
  }
  require '../../global/footer.php';
?>