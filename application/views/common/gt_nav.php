
      <div class="navbar hidden-print navbar-inverse main" role="navigation">
        <div class="user-action user-action-btn-navbar pull-left border-right">
          <button class="btn btn-sm btn-navbar btn-primary btn-stroke"><i class="fa fa-bars fa-2x"></i></button>
        </div>

        <div class="user-action visible-xs user-action-btn-navbar pull-right">
            <button class="btn btn-sm btn-navbar-right btn-primary">
                <i class="fa fa-fw fa-arrow-right"></i><span class="menu-left-hidden-xs"> Modules</span>
            </button>
        </div>
        <div class="user-action pull-right menu-right-hidden-xs menu-left-hidden-xs">
            <div class="dropdown username pull-left">
                <a class="dropdown-toggle " data-toggle="dropdown" href="#">
                  <span class="media margin-none">
                    <!--
                    <span class="pull-left"><img src="<?php echo base_url(); ?>assets/images/people/35/16.jpg" alt="user" class="img-circle"></span>
                    -->
                    <span class="media-body">
                      <?php echo $this->session->userdata('username'); ?> <span class="caret"></span> 
                    </span>
                  </span>
                </a>
                <ul class="dropdown-menu pull-right">
                  <li><a href="<?php echo base_url('gt/settings'); ?>">Settings</a></li>
                  <li><a href="<?php echo base_url('auth/logout'); ?>">Logout</a></li>
                </ul>
            </div>
        </div>
        <div class="user-action pull-right menu-right-hidden-xs menu-left-hidden-xs">
            <a href="<?php echo base_url('gt/sites'); ?>" class="btn btn-primary">사이트 관리</a>
        </div>
        
        <div class="clearfix"></div>
      </div>
      <!-- // END navbar -->
      
      <div class="layout-app">
      <!-- row -->