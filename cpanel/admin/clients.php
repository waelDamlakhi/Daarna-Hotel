<?php
  ob_start();
  require "../../global/DBOperations.php";
  $PageName = $lang['Clients'];
  $Page = 'Clients';
  require "../../global/header.php";
  if (isset($_SESSION['AdminId']))
  {
    ?>
    <!-- Start Breadcrumb -->
    <nav class="p-2 mb-2 rounded navBredcrumb" aria-label="breadcrumb">
      <div class="container">
        <ol class="breadcrumb my-3">
          <li class="breadcrumb-item"><a class="breadcrumb-link fw-bold text-decoration-none text-uppercase" href="index.php"><?php echo $lang['ControlPanel']; ?></a></li>
          <li class="breadcrumb-item breadcrumb-link fw-bold text-decoration-none text-uppercase active" aria-current="page"><?php echo $lang['Clients']; ?></li>
        </ol>
      </div>
    </nav>
    <!-- End Breadcrumb -->
    <!-- Start Table Clients -->
    <section class="table-customize-clients my-3">
      <div class="container">
        <h1 class="text-center my-3"><?php echo $lang['Manage'] . $lang['Clients']; ?></h1>
        
      </div>
    </section>
    <!-- End Table Clients -->
    <?php
  }
  else
  {
    header('location: /Daarna-Hotel/index.php');
  }
  require '../../global/footer.php';
?>