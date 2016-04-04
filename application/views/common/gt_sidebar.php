<!-- Main Sidebar Menu -->
<div id="menu" class="hidden-print hidden-xs sidebar-inverse sidebar-brand-blue">
        
  <div id="sidebar-fusion-wrapper">
    <div id="brandWrapper">
    <!--
      <a href="index.html" class="display-block-inline pull-left logo">
        <img src="<?php echo base_url(); ?>assets/images/logo/app-logo-style-default.png" alt="">
      </a>
    -->
      <a href="<?php echo base_url('gt'); ?>"><span class="text"><?php echo $title; ?></span></a>
    </div>
    <div id="logoWrapper">
      <div id="logo">
        
        <a href="<?php echo base_url('gt'); ?>" class="btn btn-sm btn-inverse">
            <i class="fa fa-fw icon-home-fill-1"></i>
        </a>
        <a href="email.html" class="btn btn-sm btn-inverse">
            <i class="fa fa-fw fa-bullhorn"></i><span class="badge pull-right badge-primary">2</span>
        </a>

        <div class="innerTB">
          <select name="" 
            id="menu_switch" 
            data-style="btn-inverse" 
            class="selectpicker margin-none" 
            data-container="body">
            <?php if(empty($this->data['activatedSites'])) : ?>
            <option value="searching">연동 사이트 없음</option>
            <?php else : ?>
            <?php foreach($this->data['activatedSites'] as $site) :?>
            <option 
                value="navigation_current_page" 
                data-ga="<?php echo 'ga:'.$site->profile_id;?>" 
                data-sid="<?php echo $site->id; ?>"
                <?php echo isset($_GET['select']) && $_GET['select'] == 'ga:'.$site->profile_id ? 'selected' : '' ?>
            >
                <?php echo $site->property_name.' > '.$site->profile_name; ?>
            </option>
            <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>
      </div>
    </div>
    <?php if(!empty($this->data['activatedSites'])) : ?>
    <!-- menu 1 -->
    <ul class="menu list-unstyled" id="navigation_current_page">
      <?php foreach($this->data['menus'] as $menu) : ?>
      <li class="hasSubmenu <?php echo uri_string() == $menu->type.'/'.$menu->eng_name ? 'active' : ''; ?>">
        <?php if(!empty($menu->subMenus)) : ?>
        <a href="#menu-<?php echo $menu->eng_name; ?>" data-toggle="collapse">
          <i class="fa fa-globe"></i><span><?php echo $menu->name; ?></span>
        </a>
        <ul 
            class="collapse <?php echo strpos(uri_string(), $menu->type.'/report/'.$menu->eng_name) !== false ? 'in' : ''; ?>" 
            id="menu-<?php echo $menu->eng_name; ?>"
        >
        <?php foreach($menu->subMenus as $subMenu) : ?>
            <?php foreach($this->data['pem_ids'] as $pemId) : ?>
            <?php if($pemId == $subMenu->id) : ?>
            <li class="<?php echo strpos(uri_string(), $menu->type.'/report/'.$subMenu->eng_name) !== false ? 'active' : ''; ?>">
                <a href="<?php echo base_url($menu->type.'/report/'.$subMenu->eng_name); ?>">
                    <i class="fa fa-bar-chart-o"></i><span><?php echo $subMenu->name; ?></span>
                </a>
            </li>
            <?php endif; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
        </ul>
        <?php else : ?>
        <?php foreach($this->data['pem_ids'] as $pemId) : ?>
        <?php if($pemId == $menu->id) : ?>
        <a href="<?php echo base_url($menu->type.'/'.$menu->eng_name); ?>">
            <i class="fa fa-dashboard"></i><span><?php echo $menu->name; ?></span>
        </a>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php endif; ?>
      </li>
      <?php endforeach; ?>
      <?php if(!empty($this->data['goals'])) : ?>
      <li class="goals hasSubmenu <?php echo strpos(uri_string(), 'gt/goal') !== false ? 'active' : ''; ?>">
        <a href="#menu-goal" data-toggle="collapse">
            <i class="fa fa-globe"></i><span>목표 분석</span>
        </a>
        <ul class="collapse <?php echo strpos(uri_string(), 'gt/goal') !== false ? 'in' : ''; ?>" id="menu-goal">
            <?php foreach($this->data['goals'] as $goal) : ?>
            <li data-sid="<?php echo $goal->sid; ?>" class="<?php echo strpos(uri_string(), 'gt/goal') !== false ? 'active' : ''; ?>">
                <a href="<?php echo base_url('gt/goal/'.$goal->id); ?>">
                    <i class="fa fa-bar-chart-o"></i><span><?php echo $goal->goal_name; ?></span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
      </li>
      <?php endif; ?>
      <!--li class="hasSubmenu <?php echo strpos(uri_string(), 'gt/report/insite') !== false ? 'active' : ''; ?>">
        <a href="#menu-behavior" data-toggle="collapse">
            <i class="fa fa-toggle-right"></i><span>In-site 행동 분석</span>
        </a>
        <ul class="collapse" id="menu-behavior">
            <li class="">
                <a href="<?php echo base_url('gt/report/insite_page'); ?>">
                    <i class="fa fa-bar-chart-o"></i><span>페이지</span>
                </a>
            </li>
        </ul>
      </li>
      <li class="hasSubmenu <?php echo strpos(uri_string(), 'gt/consults') !== false ? 'active' : ''; ?>">
        <a href="<?php echo base_url('gt/consults'); ?>">
            <i class="fa fa-file-text-o"></i><span>컨설팅 보고서</span>
        </a>
      </li-->
    </ul>
    <?php endif; ?>
  </div>
</div>
<!-- // Main Sidebar Menu END -->
    
        
            
<!-- Content -->
<div id="content">