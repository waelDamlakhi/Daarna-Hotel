<?php
  ob_start();
  require "global/DBOperations.php";
  // For Title In Header
  $PageName = $lang['Flat'];
  // For Body Name
  $Page = 'flatPage';
  require 'global/header.php';
  $FlatId = isset($_GET['FlatId']) && is_numeric($_GET['FlatId']) ? intval($_GET['FlatId']) : 0;
  $FloorId = isset($_GET['FloorId']) && is_numeric($_GET['FloorId']) ? intval($_GET['FloorId']) : 0;
  $GETDataFlat = $con->prepare("SELECT 
  (
    SELECT SUM(Rooms.Quantity) FROM flat_features AS Rooms, hotel_features AS HotelRoom WHERE flats.FlatId = Rooms.FlatId 
    AND flats.FloorId = Rooms.FloorId AND Rooms.FeatureId = HotelRoom.Id AND HotelRoom.FeatureId = 1
  ) AS RoomCount,
  (
    SELECT SUM(Beds.Quantity) FROM flat_features AS Beds, hotel_features AS HotelBed WHERE flats.FlatId = Beds.FlatId 
    AND flats.FloorId = Beds.FloorId AND Beds.FeatureId = HotelBed.Id AND HotelBed.FeatureId = 3
  ) AS BedCount,
  (
    SELECT SUM(Baths.Quantity) FROM flat_features AS Baths, hotel_features AS HotelBath WHERE flats.FlatId = Baths.FlatId 
    AND flats.FloorId = Baths.FloorId AND Baths.FeatureId = HotelBath.Id AND HotelBath.FeatureId = 2
  ) AS BathCount,
  (
    SELECT SUM(Price.Quantity * HotelPrice.Price) FROM flat_features AS Price, hotel_features AS HotelPrice WHERE flats.FlatId = Price.FlatId 
    AND flats.FloorId = Price.FloorId AND Price.FeatureId = HotelPrice.Id
  ) AS Price,
  (
    SELECT ROUND(AVG(booking.Rate)) FROM booking WHERE flats.FloorId = booking.FloorId AND flats.FlatId = booking.FlatId
  ) AS Rate,
  flats.* FROM flats WHERE FloorId = ? AND FlatId = ?");
  $GETDataFlat->execute(array($FloorId, $FlatId));
  if ($GETDataFlat->rowCount() > 0)
  {
    $Data = $GETDataFlat->fetch();
    if (substr($_SERVER['HTTP_REFERER'], 43, 10) === 'floors.php')
    {
      ?>
      <!-- Start Breadcrumb -->
      <nav class="p-2 mb-2 rounded navBredcrumb" aria-label="breadcrumb">
        <div class="container">
          <ol class="breadcrumb my-3">
            <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase" href="cpanel/admin/index.php"><?php echo $lang['ControlPanel']; ?></a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase" href="cpanel/admin/floors.php"><?php echo $lang['Floors']; ?></a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase" href="cpanel/admin/floors.php?Page=Flats&Id=<?php echo $FlatId; ?>"><?php echo $lang['Floor'],' [ ', $FloorId, ' ]'; ?></a></li>
            <li class="breadcrumb-item breadcrumb-link fw-bold text-decoration-none text-uppercase active" id="getflatid" data-floorid="<?php echo $FloorId ?>" data-flatid="<?php echo $FlatId ?>" aria-current="page"><?php echo $lang['Flat'],' [ ', $FlatId, ' ]'; ?></li>
          </ol>
        </div>
      </nav>
      <!-- End Breadcrumb -->
      <?php
    }
    else
    {
      ?>
      <!-- Start Breadcrumb -->
      <nav class="p-2 mb-4 rounded navBredcrumb" aria-label="breadcrumb">
        <div class="container">
          <ol class="breadcrumb my-3">
            <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase" href="index.php"><?php echo $lang['Home']; ?></a></li>
            <li class="breadcrumb-item breadcrumb-link fw-bold text-decoration-none text-uppercase active" id="getflatid" data-floorid="<?php echo $FloorId ?>" data-flatid="<?php echo $FlatId ?>" aria-current="page"><?php echo $lang['Floor'],' [ ', $FloorId, ' ]', ' | ', $lang['Flat'],' [ ', $FlatId, ' ]'; ?></li>
          </ol>
        </div>
      </nav>
      <!-- End Breadcrumb -->
      <?php
    }
    ?>
    <!-- Start Single Flat Information -->
    <section class="section-single-flat my-3">
      <div class="container">
        <h1 class="text-center mb-3"><?php echo $lang['FlatInformation']; ?></h1>
        <div class="row">
          <div class="col-lg-4 mb-2 mb-lg-0">
            <form class="row was-validated" id="FormUpdateFlatInfo">
              <div class="col-6">
                <h4><?php echo $lang['FlatInfo']; ?></h4>
              </div>
              <div class="col-6">
                <?php
                  if (isset($_SESSION['Admin']))
                  {
                    ?>
                    <a class="EditFlatInfo text-success" id="EditFlatInfo" role="botton" aria-label="<?php echo $lang['Edit']; ?>" data-balloon-nofocus data-balloon-pos="up"><i class="fas fa-edit fa-fw"></i></a>
                    <?php
                  }
                ?>
              </div>
              <div class="col-6 d-flex justify-content-end d-none align-items-center fs-5">
                <?php
                  if (isset($_SESSION['Admin']))
                  {
                    ?>
                    <button type="submit" class="save btn text-success shadow-none" id="save" aria-label="<?php echo $lang['Save']; ?>" data-balloon-nofocus data-balloon-pos="up"><i class="fa-solid fa-check fa-fw fs-5"></i></button>
                    <a class="Cancel text-danger" id="Cancel" role="botton" aria-label="<?php echo $lang['Cancel']; ?>" data-balloon-nofocus data-balloon-pos="up"><i class="fa-solid fa-xmark fa-fw"></i></a>
                    <?php
                  }
                ?>
              </div>
              <div class="col-6 bgDark">
                <div class="p-1 d-flex align-items-center">
                  <i class="fa-solid fa-stairs fa-fw me-2"></i>
                  <span class="ms-5" id="ShowFloorId"><?php echo strlen($FloorId) > 1 ? $FloorId : '0' . $FloorId ?></span>
                  <?php
                    if (isset($_SESSION['Admin']))
                    {
                      ?>
                      <select class="form-select form-select-sm shadow-none d-none" name="Floor" id="Floor">
                        <?php
                          $GetAllFloors = $con->prepare("SELECT FloorId FROM floors");
                          $GetAllFloors->execute();
                          $Floors = $GetAllFloors->fetchAll();
                          foreach ($Floors as $Floor) 
                          {
                            ?>
                            <option value="<?php echo $Floor['FloorId'] ?>" <?php echo $FloorId == $Floor['FloorId'] ? 'selected' : '' ?>><?php echo strlen($Floor['FloorId']) > 1 ? $Floor['FloorId'] : '0' . $Floor['FloorId'] ?></option>
                            <?php
                          }
                        ?>
                      </select>
                      <?php
                    }
                  ?>
                </div>
              </div>
              <div class="col-6 bgDark">
                <div class="p-1 d-flex align-items-center">
                  <i class="fa-solid fa-door-closed fa-fw me-2"></i>
                  <span class="ms-5" id="ShowFlatId"><?php echo strlen($FlatId) > 1 ? $FlatId : '0' . $FlatId ?></span>
                  <?php
                    if (isset($_SESSION['Admin']))
                    {
                      ?>
                      <input type="number" name="Flat" value="<?php echo $FlatId ?>" class="form-control form-control-sm shadow-none d-none" id="Flat" min="1" placeholder="1" autocomplete="off" required>
                      <?php
                    }
                  ?>
                </div>
              </div>
              <div class="col-6">
                <div class="p-1 d-flex align-items-center">
                  <i class="fa-solid fa-binoculars fa-fw me-2"></i>
                  <span class="ms-5" id="ShowView"><?php echo $lang[$Data['View']] ?></span>
                  <?php
                    if (isset($_SESSION['Admin']))
                    {
                      ?>
                      <select class="form-select form-select-sm shadow-none d-none" name="View" id="View">
                        <option value="North" <?php echo $Data['View']  == 'North' ? 'selected' : '' ?>><?php echo $lang['North']; ?></option>
                        <option value="East" <?php echo $Data['View']  == 'East' ? 'selected' : '' ?>><?php echo $lang['East']; ?></option>
                        <option value="South" <?php echo $Data['View']  == 'South' ? 'selected' : '' ?>><?php echo $lang['South']; ?></option>
                        <option value="West" <?php echo $Data['View']  == 'West' ? 'selected' : '' ?>><?php echo $lang['West']; ?></option>
                        <option value="NorthEast" <?php echo $Data['View']  == 'NorthEast' ? 'selected' : '' ?>><?php echo $lang['NorthEast']; ?></option>
                        <option value="EastSouth" <?php echo $Data['View']  == 'EastSouth' ? 'selected' : '' ?>><?php echo $lang['EastSouth']; ?></option>
                        <option value="SouthWest" <?php echo $Data['View']  == 'SouthWest' ? 'selected' : '' ?>><?php echo $lang['SouthWest']; ?></option>
                        <option value="WestNorth" <?php echo $Data['View']  == 'WestNorth' ? 'selected' : '' ?>><?php echo $lang['WestNorth']; ?></option>
                      </select>
                      <?php
                    }
                  ?>
                </div>
              </div>
              <div class="col-6">
                <div class="p-1 d-flex align-items-center">
                  <i class="fa-solid fa-maximize fa-fw me-2"></i>
                  <span class="ms-5" id="ShowArea"><?php echo $Data['Area'] ?></span>
                  <?php
                    if (isset($_SESSION['Admin']))
                    {
                      ?>
                      <input type="number" name="Area" value="<?php echo $Data['Area'] ?>" class="form-control form-control-sm shadow-none d-none" id="FlatArea" min="1" placeholder="m&sup2" autocomplete="off" required>
                      <?php
                    }
                  ?>
                </div>
              </div>
              <div class="col-6 bgDark">
                <div class="p-1">
                  <i class="fa-solid fa-house fa-fw"></i>
                  <span class="ms-5"><?php echo strlen($Data['RoomCount']) > 1 ? $Data['RoomCount'] : '0' . $Data['RoomCount'] ?></span>
                </div>
              </div>
              <div class="col-6 bgDark">
                <div class="p-1">
                  <i class="fa-solid fa-bed fa-fw"></i>
                  <span class="ms-5"><?php echo strlen($Data['BedCount']) > 1 ? $Data['BedCount'] : '0' . $Data['BedCount'] ?></span>
                </div>
              </div>
              <div class="col-6">
                <div class="p-1">
                  <i class="fa-solid fa-bath fa-fw"></i>
                  <span class="ms-5"><?php echo strlen($Data['BathCount']) > 1 ? $Data['BathCount'] : '0' . $Data['BathCount'] ?></span>
                </div>
              </div>
              <div class="col-6">
                <div class="p-1">
                  <i class="fa-solid fa-dollar-sign fa-fw"></i>
                  <?php
                    if (isset($_SESSION['Client'])) 
                    {
                      $GetClientDiscount = $con->prepare("SELECT Value FROM discounts WHERE ClientId = ? AND Start <= CURDATE() AND End >= CURDATE()");
                      $GetClientDiscount->execute(array($_SESSION['ClientId']));
                      if ($GetClientDiscount->rowCount() > 0) 
                      {
                        $Discount = $GetClientDiscount->fetchColumn();
                        $FinalPrice = $Data['Price'] - ($Data['Price'] * $Discount);
                        ?>
                        <span class="ms-5"><?php echo $Data['Price'] . " => " . $FinalPrice ?> </span>
                        <?php
                      }
                      else 
                      {
                        $FinalPrice = $Data['Price'];
                        ?>
                        <span class="ms-5"><?php echo $Data['Price'] ?></span>
                        <?php
                      }
                    }
                    else 
                    {
                      $FinalPrice = $Data['Price'];
                      ?>
                      <span class="ms-5"><?php echo $Data['Price'] ?></span>
                      <?php
                    }
                  ?>
                </div>
              </div>
              <div class="col-6 bgDark">
                <div class="p-1">
                  <i class="fa fa-star text-light fa-fw"></i>
                  <span class="ms-5"><?php echo $Data['Rate'] == null ? $lang['NotRated'] : '(5/' . $Data['Rate'] . ')'?></span>
                </div>
              </div>
              <div class="col-6 bgDark">
                <div class="p-1">
                  <i class="fa<?php echo $Data['Rate'] >= 1 ? ' text-warning' : 'r' ?> fa-star"></i>
                  <i class="fa<?php echo $Data['Rate'] >= 2 ? ' text-warning' : 'r' ?> fa-star"></i>
                  <i class="fa<?php echo $Data['Rate'] >= 3 ? ' text-warning' : 'r' ?> fa-star"></i>
                  <i class="fa<?php echo $Data['Rate'] >= 4 ? ' text-warning' : 'r' ?> fa-star"></i>
                  <i class="fa<?php echo $Data['Rate'] == 5 ? ' text-warning' : 'r' ?> fa-star"></i>
                </div>
              </div>
              <div class="col-6">
                <h4 class="p-1 mt-2"><?php echo $lang['FlatImages']; ?></h4>
              </div>
              <?php
                if (isset($_SESSION['Admin']))
                {
                  ?>
                  <div class="col-6 mt-2 d-flex align-items-center">
                    <input type="file" class="form-control shadow-none" name="FlatImages[]" accept="image/webp" id="FlatImages" multiple hidden>
                    <a class="AddImages text-success" id="AddImagesForFlat" role="botton" aria-label="<?php echo $lang['Add']; ?>" data-balloon-nofocus data-balloon-pos="up"><i class="fa-solid fa-cloud-arrow-up fa-fw fs-4"></i></a>
                  </div>
                  <?php
                }
              ?>
            </form>
            <div id="flatimages">
              <div class="containerMainImageAndDelete position-relative">
                <img class="img-fluid" id="MainImage" src="photos/<?php echo $Data['MainImage'] ?>" />
                <div class="MainImage position-absolute bottom-0 start-0 p-2"><i class="fa-solid fa-house fa-fw"></i></div>
                <?php
                  if (isset($_SESSION['Admin']))
                  {
                    ?>
                    <div class="EditMainImg position-absolute bottom-0 end-0 text-center">
                      <input type="file" class="form-control shadow-none" name="FlatMainImage" accept="image/webp" id="FlatMainImage" hidden>
                      <button type="button" class="btn text-success shadow-none" id="EditFlatMainImage" aria-label="<?php echo $lang['Edit']; ?>" data-balloon-nofocus data-balloon-pos="up"><i class="fas fa-edit fa-fw"></i></button>
                    </div>
                    <?php
                  }
                ?>
              </div>
              <?php
                $images = explode(",", $Data['Images']);
                foreach ($images as $key => $image) 
                {
                  ?>
                  <div class="containerImageAndDelete p-1 position-relative">
                    <img class="img-fluid" src="photos/<?php echo $image ?>" />
                    <?php
                      if (COUNT($images) > 1 && isset($_SESSION['Admin'])) 
                      {
                        ?>
                        <div class="RemoveImgFromFlat position-absolute bottom-0 end-0 text-center">
                          <button type="button" class="btn text-danger shadow-none removeFlatImage" id="<?php echo $image ?>" data-bs-toggle="modal" data-bs-target="#confirmimageDelete" aria-label="<?php echo $lang['Delete']; ?>" data-balloon-nofocus data-balloon-pos="up"><i class="fa-solid fa-trash fa-fw"></i></button>
                        </div>
                        <?php
                      }
                    ?>
                  </div>
                  <?php
                }
              ?>
            </div>
          </div>
          <div class="col-lg-8">
            <div class="main-image">
              <img src="photos/<?php echo $Data['MainImage'] ?>" id="big-image" alt="Main Image" class="img-fluid">
            </div>
          </div>
        </div>
        <?php
          if (isset($_SESSION['Admin']))
          {
            ?>
            <!-- Start Modal For Delete -->
            <div class="modal fade" id="confirmimageDelete" data-bs-keyboard="false" tabindex="-1" aria-labelledby="WarningTitle" aria-hidden="true">
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
                    <button type="button" class="btn btn-outline-danger" id="ButtonRemoveFlatImage" data-bs-dismiss="modal"><?php echo $lang['Delete']; ?></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Modal For Delete -->
            <?php
          }
        ?>
      </div>
    </section>
    <!-- End Single Flat Information -->
    <!-- Start Flat Features -->
    <section class="section-flat-feature my-3" id="flatfeature">
      <div class="container" id="singleflatfeature">
        <h1 class="text-center mb-3"><?php echo $lang['FlatFeatures']; ?></h1>
        <?php 
          if (isset($_SESSION['Admin'])) 
          {
            ?>
            <!-- Start Modal For Add Featuer To Flat -->
            <button class="btn btn-success hvr-wobble-skew shadow-none BottomAddFeatuerToFlat" type="button" data-bs-toggle="modal" data-bs-target="#ComfirmAddFeatureToFlat" aria-label="<?php echo $lang['AddFeature']; ?>" data-balloon-nofocus data-balloon-pos="up"><i class="fas fa-plus"></i></button>
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
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo $lang['Close']; ?></button>
                    <button type="button" class="btn btn-outline-danger" id="ButtonRemoveFeatureFromFlat" data-bs-dismiss="modal"><?php echo $lang['Delete']; ?></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Modal For Delete -->
            <?php
          } 
        ?>
      </div>
    </section>
    <!-- End Flat Features -->
    <!-- Start Booking Now -->
    <section class="section-booking-now my-3">
      <div class="container">
        <h1 class=" text-center mb-3"><?php echo $lang['BookingNow'] ?></h1>
        <form class="bookingForm was-validated" id="bookingForm">
          <div class="row g-2">
            <?php 
              if (!isset($_SESSION['Client'])) 
              {
                ?>
                <div class="col-md-6">
                  <label for="User-Name" class="form-label"><?php echo $lang['UserName']; ?></label>
                  <input type="name" name="UserName" class="form-control" id="User-Name" placeholder="UserName" required>
                </div>
                <div class="col-md-6">
                  <label for="Pass" class="form-label"><?php echo $lang['Password']; ?></label>
                  <input type="password" class="form-control" name="Password" id="Pass" minlength="8" placeholder="Password" required>
                </div>
                <div class="col-md-6">
                  <label for="Phone" class="form-label"><?php echo $lang['Phone']; ?></label>
                  <input type="tel" class="form-control" name="Phone" id="Phone" pattern="[0][9][0-9]{8}" placeholder="0990416940" required>
                  <a tabindex="0" role="button" class="position-absolute Phone top-0 end-0 mt-3 mx-5" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Enter a valid phone number that works on the Syrian network">
                    <i class="fas fa-info-circle"></i>
                  </a>
                </div>
                <div class="col-md-6">
                  <label for="NationalId" class="form-label"><?php echo $lang['NationalId']; ?></label>
                  <input type="number" class="form-control" name="NationalId" id="NationalId" min="01111111111" max="9999999999" placeholder="National Id" required>
                </div>
                <div class="col-md-6">
                  <label for="Email" class="form-label"><?php echo $lang['Email']; ?></label>
                  <input type="email" class="form-control" name="Email" id="Email" placeholder="Email" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label"><?php echo $lang['IDImage']; ?></label>
                  <div class="input-group">
                    <input type="file" class="form-control" name="ID" accept="image/*" id="ID" required>
                    <label class="input-group-text uploadImg" for="ID"><i class="fas fa-upload" aria-hidden="true"></i></label>
                  </div>
                </div>
                <?php
              } 
            ?>
            <input type="hidden" name="FinalPrice" value="<?php echo $FinalPrice; ?>" />
            <div class="col-md-6 mb-2">
              <div id='calendar'></div>
            </div>
            <div class="col-md-6">
              <div class="row mt-5">
                <div class="col-12 mb-2">
                  <label for="EntryDate" class="form-label"><?php echo $lang['EntryDate']; ?></label>
                  <input type="date" class="form-control" name="EntryDate" id="EntryDate" onclick="this.min=new Date(Date.now() + 6.048e+8 ).toISOString().split('T')[0], this.showPicker()" required>
                </div>
                <div class="col-12">
                  <label for="ExitDate" class="form-label"><?php echo $lang['ExitDate']; ?></label>
                  <input type="date" class="form-control" name="ExitDate" id="ExitDate" disabled onclick="this.showPicker()" required>
                </div>
                <div class="col-12 mt-5 d-flex justify-content-center">
                  <?php
                    if (isset($_SESSION['Client']))
                    {
                      $GetClientBooking = $con->prepare("SELECT AcceptDate FROM booking WHERE ClientId = ?");
                      $GetClientBooking->execute(array($_SESSION['ClientId']));
                      if ($GetClientBooking->rowCount() == 1) 
                      {
                        if (!empty($GetClientBooking->fetchColumn())) 
                        {
                          ?>
                          <button type="submit" class="btn btn-outline-success hvr-grow"><i class="fas fa-check-double align-middle"></i> <?php echo $lang['BookingNow']; ?></button>
                          <?php
                        }
                        else 
                        {
                          ?>
                          <span class="btn btn-outline-info">asdfasdasd</span>
                          <?php
                        }
                      }
                      else 
                      {
                        ?>
                        <button type="submit" class="btn btn-outline-success hvr-grow"><i class="fas fa-check-double align-middle"></i> <?php echo $lang['BookingNow']; ?></button>
                        <?php
                      }
                    }
                    else 
                    {
                      ?>
                      <button type="submit" class="btn btn-outline-success hvr-grow" <?php echo COUNT($_SESSION) > 0 ? 'disabled' : '' ?>><i class="fas fa-check-double align-middle"></i> <?php echo $lang['BookingNow']; ?></button>
                      <?php
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>
    <!-- End Booking Now -->
    <!-- Start Flat Evaluation -->
    <section class="section-flat-evaluation text-center my-3">
      <div class="container">
        <h1 class="mb-3"><?php echo $lang['FlatRates'] ?></h1>
        <div class="flat-evaluation" style="height: 400px !important;">
          <?php
            $GetClient = $con->prepare("SELECT clients.* FROM clients JOIN booking ON booking.ClientId = clients.ClientId JOIN evaluation ON booking.BookId = evaluation.BookId");
            $GetClient->execute();
            if ($GetClient->rowCount() > 0) 
            {
              $Clients = $GetClient->fetchAll();
              foreach ($Clients as $Client) 
              {
                ?>
                <div class="overflow-auto" style="height: 400px !important;">
                  <img src="photos/<?php echo $Client['AccountImage'] ?>" alt="avatar" class="mx-auto rounded-circle img-fluid h-25">
                  <h4 class="mt-2"><?php echo $Client['UserName'] ?></h4>
                  <div class="row mw-100">
                    <?php
                      $GetServicesRate = $con->prepare("SELECT services.ServiceName, evaluation.Value, evaluation.Note FROM booking JOIN evaluation ON booking.BookId = evaluation.BookId AND booking.ClientId = ? AND booking.FloorId = ? AND booking.FlatId = ? JOIN services ON services.ServiceId = evaluation.ServiceId");
                      $GetServicesRate->execute(array($Client['ClientId'], $FloorId, $FlatId));
                      $Rates = $GetServicesRate->fetchAll();
                      foreach ($Rates as $Rate) 
                      {
                        ?>
                        <div class="col-md-6 col-lg-4 mb-2">
                          <div class="card mx-auto" style="width: 18rem;">
                            <div class="card-body">
                              <h5 class="card-title"><?php echo $Rate['ServiceName'] ?></h5>
                              <h6 class="card-subtitle mb-2 text-muted">
                              <i class="fa<?php echo $Rate['Value'] >= 1 ? ' text-warning' : 'r' ?> fa-star"></i>
                              <i class="fa<?php echo $Rate['Value'] >= 2 ? ' text-warning' : 'r' ?> fa-star"></i>
                              <i class="fa<?php echo $Rate['Value'] >= 3 ? ' text-warning' : 'r' ?> fa-star"></i>
                              <i class="fa<?php echo $Rate['Value'] >= 4 ? ' text-warning' : 'r' ?> fa-star"></i>
                              <i class="fa<?php echo $Rate['Value'] == 5 ? ' text-warning' : 'r' ?> fa-star"></i>
                              </h6>
                              <p class="card-text"><?php echo substr($Rate['Note'], 0, 49) ?>
                                <span id="dots">...</span>
                                <span id="more"><?php echo substr($Rate['Note'], 49) ?></span>
                                <a id="btnReadMore"><?php echo $lang['ReadMore']; ?></a>
                              </p>
                            </div>
                          </div>
                        </div>
                        <?php
                      }
                    ?>
                  </div>
                </div>
                <?php
              }
            }
            else 
            {
              echo "NO Rate ";
            }
          ?>
        </div>
      </div>
    </section>
    <!-- End Flat Evaluation -->
    <?php
  }
  else 
  {
    header('location: /Daarna-Hotel/not-found.php');
  }
    require 'global/footer.php';
    ob_end_flush();
  ?>