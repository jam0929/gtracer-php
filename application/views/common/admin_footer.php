
        <!-- // END row-app -->
      </div>
    </div>
	</div>

  <!-- Global -->
  <script data-id="App.Config">
    var App = {};        
    var basePath = '<?php echo base_url(); ?>',
      commonPath = '/assets/',
      rootPath = '/',
      DEV = false,
      componentsPath = '/assets/components/';

    var primaryColor = '#7293CF',
      dangerColor = '#b55151',
      successColor = '#609450',
      infoColor = '#4a8bc2',
      warningColor = '#ab7a4b',
      inverseColor = '#45484d';

    var themerPrimaryColor = primaryColor;
  </script>

    <script src="<?php echo base_url(); ?>assets/library/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/library/jquery/jquery-migrate.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/core_browser/ie/ie.prototype.polyfill.js"></script>    
    <script>if (/*@cc_on!@*/false && document.documentMode === 10) { document.documentElement.className+=' ie ie10'; }</script>
    
    <script src="<?php echo base_url('assets/library/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/core_nicescroll/jquery.nicescroll.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/core_preload/pace.min.js'); ?>"></script>
    
    <script src="<?php echo base_url('assets/js/common.admin.min.js'); ?>"></script>
</body>
</html>