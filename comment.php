<!-- Start Comment -->
<!-- Css -->

--color-BackgroundBody:#101214;
  --color-BackgroundElement:#212529;
  --color-InputBoxShadowSelect:#39393b;
  --color-PrimaryText:#aa8220;
  --color-SecondaryText:#eaeaea;

  .form-floating { color: var(--color-TextForm);}
  
  .dt-top .dt-selector, .dt-bottom .dt-selector, .dt-input{
  background-color: var(--color-InputBoxShadowSelect);
  color: var(--color-SecondaryText);
  border: none;
}

.navbar, .offcanvas, .modal-content, .navbar .user-icon, .offcanvas .user-icon,
.offcanvas .offcanvas-body .nav-link,
.offcanvas .offcanvas-footer,
.card{
  background-color: var(--color-background2);
}

.navbar .offcanvas {
  z-index: 1045;
  visibility: hidden !important;
}

.navbar .offcanvas.show { visibility: visible !important;}

.offcanvas .offcanvas-body { width: 20rem; background-color: var(--color-background3); }

.offcanvas .offcanvas-body { background-color: var(--color-background3); color: #EAEAEA; }

.section-booking-now #ExitDate { position: relative; }

.section-booking-now input[type="date"]::-webkit-calendar-picker-indicator {
  background: transparent;
  bottom: 0;
  color: transparent;
  cursor: pointer;
  height: auto;
  left: 0;
  position: absolute;
  right: 0;
  top: 0;
  width: auto;
}
<!-- Js -->

/**
    * Display Image For Carousel
  */
  $('#CarouselImage').on('change', function () 
  {
    if (parseInt($(this).get(0).files.length) > 3 || parseInt($(this).get(0).files.length) < 3)
    {
      $(this).val('');
    }
  });

  //   <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
          //     <div class="carousel-inner">
          //       <div class="carousel-item active">
          //       </div>
          //       <div class="carousel-item">
          //         <img src="..." class="d-block w-100" alt="...">
          //       </div>
          //       <div class="carousel-item">
          //         <img src="..." class="d-block w-100" alt="...">
          //       </div>
          //     </div>
          //     <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
          //       <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          //       <span class="visually-hidden">Previous</span>
          //     </button>
          //     <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
          //       <span class="carousel-control-next-icon" aria-hidden="true"></span>
          //       <span class="visually-hidden">Next</span>
          //     </button>
          //   </div>

  <div class="row">
    <div class="col-12">
      <img class="img-fluid rounded-2" width="175" src="/Daarna-Hotel/photos/${element}" />
    </div>
    <div class="col-12">
      <button type="button" class="btn btn-link remove_image">Remove</button>
    </div>
  </div>

  <ul class="list-unstyled lh-base">
    <li class="d-flex justify-content-between py-2">
      <span>
        <i class="fa-solid fa-binoculars fa-fw"></i> Title
      </span>
      <span>Value</span>
    </li>
    <li class="d-flex justify-content-between py-2">
      <span>
        <i class="fa-solid fa-house fa-fw"></i> Title
      </span>
      <span>Value</span>
    </li>
    <li class="d-flex justify-content-between py-2">
      <span>
        <i class="fa-solid fa-bed fa-fw"></i> Title
      </span>
      <span>Value</span>
    </li>
    <li class="d-flex justify-content-between py-2">
      <span>
        <i class="fa-solid fa-dollar-sign fa-fw"></i> Title
      </span>
      <span>Value</span>
    </li>
    <li class="d-flex justify-content-between py-2">
      <span>
        <i class="far fa-star text-light"></i> Title
      </span>
      <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="This flat was rated by '07' people">Value</span>
    </li>
  </ul>

document.documentElement.style
  .setProperty('--color-InputBoxShadowSelect', $(this).val());
<!-- معلومات عن الشركة
  المكتب الاعلامي
  علاقات المستثمرين
  مساعدة
  تعرف على كيفية عمل موقع 
  الشروط و الاحكام
  المعلومات القانونية 
  إخطار الخصوصية
  خريطة الموقع
  information about the company
  information Office
  investor relations
  help
  Learn how a website works
  Terms and Conditions
  Legal information
  Privacy Notice
  Site Map  -->

<!-- <?php
          // Check If User Coming From HTTP Post Request
          if (isset($_POST['LogIn']))
          {
            $stmt = $con->prepare('SELECT * FROM employees WHERE UserName = ? AND Pass = ?');
            $stmt->execute(array($_POST['UserName'], SHA1($_POST['Password'])));
            // If Count > 0 This Mean The Database Contain Record About This User
            if ($stmt->rowCount() > 0)
            {
              $user = $stmt->fetch();
              if ($user['Job'] == 'Admin')
              {
                $_SESSION['AdminId'] = $user['EmpId'];
                $_SESSION['Admin'] = $user['UserName'];
                header("Location: cpanel/admin/index.php");
              }
              else 
              {
                $_SESSION['ReceptionId'] = $user['EmpId'];
                $_SESSION['Reception'] = $user['UserName'];
                header("Location: panel.php");
              }
            }
            else 
            {
              $stmt = $con->prepare('SELECT * FROM clients WHERE UserName = ? AND Pass = ?');
              $stmt->execute(array($_POST['UserName'], SHA1($_POST['Password'])));
              if ($stmt->rowCount() > 0)
              {
                $user = $stmt->fetch();
                $_SESSION['ClientId'] = $user['ClientId'];
                $_SESSION['Client'] = $user['UserName'];
                header('Location: panel.php');
              }
              else 
              {
                ?>
                <div class="alert alert-danger d-flex align-items-center alert-dismissible show" role="alert">
                  <svg class="ErrorLogIn mx-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                  </svg>
                  <div>
                    <?php echo $lang('Sorry There Is An Error In The UserName Or Password'); ?>
                  </div>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
              }
            }
          }?> -->

<div class="container">
      <h1 class="pb-2"><?php echo $lang['AboutHotel'] ?></h1>
      <!-- <div id="carouselFlatEvaluation" class="carousel slide" data-ride="carousel" data-interval="1000000000000"> -->
        <div class="single-item">
          <!-- <div class="carousel-item active"> -->
            <!-- <img src="photos/cloud.webp" alt="..." class="d-block w-100"> -->
            <div>
              <img src="photos/cloud.webp" alt="..." class="d-block w-100 img-fluid">
              <h5>...</h5>
              <p>...</p>
            </div>
          <!-- </div> -->
          <!-- <div class="carousel-item"> -->
            <!-- <img src="photos/cloud.webp" alt="..." class="d-block w-100"> -->
            <div>
              <img src="photos/cloud.webp" alt="..." class="d-block w-100">
              <h5>...</h5>
              <p>...</p>
            </div>
          <!-- </div> -->
          <!-- <div class="carousel-item"> -->
            <!-- <img src="photos/cloud.webp" alt="..." class="d-block w-100"> -->
            <div>
              <img src="photos/cloud.webp" alt="..." class="d-block w-100">
              <h5>...</h5>
              <p>...</p>
            </div>
          <!-- </div> -->
        </div>
        <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselFlatEvaluation" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselFlatEvaluation" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button> -->
        <!-- <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a> -->
      <!-- </div> -->
      <!-- <div id="carouselFlatEvaluation" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="carousel-caption d-none d-md-block">
              <img src="photos/cloud.webp" class="d-block w-100" alt="...">
              <h5>First slide label</h5>
              <p>Some representative placeholder content for the first slide.</p>
            </div>
          </div>
          <div class="carousel-item">
            <div class="carousel-caption d-none d-md-block">
              <img src="photos/cloud.webp" class="d-block w-100" alt="...">
              <h5>Second slide label</h5>
              <p>Some representative placeholder content for the second slide.</p>
            </div>
          </div>
          <div class="carousel-item">
            <div class="carousel-caption d-none d-md-block">
              <img src="photos/cloud.webp" class="d-block w-100" alt="...">
              <h5>Third slide label</h5>
              <p>Some representative placeholder content for the third slide.</p>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselFlatEvaluation" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselFlatEvaluation" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div> -->
    </div>
    <!-- <div class="container">
      <div class="testimonials">
        <div id="testimonials" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="carousel-caption d-none d-block">
                <img src="img/avatar01.png" alt="...">
                <h3>Mohamed Faragallah</h3>
                <span>Company CEO</span>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nq</p>
              </div>
            </div>
            <div class="carousel-item">
              <div class="carousel-caption d-none d-block">
                <img src="img/avatar01.png" alt="...">
                <h3>Ahmed Mosaad</h3>
                <span>Company Manager</span>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nq</p>
              </div>
            </div>
            <div class="carousel-item">
              <div class="carousel-caption d-none d-block">
                <img src="img/avatar01.png" alt="...">
                <h3>John Skeet</h3>
                <span>Free Lancer</span>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nq</p>
              </div>
            </div>
          </div>
          <a class="carousel-control-prev" href="#testimonials" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#testimonials" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div> -->

<!-- Show Message When Field Is Empty
  $('[required]').blur(function ()
  {
    if ($(this).val() == '') 
    {
      $(this).addClass('is-invalid');
      $('input').val();
    }
  });
  $('[required]').focus(function ()
  {
    $(this).removeClass('is-invalid');
  }); -->

<!-- Request Add Floor To The Hotel -->
<!-- $('.responseFloor').load("/Daarna-Hotel/global/DBOperations.php", {showfloor: ""}, function (response, status, request)
  {
    if (status === 'success') 
    {
      $('.responseFloor').html(response);
      if ($('.noFloor').parent().is('.responseFloor')) 
      {
        $('.Remove').prop('disabled', true);
      }
      else
      {
        $('.Remove').prop('disabled', false);
      }
    }
  });

  $.post("/Daarna-Hotel/global/DBOperations.php", {AddFloor: '', FloorId: $('.FloorsId').last().children().html()},
    function (data, textStatus, jqXHR)
    {
      if (textStatus === 'success') 
      {
        $('.response').html(data);
        displayFloor();
      }
    });

  $.post("/Daarna-Hotel/global/DBOperations.php", {RemoveFloor: '',FloorId: $('.FloorsId').last().children().html()},
    function (data, textStatus, jqXHR)
    {
      if (textStatus === 'success') 
      {
        displayFloor();
      }
    });

  $('.add').click(function () {
    getRequest()
    // console.log('clicked');
  })

  function getRequest() {
    var myRequset = new XMLHttpRequest();
    myRequset.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
          $('.response').html(this.responseText);
      }
    }
    myRequset.open(
      'POST',
      '/Daarna-Hotel/cpanel/admin/displayFloor.php',
      true
    );
    myRequset.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    myRequset.send('name=Add');
  }; -->
<?php
  foreach ($Data as $Array)
			{
				?>
				<tr>
					<td><?php echo $Array['FeatureId']; ?></td>
					<td>
            <?php 
              switch ($Array['FeatureId']) 
              {
                case 1: echo $lang('Room'); break;
                case 2: echo $lang('Bath'); break;
                case 3: echo $lang('Bed'); break;
                case 4: echo $lang('TV'); break;
                case 5: echo $lang('AC'); break;
                case 6: echo $lang('Stove'); break;
                case 7: echo $lang('Oven'); break;
                case 8: echo $lang('Fridge'); break;
                case 9: echo $lang('Laundry'); break;
                default: echo $lang('Cooler'); break;
              }; 
            ?>
          </td>
					<td><?php echo $Array['Details']; ?></td>
					<td><?php echo $Array['Price']; ?></td>
					<td><?php echo $Array['UserName']; ?></td>
					<td>
						<button class="ShowFlat text-white" data-bs-toggle="modal" data-bs-target="#confirmTheDelete<?php echo $Array['Id']; ?>" aria-label="<?php echo $lang('Show'); ?>" data-balloon-pos="left">
              <i class="fas fa-trash fs-5"></i>
						</button>
					</td>
				</tr>
        <!-- Start Modal For Delete -->
        <div class="modal fade" id="confirmTheDelete<?php echo $Array['Id']; ?>" data-bs-keyboard="false" tabindex="-1" aria-labelledby="WarningTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
              <div class="modal-header">
                <h5 class="modal-title text-warning" id="WarningTitle"><i class="fas fa-exclamation me-2 fs-5"></i><?php echo $lang('Warning'); ?></h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="d-flex align-items-center" role="alert">
                  <svg class="mx-2 text-warning" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                  </svg>
                  <div class="text-light">
                    <?php echo $lang('Warning: Are You Sure About That'); ?>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $lang('Close'); ?></button>
                <button type="button" class="btn btn-danger" id="RemoveFloor" data-bs-dismiss="modal"><?php echo $lang('Delete'); ?></button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Modal For Delete -->
        <!-- Start Modal For Add Flat -->
        <div class="modal fade text-white" id="comfirmAddFlat" tabindex="-1" aria-labelledby="addFlat" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark">
              <div class="modal-header">
                <h5 class="modal-title" id="addFlat"><?php echo $lang['NewFlat']; ?></h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form class="row was-validated FormNewFlat" id="FormNewFlat">
                  <div class="col-md-4 mb-2">
                    <label for="FlatId" class="form-label"><?php echo $lang['FlatId']; ?></label>
                    <input type="number" name="FlatId" class="form-control" id="FlatId" min="1" placeholder="0" autocomplete="off" required>
                  </div>
                  <div class="col-md-4 mb-2">
                    <label for="FlatArea" class="form-label"><?php echo $lang['FlatArea']; ?></label>
                    <input type="number" name="Area" class="form-control" id="FlatArea" min="100" placeholder="m&sup2" autocomplete="off" required>
                  </div>
                  <div class="col-md-4 mb-2">
                    <label for="View" class="form-label"><?php echo $lang['View']; ?></label>
                    <select class="form-select" name="View" id="View" required>
                      <option value="N"><?php echo $lang['North']; ?></option>
                      <option value="E"><?php echo $lang['East']; ?></option>
                      <option value="S"><?php echo $lang['South']; ?></option>
                      <option value="W"><?php echo $lang['West']; ?></option>
                      <option value="NE"><?php echo $lang['NorthEast']; ?></option>
                      <option value="ES"><?php echo $lang['EastSouth']; ?></option>
                      <option value="SW"><?php echo $lang['SouthWest']; ?></option>
                      <option value="WN"><?php echo $lang['WestNorth']; ?></option>
                    </select>
                  </div>
                  <label class="form-label"><?php echo $lang['MainImage']; ?></label>
                  <div class="input-group mb-2">
                    <input type="file" class="form-control" name="MainImage" accept="image/*" id="MainImage" required>
                    <label class="input-group-text uploadImg px-3" for="MainImage"><i class="fas fa-upload" aria-hidden="true"></i></label>
                  </div>
                  <label class="form-label"><?php echo $lang['OtherImage']; ?></label>
                  <div class="input-group mb-3">
                    <input type="file" class="form-control" name="OtherImage[]" id="OtherImage" accept="image/*" multiple required>
                    <label class="input-group-text uploadImg px-3" for="OtherImage"><i class="fas fa-upload" aria-hidden="true"></i></label>
                  </div>
                  <div class="modal-footer pt-2 pb-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $lang['Close']; ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo $lang['Add']; ?></button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- End Modal For Add Flat -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingEmployees">
            <button class="accordion-button collapsed one shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseEmployees" aria-expanded="false" aria-controls="flush-collapseEmployees">
              <i class="fas fa-user-tie fa-fw align-middle mx-3" aria-hidden="true"></i> <?php echo $lang['Employees']; ?>
            </button>
          </h2>
          <div id="flush-collapseEmployees" class="accordion-collapse collapse" aria-labelledby="flush-headingEmployees" data-bs-parent="#accordionAdmin">
            <div class="accordion-body">
              <a href="#" class="nav-link <?php 
              // echo $obj->getBody() == "requests" && (!isset($_GET['statue']) || (isset($_GET['statue']) && $_GET['statue'] == 'all')) ? 'active' : '';?>">
                <i class="far fa-circle fa-fw align-middle mx-3"></i> <?php echo $lang['Add']; ?>
              </a>
              <a href="#" class="nav-link <?php 
              // echo isset($_GET['statue']) && $_GET['statue'] == 'new' ? 'active' : '';?>">
                <i class="far fa-circle fa-fw align-middle mx-3"></i> <?php echo $lang['Show']; ?>
              </a>
            </div>
          </div>
        </div>
				<?php
			}
?>