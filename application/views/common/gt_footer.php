
        <input id="csrf_token" type="hidden" 
            name="<?=$this->security->get_csrf_token_name()?>" 
            value="<?=$this->security->get_csrf_hash()?>" />
            
        <!-- // END row-app -->
      </div>
    </div>
	</div>
    
    <?php
        $dType = isset($_GET['dtype']) ? $_GET['dtype'] : '-1';
        $startDate = isset($_GET['start-date']) ? $_GET['start-date'] : '-1';
        $endDate = isset($_GET['end-date']) ? $_GET['end-date'] : '-1';
    ?>

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
    
    var fromDType = '<?php echo $dType; ?>';
    var fromStartDate = '<?php echo $startDate; ?>';
    var fromEndDate = '<?php echo $endDate; ?>';
  </script>
  
    <?php 
        echo !empty($this->data['myGoogleAccout']) 
            ? '<input type="hidden" 
                      id="my-google-account" 
                      value="'.$this->data['myGoogleAccout'].'" />'
            : '';
    ?>

    <script src="<?php echo base_url('assets/library/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/library/jquery/jquery-migrate.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/core_browser/ie/ie.prototype.polyfill.js'); ?>"></script>    
    <script src="<?php echo base_url('assets/library/chart/Chart.min.js'); ?>"></script>
    <script>if (/*@cc_on!@*/false && document.documentMode === 10) { document.documentElement.className+=' ie ie10'; }</script>
    
    <script src="<?php echo base_url('assets/library/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/core_nicescroll/jquery.nicescroll.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/core_preload/pace.min.js'); ?>"></script>
    
    <script src="<?php echo base_url('assets/plugins/tables_responsive/js/footable.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/tables_responsive/js/footable.sort.js'); ?>"></script>
    <script src="<?php echo base_url('assets/components/tables_responsive/tables-responsive-footable.init.js'); ?>"></script>
    
    
    <script src="<?php echo base_url('assets/library/excel/excellentexport.min.js'); ?>"></script>
    <!--
    <script src="<?php echo base_url('assets/library/excel/xlsx.core.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/library/excel/Export2Excel.js'); ?>"></script>
    <script src="<?php echo base_url('assets/library/excel/FileServer.js'); ?>"></script>
    <script src="<?php echo base_url('assets/library/excel/Blob.js'); ?>"></script>
    -->
    <!--
    <script src="<?php echo base_url(); ?>assets/library/modernizr/modernizr.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/charts_flot/excanvas.js"></script>
    <script src="<?php echo base_url('assets/plugins/core_breakpoints/breakpoints.js'); ?>"></script>
    <script src="<?php echo base_url('assets/components/core_preload/preload.pace.init.js'); ?>"></script>
    <script src="<?php echo base_url('assets/components/admin_menus/sidebar.main.init.js'); ?>"></script>
    <script src="<?php echo base_url('assets/components/admin_menus/sidebar.collapse.init.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/forms_elements_bootstrap-select/js/bootstrap-select.js'); ?>"></script>
    <script src="<?php echo base_url('assets/components/forms_elements_bootstrap-select/bootstrap-select.init.js'); ?>"></script>
    <script src="<?php echo base_url('assets/components/admin_menus/sidebar.kis.init.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/tables_responsive/js/footable.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/components/tables_responsive/tables-responsive-footable.init.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/forms_elements_bootstrap-switch/js/bootstrap-switch.js'); ?>"></script>
    <script src="<?php echo base_url('assets/components/forms_elements_bootstrap-switch/bootstrap-switch.init.js'); ?>"></script>
    <script src="<?php echo base_url('assets/components/core/core.init.js'); ?>"></script>
    -->
    
    <script src="<?php echo base_url('assets/js/common.gt.min.js'); ?>"></script>
</body>
</html>