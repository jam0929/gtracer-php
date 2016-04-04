<!-- Main Sidebar Menu -->
<div id="menu" class="hidden-print hidden-xs sidebar-inverse sidebar-brand-blue">
        
  <div id="sidebar-fusion-wrapper">
    <div id="brandWrapper">
    <!--
      <a href="index.html" class="display-block-inline pull-left logo">
        <img src="<?php echo base_url(); ?>assets/images/logo/app-logo-style-default.png" alt="">
      </a>
    -->
      <a href="<?php echo base_url(); ?>gt/"><span class="text"><?php echo $title; ?></span></a>
    </div>
    <div id="logoWrapper">
      <div id="logo">
        
        <a href="<?php echo base_url(); ?>gt/" class="btn btn-sm btn-inverse">
            <i class="fa fa-fw icon-home-fill-1"></i>
        </a>
        <a href="email.html" class="btn btn-sm btn-inverse">
            <i class="fa fa-fw fa-bullhorn"></i><span class="badge pull-right badge-primary">2</span>
        </a>

        <div class="innerTB">
          <select name="" 
            id="menu_switch" 
            data-style="btn-inverse" 
            class="selectpicker margin-none dropdown-menu-light" 
            data-container="body">
            <option value="searching">선택된 사용자 없음</option>
          </select>
        </div>
      </div>
    </div>
    <!-- menu 1 -->
    <ul class="menu list-unstyled" id="navigation_current_page">
        <li <?php echo strrpos(current_url(), "dashboard") !== false ? 'class="active"' : ''; ?>>
        <a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-group"></i><span>대시보드</span></a>
      </li>
      <li <?php echo strrpos(current_url(), "users") !== false ? 'class="active"' : ''; ?>>
        <a href="<?php echo base_url(); ?>admin/users"><i class="fa fa-group"></i><span>사용자 관리</span></a>
      </li>
      <li <?php echo strrpos(current_url(), "sites") !== false ? 'class="active"' : ''; ?>>
        <a href="<?php echo base_url(); ?>admin/sites"><i class="fa fa-group"></i><span>사이트 관리</span></a>
      </li>
      <li <?php echo strrpos(current_url(), "permissions") !== false ? 'class="active"' : ''; ?>>
        <a href="<?php echo base_url(); ?>admin/permissions"><i class="fa fa-group"></i><span>권한 관리</span></a>
      </li>
      <li <?php echo strrpos(current_url(), "consults") !== false ? 'class="active"' : ''; ?>>
        <a href="<?php echo base_url(); ?>admin/consults"><i class="fa fa-group"></i><span>보고서 관리</span></a>
      </li>
    </ul>
  </div>
</div>
<!-- // Main Sidebar Menu END -->
    
        
            
<!-- Content -->
<div id="content">