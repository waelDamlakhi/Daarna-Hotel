    <!-- Start Footer -->
    <section class='footer'>
      <div class='container'>
        <h2 class="py-2"><?php echo $lang['HotelName']; ?></h2>
        <ul class='list-unstyled'>
          <div class='row'>
            <ul class="social-list mb-2">
              <li><img src="/Daarna-Hotel/photos/social-bookmarks/facebook.png" width="38" height="38" alt="Facebook" /></li>
              <li><img src="/Daarna-Hotel/photos/social-bookmarks/gplus.png" width="38" height="38" alt="Google Plus" /></li>
              <li><img src="/Daarna-Hotel/photos/social-bookmarks/twitter.png" width="38" height="38" alt="Twitter" /></li>
              <li><img src="/Daarna-Hotel/photos/social-bookmarks/pinterest.png" width="38" height="38" alt="Pinterest" /></li>
              <li><img src="/Daarna-Hotel/photos/social-bookmarks/rss.png" width="38" height="38" alt="Rss" /></li>
              <li><img src="/Daarna-Hotel/photos/social-bookmarks/email.png" width="38" height="38" alt="Email" /></li>
            </ul>
            <div class='col-6'>
              <li><a href='#' class="text-decoration-none"><?php echo $lang['InformationAboutTheCompany']; ?></a></li>
            </div>
            <div class='col-6'>
              <li><a href='#' class="text-decoration-none"><?php echo $lang['Help']; ?></a></li>
            </div>
            <div class='col-6'>
              <li><a href='#' class="text-decoration-none"><?php echo $lang['InformationOffice']; ?></a></li>
            </div>
            <div class='col-6'>
              <li><a href='#' class="text-decoration-none"><?php echo $lang['InvestorRelations']; ?></a></li>
            </div>
            <div class="col-6">
              <li><a href='#' class="text-decoration-none"><?php echo $lang['LearnHowAWebsiteWorks']; ?></a></li>
            </div>
            <div class="col-6">
              <li><a href='#' class="text-decoration-none"><?php echo $lang['TermsAndConditions']; ?></a></li>
            </div>
            <div class="col-6">
              <li><a href='#' class="text-decoration-none"><?php echo $lang['LegalInformation']; ?></a></li>
            </div>
            <div class="col-6">
              <li><a href='#' class="text-decoration-none"><?php echo $lang['PrivacyNotice']; ?></a></li>
            </div>
            <div class="col-6">
              <li><a href='#' class="text-decoration-none"><?php echo $lang['SiteMap']; ?></a></li>
            </div>
          </div>
        </ul>
        <div class='copyright text-center'>
          <strong><?php echo $lang['HotelName']; ?></strong><br>
          <?php echo $lang['Copyrights']; ?> &copy; 2021 | 2022 <?php echo $lang['AllRightsAreSave']; ?>
        </div>
      </div>
    </section>
    <!-- End Footer -->
    <script>var Word = <?php echo json_encode($lang); ?>;</script>
    <script src='/Daarna-Hotel/scripts/jquery-3.6.0.min.js'></script>
    <script src='/Daarna-Hotel/scripts/bootstrap.bundle.min.js'></script>
    <script src="/Daarna-Hotel/scripts/dropzone.min.js"></script>
    <script src='/Daarna-Hotel/scripts/all.min.js'></script>
    <script src="/Daarna-Hotel/scripts/jstable.min.js"></script>
    <script src='/Daarna-Hotel/scripts/wow.min.js'></script>
    <script src='/Daarna-Hotel/scripts/slick.min.js'></script>
    <script src='/Daarna-Hotel/scripts/moment.min.js'></script>
    <script src='/Daarna-Hotel/scripts/main.min.js'></script>
    <script>new WOW().init();</script>
    <script src='/Daarna-Hotel/scripts/new.js'></script>
    <script type="text/javascript">
      if (document.querySelector('#SiteSettings')) 
      {
        Dropzone.autoDiscover = false;
        var FileDropzone = new Dropzone(".dropzone", { 
          autoProcessQueue: false,
          dictDefaultMessage: '<i class="fa fa-upload fs-3 d-block mx-auto mb-3"></i>' + Word.DropFilesHereOrClickToUpload,
          acceptedFiles:".png, .jpg, .jpeg, .webp",
          addRemoveLinks: true,
          dictRemoveFile: Word.RemoveFile,
          removedfile: function(file)
          {
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
          },
          init: function()
          {
            let files = 0;
            this.on("addedfile", function(file) 
            {
              NewHotelImages[files] = file;
              $('.dz-remove').addClass('text-decoration-none');
              files++;
            });
            this.on('removedfile', function(file) 
            {
              NewHotelImages.splice(NewHotelImages.indexOf(file), 1);
              files--;
            });
          }
        });
      }
    </script>
  </body>
</html>