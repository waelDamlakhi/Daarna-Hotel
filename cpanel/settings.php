<?php
  ob_start();
  require "../global/DBOperations.php";
  $Page = isset($_GET['Page']) ? $_GET['Page'] : 'MyProfile';
  if (COUNT($_SESSION) > 0)
  {
    if ($Page == 'MyProfile')
    {
      $PageName = $lang['MyProfile'];
      require "../global/header.php";
      ?>
      <!-- Start Breadcrumb -->
      <nav class="p-2 mb-2 rounded navBredcrumb" aria-label="breadcrumb">
        <div class="container">
          <ol class="breadcrumb my-3">
            <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase" href="admin/index.php"><?php echo $lang['ControlPanel']; ?></a></li>
            <li class="breadcrumb-item breadcrumb-link fw-bold text-decoration-none text-uppercase active" aria-current="page"><?php echo $lang['MyProfile']; ?></li>
          </ol>
        </div>
      </nav>
      <!-- End Breadcrumb -->
      <!-- Start Form MyProfile -->
      <section class="MyProfile my-3">
        <div class="container">
          <h1 class="text-center my-3"><?php echo $lang['MyProfile']; ?></h1>
          <form class="settingsForm was-validated p-4 rounded-3 mb-5 <?php echo in_array(array_keys($_SESSION)[1], array('Admin', 'Reception')) ? 'w-75 mx-auto' : ''; ?>" id="settingsForm">
            <?php
              if (!isset($_SESSION['Client']))
              {
                ?>
                <div class="row mb-3">
                  <label for="User-Name" class="col-md-3 col-form-label"><i class="fa fa-user-circle fa-fw me-1"></i><?php echo $lang['UserName']; ?></label>
                  <div class="col-md-9">
                    <input type="name" name="User-Name" class="form-control" id="User-Name" placeholder="UserName" value="<?php echo $_SESSION[array_keys($_SESSION)[1]] ?>" disabled>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="Pass" class="col-md-3 col-form-label"><i class="fas fa-user-lock fa-fw me-1"></i><?php echo $lang['Password']; ?></label>
                  <div class="col-md-9">
                    <input type="password" class="form-control" name="Password" id="Pass" minlength="8" placeholder="Password" autocomplete="off">
                  </div>
                </div>
                <?php
              }
              else
              {
                $GetClient = $con->prepare("SELECT * FROM clients WHERE ClientId = ?");
                $GetClient->execute(array($_SESSION['ClientId']));
                $Client = $GetClient->fetch();
                ?>
                <div class="row">
                  <div class="col-md-4">
                    <div class="DisplayAccountImage d-flex justify-content-center">
                      <input type="hidden" value="<?php echo !empty($Client['AccountImage']) ? $Client['AccountImage'] : '' ?>" name="oldImage"/>
                      <img class="ImageAccount img-fluid" src="../photos/<?php echo !empty($Client['AccountImage']) ? $Client['AccountImage'] : 'avatar01.png' ?>" alt="AccountImage">
                    </div>
                    <div class="input-group justify-content-center my-2">
                      <input type="file" class="form-control shadow-none" name="AccountImage" accept="image/*" id="AccountImage" hidden>
                      <button class="border-0 rounded-pill px-3 py-2" id="CustomAccountImage" type="button"><?php echo $lang['ChangeAccountImage']; ?></button>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-floating mb-2">
                      <input type="name" name="User-Name" class="form-control" id="User-Name" placeholder="UserName" value="<?php echo $Client['UserName'] ?>" autocomplete="off" disabled>
                      <label for="User-Name"><i class="fa fa-user-circle me-1"></i><?php echo $lang['UserName']; ?></label>
                    </div>
                    <div class="form-floating mb-2">
                      <input type="password" class="form-control" name="Password" id="Pass"  minlength="8" placeholder="Password" autocomplete="off">
                      <label for="Pass"><i class="fas fa-user-lock me-1"></i><?php echo $lang['Password']; ?></label>
                    </div>
                    <div class="form-floating mb-2">
                      <input type="tel" class="form-control" name="Phone" id="Phone" pattern="[0][9][0-9]{8}" value="<?php echo $Client['Phone'] ?>" autocomplete="off">
                      <label for="Phone"><i class="fas fa-mobile-alt me-1"></i><?php echo $lang['Phone']; ?></label>
                    </div>
                    <div class="form-floating mb-2">
                      <input type="email" class="form-control" name="Email" id="Email" placeholder="Email" value="<?php echo $Client['Email'] ?>" pattern="[a-z0-9._%+-]+@[a-z.-]+\.[a-z]{2,4}$" autocomplete="off">
                      <label for="Email"><i class="fas fa-at me-1"></i><?php echo $lang['Email']; ?></label>
                    </div>
                  </div>
                </div>
                <?php
              }
            ?>
            <button type="submit" class="btn btn-outline-success mt-3 hvr-hang"><i class="fas fa-check-double align-middle"></i> <?php echo $lang['Save']; ?></button>
          </form>
        </div>
      </section>
      <!-- End Form MyProfile -->
      <?php
    }
    elseif ($Page == 'SiteSettings')
    {
      if (isset($_SESSION['AdminId']))
      {
        $PageName = $lang['SiteSettings'];
        require "../global/header.php";
        ?>
        <!-- Start Breadcrumb -->
        <nav class="p-2 mb-2 rounded navBredcrumb" aria-label="breadcrumb">
          <div class="container">
            <ol class="breadcrumb my-3">
              <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase" href="admin/index.php"><?php echo $lang['ControlPanel']; ?></a></li>
              <li class="breadcrumb-item breadcrumb-link fw-bold text-decoration-none text-uppercase active" aria-current="page"><?php echo $lang['SiteSettings']; ?></li>
            </ol>
          </div>
        </nav>
        <!-- End Breadcrumb -->
        <!-- Start Form SiteSettings -->
        <section class="SiteSettings my-3">
          <div class="container">
            <h1 class="text-center my-3"><?php echo $lang['SiteSettings']; ?></h1>
            <form class="FormSiteStyle was-validated" id="FormSiteStyle" enctype="multipart/form-data">
              <nav>
                <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                  <button class="nav-link active" id="nav-SiteInformation-tab" data-bs-toggle="tab" data-bs-target="#nav-SiteInformation" type="button" role="tab" aria-controls="nav-SiteInformation" aria-selected="true"><?php echo $lang['SiteInformation']; ?></button>
                  <button class="nav-link" id="nav-SiteStyle-tab" data-bs-toggle="tab" data-bs-target="#nav-SiteStyle" type="button" role="tab" aria-controls="nav-SiteStyle" aria-selected="false"><?php echo $lang['SiteStyle']; ?></button>
                  <button class="nav-link" id="nav-TableTheme-tab" data-bs-toggle="tab" data-bs-target="#nav-TableTheme" type="button" role="tab" aria-controls="nav-TableTheme" aria-selected="false"><?php echo $lang['TableTheme']; ?></button>
                  <button class="nav-link" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about" type="button" role="tab" aria-controls="nav-about" aria-selected="false"><?php echo $lang['AboutUs']; ?></button>
                  <button class="nav-link" id="nav-HotelImages-tab" data-bs-toggle="tab" data-bs-target="#nav-HotelImages" type="button" role="tab" aria-controls="nav-HotelImages" aria-selected="false"><?php echo $lang['HotelImages']; ?></button>
                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-SiteInformation" role="tabpanel" aria-labelledby="nav-SiteInformation-tab">
                  <div class="row">
                    <div class="col-md-6 my-3 d-flex flex-column align-items-center">
                      <div class="DisplayImage">
                        <img class="ImageLogo img-fluid" src="../photos/logo.WebP" alt="LogoImage">
                      </div>
                    </div>
                    <div class="col-md-6 my-3">
                      <div class="row">
                        <div class="col-12 my-3">
                          <div class="input-group justify-content-center justify-content-md-start">
                            <input type="file" class="form-control shadow-none" name="LogoImage" accept="image/webp" id="LogoImage" hidden>
                            <button class="border-0 rounded-pill px-3 py-2" id="CustomImageLogo" type="button"><?php echo $lang['ChangeLogo']; ?></button>
                          </div>
                        </div>
                        <div class="col-12 mb-3">
                          <label for="EnglishHotelName" class="form-label"><?php echo $lang['EnglishHotelName'] ?></label>
                          <input type="text" name="EnglishHotelName" class="form-control shadow-none" id="EnglishHotelName" placeholder="<?php echo $lang['EnglishHotelName']; ?>" autocomplete="off" value="<?php echo $en['HotelName']; ?>" required>
                        </div>
                        <div class="col-12">
                          <label for="ArabicHotelName" class="form-label"><?php echo $lang['ArabicHotelName'] ?></label>
                          <input type="text" name="ArabicHotelName" class="form-control shadow-none" id="ArabicHotelName" placeholder="<?php echo $lang['ArabicHotelName']; ?>" autocomplete="off" value="<?php echo $ar['HotelName']; ?>" required>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="nav-SiteStyle" role="tabpanel" aria-labelledby="nav-SiteStyle-tab">
                  <div class="row">
                    <div class="col-6 my-3 d-flex flex-column align-items-center">
                      <label for="PageColor" class="form-label"><?php echo $lang['PageColorChange'] ?></label>
                      <input type="color" class="form-control form-control-color shadow-none" name="PageColor" id="PageColor" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" title="<?php echo $lang['ChooseYourColor']; ?>">
                    </div>
                    <div class="col-6 my-3 d-flex flex-column align-items-center">
                      <label for="ElementColor" class="form-label"><?php echo $lang['ElementColorChange'] ?></label>
                      <input type="color" class="form-control form-control-color shadow-none" id="ElementColor" name="ElementColor"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" title="<?php echo $lang['ChooseYourColor']; ?>">
                    </div>
                    <div class="col-6 my-3 d-flex flex-column align-items-center">
                      <label for="TextPrimaryColor" class="form-label"><?php echo $lang['ChangeMainFontColor'] ?></label>
                      <input type="color" class="form-control form-control-color shadow-none" id="TextPrimaryColor" name="TextPrimaryColor" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" title="<?php echo $lang['ChooseYourColor']; ?>">
                    </div>
                    <div class="col-6 my-3 d-flex flex-column align-items-center">
                      <label for="TextSecondaryColor" class="form-label"><?php echo $lang['SecondaryFontColorChange'] ?></label>
                      <input type="color" class="form-control form-control-color shadow-none" id="TextSecondaryColor" name="TextSecondaryColor"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" title="<?php echo $lang['ChooseYourColor']; ?>">
                    </div>
                    <div class="col-6 mb-3 d-flex flex-column align-items-center">
                      <label for="InputBoxShadowColor" class="form-label"><?php echo $lang['ChangeFieldBackground'] ?></label>
                      <input type="color" class="form-control form-control-color shadow-none" id="InputBoxShadowColor" name="InputBoxShadowColor"  data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" title="<?php echo $lang['ChooseYourColor']; ?>">
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="nav-TableTheme" role="tabpanel" aria-labelledby="nav-TableTheme-tab">
                  <div class="row align-items-center">
                    <div class="col-12 col-md-6 my-3">
                      <div class="table-responsive overflow-visible">
                        <table class="table table-hover table-bordered table-striped text-center" id="TableTheme">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col"><?php echo $lang['First']; ?></th>
                              <th scope="col"><?php echo $lang['Next']; ?></th>
                              <th scope="col"><?php echo $lang['Last']; ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th scope="row">1</th>
                              <td><?php echo $lang['cell']; ?> 1</td>
                              <td><?php echo $lang['cell']; ?> 2</td>
                              <td><?php echo $lang['cell']; ?> 3</td>
                            </tr>
                            <tr>
                              <th scope="row">2</th>
                              <td><?php echo $lang['cell']; ?> 4</td>
                              <td><?php echo $lang['cell']; ?> 5</td>
                              <td><?php echo $lang['cell']; ?> 6</td>
                            </tr>
                            <tr>
                              <th scope="row">3</th>
                              <td><?php echo $lang['cell']; ?> 7</td>
                              <td><?php echo $lang['cell']; ?> 8</td>
                              <td><?php echo $lang['cell']; ?> 9</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                      <div class="row ThemeColor">
                        <div class="col-4 my-3">
                          <div class="rounded-pill bg-dark Theme d-flex justify-content-end" id="TableThemeDark" role="button" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="<?php echo $lang['DefaultColor']; ?>"></div>
                        </div>
                        <div class="col-4 my-3">
                          <div class="rounded-pill bg-white Theme d-flex justify-content-end" id="TableThemewhite" role="button" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="<?php echo $lang['Transparent']; ?>"></div>
                        </div>
                        <div class="col-4 my-3">
                          <div class="rounded-pill bg-primary Theme d-flex justify-content-end" id="TableThemePrimary" role="button" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="<?php echo $lang['LigthBlue']; ?>"></div>
                        </div>
                        <div class="col-4 my-3">
                          <div class="rounded-pill bg-secondary Theme d-flex justify-content-end" id="TableThemeSecondary" role="button" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="<?php echo $lang['Grey']; ?>"></div>
                        </div>
                        <div class="col-4 my-3">
                          <div class="rounded-pill bg-success Theme d-flex justify-content-end" id="TableThemeSuccess" role="button" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="<?php echo $lang['lightGreen']; ?>"></div>
                        </div>
                        <div class="col-4 my-3">
                          <div class="rounded-pill bg-danger Theme d-flex justify-content-end" id="TableThemeDanger" role="button" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="<?php echo $lang['LightRed']; ?>"></div>
                        </div>
                        <div class="col-4 my-3">
                          <div class="rounded-pill bg-warning Theme d-flex justify-content-end" id="TableThemeWarning" role="button" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="<?php echo $lang['LightYellow']; ?>"></div>
                        </div>
                        <div class="col-4 my-3">
                          <div class="rounded-pill bg-info Theme d-flex justify-content-end" id="TableThemeInfo" role="button" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="<?php echo $lang['LightTeal']; ?>"></div>
                        </div>
                        <div class="col-4 my-3">
                          <div class="rounded-pill bg-light Theme d-flex justify-content-end" id="TableThemeLight" role="button" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="bottom" title="<?php echo $lang['Light']; ?>"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                  <div class="row">
                    <div class="col-12 col-md-6 my-3">
                      <label for="EnglishAboutHotel" class="form-label"><?php echo $lang['EnglishAboutHotel'] ?></label>
                      <textarea name="EnglishAboutHotel" id="EnglishAboutHotel" class="form-control" style="height: 225px; resize:none;" required><?php echo $en['About'] ?></textarea>
                    </div>
                    <div class="col-12 col-md-6 my-3">
                      <label for="ArabicAboutHotel" class="form-label"><?php echo $lang['ArabicAboutHotel'] ?></label>
                      <textarea name="ArabicAboutHotel" dir="rtl" id="ArabicAboutHotel" class="form-control" style="height: 225px; resize:none;" required><?php echo $ar['About'] ?></textarea>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="nav-HotelImages" role="tabpanel" aria-labelledby="nav-HotelImages-tab">
                  <div class="row">
                    <div class="col-12 my-3">
                      <div action="/Daarna-Hotel/global/DBOperations.php" class="dropzone bg-opacity-50" id="my-drop">
                        
                      </div>
                    </div>
                    <div class="col-12 mb-3" id="preview">
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer pt-2 pb-0">
                <button type="submit" class="btn btn-outline-success shadow-none hvr-hang"><i class="fas fa-check-double align-middle"></i> <?php echo $lang['Save']; ?></button>
              </div>
            </form>
            <!-- Start Toast -->
            <div class="position-fixed top-50 start-50 translate-middle p-3" style="z-index: 11">
              <div id="SuccessfullySettings" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="1000">
                <div class="toast-header">
                  <i class="fa-solid fa-circle-check fa-fw fs-5 text-success"></i>
                  <strong class="me-auto"><?php echo $lang['Successfully']; ?></strong>
                  <button type="button" class="btn-close shadow-none" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
              </div>
            </div>
            <!-- End Toast -->
          </div>
        </section>
        <!-- End Form SiteSettings -->
        <?php
      }
      else
      {
        header('location: /Daarna-Hotel/not-found.php');
      }
    }
    else
    {
      header('location: /Daarna-Hotel/not-found.php');
    }
  }
  else
  {
    header('location: /Daarna-Hotel/index.php');
  }
  require '../global/footer.php';
?>