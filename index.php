<?php
  require "global/DBOperations.php";
  // For Title In Header
  $PageName = $lang['HotelName'] . ' | ' . $lang['HomePage'];
  // For Body Name
  $Page = 'HomePage';
  require 'global/header.php';
  ?>
  <!-- Start Carousel -->
  <section class="Carousel mb-3" id="HotelImages">
    
  </section>
  <!-- End Carousel -->
  <!-- Start Flats Show Section -->
  <section class="SectionFlatsShow HeightBody text-center my-3" id="SectionFlatsShow">
    <div class="container">
      <h1 class="mb-3"><?php echo $lang['FlatsHotel']; ?></h1>
      <!-- Start Accordion -->
      <div class="accordion accordion-flush text-start mb-3" id="accordionSearchHomePage">
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingSearch">
            <button class="accordion-button one shadow-none collapsed" id="Btn-flush-collapseSearch" data-bs-toggle="collapse" data-bs-target="#flush-collapseSearch" aria-expanded="false" aria-controls="flush-collapseSearch">
              <i class="fas fa-search fa-fw align-middle mx-2"></i> <?php echo $lang['Search']; ?>
            </button>
          </h2>
          <div id="flush-collapseSearch" class="accordion-collapse collapse" aria-labelledby="flush-headingSearch" data-bs-parent="#accordionSearchHomePage">
            <div class="accordion-body">
              <form class="row FormSearch" id="FormSearch">
                <div class="col-6 mb-2">
                  <label for="FloorId" class="form-label"><?php echo $lang['FloorId']; ?></label>
                  <input type="number" name="FloorId" class="form-control hvr-shadow" id="FloorId" min="1" placeholder="0" autocomplete="off">
                </div>
                <div class="col-6 mb-2">
                  <label for="FlatId" class="form-label"><?php echo $lang['FlatId']; ?></label>
                  <input type="number" name="FlatId" class="form-control hvr-shadow" id="FlatId" min="1" placeholder="0" autocomplete="off">
                </div>
                <div class="col-6 mb-2">
                  <label for="RoomsCount" class="form-label"><?php echo $lang['RoomsCount']; ?></label>
                  <input type="number" name="RoomsCount" class="form-control hvr-shadow" id="RoomsCount" min="1" placeholder="0" autocomplete="off">
                </div>
                <div class="col-6 mb-2">
                  <label for="BedsCount" class="form-label"><?php echo $lang['BedsCount']; ?></label>
                  <input type="number" name="BedsCount" class="form-control hvr-shadow" id="BedsCount" min="1" placeholder="0" autocomplete="off">
                </div>
                <div class="col-6 mb-2">
                  <label for="LowPrice" class="form-label"><?php echo $lang['LowPrice']; ?></label>
                  <input type="text" name="LowPrice" class="form-control hvr-shadow" id="LowPrice" min="0" placeholder="0" autocomplete="off">
                </div>
                <div class="col-6 mb-2">
                  <label for="HeighPrice" class="form-label"><?php echo $lang['HeighPrice']; ?></label>
                  <input type="text" name="HeighPrice" class="form-control hvr-shadow" id="HeighPrice" min="0" placeholder="0" autocomplete="off">
                </div>
                <div class="col-6 mb-2">
                  <label for="View" class="form-label"><?php echo $lang['View']; ?></label>
                  <select class="form-select hvr-shadow" name="View" id="View">
                    <option value="All"><?php echo $lang['All']; ?></option>
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
                <div class="col-6 mb-2">
                  <label class="form-label"><?php echo $lang['Rate']; ?></label>
                  <div class="fs-2 d-flex justify-content-evenly align-items-end">
                    <i class="fa-regular fa-star" id="1"></i>
                    <i class="fa-regular fa-star" id="2"></i>
                    <i class="fa-regular fa-star" id="3"></i>
                    <i class="fa-regular fa-star" id="4"></i>
                    <i class="fa-regular fa-star" id="5"></i>
                  </div>
                </div>
                <div class="col-12">
                  <button class="btn btn-outline-success hvr-wobble-horizontal shadow-none" type="submit" id="BottomSearch"><?php echo $lang['Search']; ?></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- End Accordion -->
      <div class="row g-4 align-items-center justify-content-center" id="FlatsCard">
        <!-- Start Falts Card -->
      </div>
    </div>
  </section>
  <!-- End Flats Show Section -->
  <!-- Start Section Evaluation -->
  <section class="SectionEvaluation HeightBody text-center my-3" id="SectionEvaluation">
    <div class="container">
      <h1 class="mb-3"><?php echo $lang['Evaluation'] ?></h1>
      <?php
        if (true)
        {
          ?>
          <div id="serviceEval" style="height: 450px !important;">
            <div class="overflow-auto" style="height: 450px !important;">
              <div class="row mw-100">
                <div class="col-6 col-lg-4 mb-2 d-flex justify-content-center">
                  <div class="card" style="width: 18rem;">
                    <div class="card-header"><?php echo $lang['ServiceName'] ?></div>
                    <div class="card-body">
                      <div class="card-title h4">
                      <i class="far fa-star fa-fw"></i>
                      <i class="far fa-star fa-fw"></i>
                      <i class="far fa-star fa-fw"></i>
                      <i class="far fa-star fa-fw"></i>
                      <i class="far fa-star fa-fw"></i>
                      </div>
                      <h6 class="card-subtitle">لا يوجد تقييم</h6>
                    </div>
                  </div>
                </div>
                <div class="col-6 col-lg-4 mb-2 d-flex justify-content-center">
                  <div class="card" style="width: 18rem;">
                    <div class="card-header"><?php echo $lang['ServiceName'] ?></div>
                    <div class="card-body">
                      <h4 class="card-title">
                      <i class="far fa-star fa-fw"></i>
                      <i class="far fa-star fa-fw"></i>
                      <i class="far fa-star fa-fw"></i>
                      <i class="far fa-star fa-fw"></i>
                      <i class="far fa-star fa-fw"></i>
                      </h4>
                      <h6 class="card-subtitle">لا يوجد تقييم</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
        }
        else
        {
          ?>
          <img class="mx-auto img-fluid" src="/DAARNA-HOTEL/photos/reviews.png">
          <div class="fs-4">
            <?php echo $lang['ThereAreNoServicesYet']; ?>
          </div>
          <?php
        }
      ?>
    </div>
  </section>
  <!-- End Section Evaluation -->
  <!-- Start Section About -->
  <section class="SectionAbout text-center HeightBody my-3" id="SectionAbout">
    <div class="container">
      <h1 class="mb-3"><?php echo $lang['AboutUs'] ?></h1>
      <div>
        <p class="lead"><?php echo $lang['About'] ?></p>
      </div>
    </div>
  </section>
  <!-- End Section About -->

  <?php
    require 'global/footer.php';
  ?>