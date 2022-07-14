<?php
  require "global/DBOperations.php";
  $PageName = $lang['notFound'];
  $Page = 'notFound';
  require "global/header.php";
  ?>
  <!-- Start Breadcrumb -->
  <nav class="p-2 mb-2 rounded navBredcrumb" aria-label="breadcrumb">
    <div class="container">
      <ol class="breadcrumb my-3">
        <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase" href="index.php"><?php echo $lang['Home']; ?></a></li>
        <li class="breadcrumb-item breadcrumb-link fw-bold text-decoration-none text-uppercase active" aria-current="page"><?php echo $lang['ThePageDoesNotExist']; ?></li>
      </ol>
    </div>
  </nav>
  <!-- End Breadcrumb -->
  <!-- Start Section Error -->
  <section class="NotFound text-center my-5">
    <div class="container">
      <h1 class="display-1 m-0 fw-bold">
        <?php echo $lang['Error'];?>
        <span style="letter-spacing: -8px;" class="ms-2">
          4
          <i class="fas fa-car-crash display-6"></i>
          4
        </span>
      </h1>
      <p class="lead mx-auto" style="width: 60%;"><?php echo $lang['ThePageYouWereLookingForDoesNotExist,TheAddressMayBeMisspelled,OrThePageMayHaveBeenMovedOrDeleted.'] ?></p>
      <button class="btn btn-dark" onclick="history.back();"><?php echo $lang['GoBack'] ?></button>
    </div>
  </section>
  <!-- End Section Error -->
  <?php
  require 'global/footer.php';
?>