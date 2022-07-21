<?php
  ob_start();
  require "../../global/DBOperations.php";
  $PageName = $lang['ControlPanel'];
  $Page = 'ControlPanel';
  require "../../global/header.php";
  if (isset($_SESSION['Reception']))
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
    <?php
  }
  else
  {
    header('location: /Daarna-Hotel/index.php');
  }
  require '../../global/footer.php';
?>