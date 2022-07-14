<?php
  ob_start();
  require "global/DBOperations.php";
  $PageName = $lang['LogIn'];
  $Page = 'LogIn';
  require "global/header.php";
  if (COUNT($_SESSION) == 0)
  {
    ?>
    <!-- Start Section Login -->
    <section class="pageLogin">
      <div class="overlay mb-0">
        <div class="container">
          <form class="Formlogin mx-auto my-5 was-validated" id="Formlogin">
            <h4 class="text-center h2 p-2"><?php echo $lang['SignIn']; ?></h4>
            <div class="form-floating my-3">
              <input type="name" class="form-control" name="UserName" id="UserName" placeholder="UserName" autocomplete="off" required>
              <label for="UserName"><?php echo $lang['UserName']; ?></label>
            </div>
            <div class="form-floating my-3">
              <input type="password" class="form-control" name="Password" id="Password" minlength="8" placeholder="Password" required>
              <label for="Password"><?php echo $lang['Password']; ?></label>
            </div>
            <div class="vstack col mx-auto my-3">
              <button class="btn btn-lg" type="submit"><?php echo $lang['LogIn']; ?></button>
            </div>
          </form>
        </div>
      </div>
    </section>
    <!-- End Section Login -->
    <?php
  }
  else
  {
    header("Location: index.php");
  }
  require 'global/footer.php';
  ob_end_flush();
?>