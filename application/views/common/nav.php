<nav class="dockbar navbar-fixed-top" id="header-dockbar">
  <menu class="main-menu">
    <div class="container">
      <div class="row">
        <a href="<?php echo base_url(); ?>" class="man-brand">
            <!--
          <span class="logotype">G-Tracer</span>
          <span class="doc-title">Analytics</span>
            -->
            <img src="/assets/img/logo_145.png" width="145" />
        </a>
        <button id="open-close-menu" class="menu-btn btn-inverse"><span class="fui-list"></span>
        </button>
        
        <dl class="pull-right">
            <!--
            <dd>
                <a href="<?php echo base_url(); ?>about" class="<?php echo uri_string() == 'about' ? 'active' : ''; ?>">
                    <?php echo lang('nav_about'); ?>
                </a>
            </dd>
            <dd>
                <a href="<?php echo base_url(); ?>how-it-works" class="<?php echo uri_string() == 'how-it-works' ? 'active' : ''; ?>">
                    <?php echo lang('nav_how_it_works'); ?>
                </a>
            </dd>
            <dd>
                <a href="<?php echo base_url(); ?>pricing" class="<?php echo uri_string() == 'pricing' ? 'active' : ''; ?>">
                    <?php echo lang('nav_pricing'); ?>
                </a>
            </dd>
            <?php if(isset($is_login) && $is_login == TRUE) : ?>
            <dd>
                <a href="<?php echo base_url(); ?>auth/logout" class="<?php echo uri_string() == 'auth/logout' ? 'active' : ''; ?>">
                    <?php echo lang('logout'); ?>
                </a>
            </dd>
            <?php else : ?>
            <dd>
                <a href="<?php echo base_url(); ?>auth/login" class="<?php echo uri_string() == 'auth/login' ? 'active' : ''; ?>">
                    <?php echo lang('nav_log_in_sign_up'); ?>
                </a>
            </dd>
            <?php endif; ?>
            <dd>
                <a href="<?php echo base_url(); ?>help" class="<?php echo uri_string() == 'help' ? 'active' : ''; ?>">
                    <?php echo lang('nav_help'); ?>
                </a>
            </dd>
            <?php if(isset($is_login) && $is_login == TRUE) : ?>
            <dd>
            <a href="<?php echo base_url(); ?>gt" class="palette palette-turquoise">
                <span class="fui-cmd"></span> <?php echo lang('nav_gtracer'); ?>
            </a>
            </dd>
            <?php endif; ?>
            <?php if(isset($is_admin) && $is_admin == TRUE) : ?>
            <dd>
            <a href="<?php echo base_url(); ?>admin" class="palette palette-turquoise">
                <span class="fui-cmd"></span> <?php echo lang('nav_admin'); ?>
            </a>
            </dd>
            <?php endif; ?>
            -->
            <?php if(isset($is_login) && $is_login == TRUE) : ?>
            <dd class="pull-right">
                <a href="<?php echo base_url(); ?>auth/logout">
                    <b>Logout</b>
                </a>
            </dd>
            <dd class="pull-right">
                <a href="<?php echo base_url('gt'); ?>">
                    <b>Console</b>
                </a>
            </dd>
            <?php endif; ?>
            <?php if(isset($is_admin) && $is_admin == TRUE) : ?>
            <dd class="pull-right">
                <a href="<?php echo base_url(); ?>admin">
                    <b>Admin</b>
                </a>
            </dd>
            <?php endif; ?>
            <dd class="pull-right">
                <a href="/#contact">
                    Contact
                </a>
            </dd>
            <dd class="pull-right">
                <a href="http://lab543.com" target="_new">
                    About LAB543
                </a>
            </dd>
            <?php if(!isset($is_login) OR $is_login != TRUE) : ?>
            <dd class="pull-right">
                <a href="<?php echo base_url(); ?>auth/login">
                    G-Tracer Login
                </a>
            </dd>
            <?php endif; ?>
            <dd class="pull-right">
                <a href="/#pricing">
                    G-Tracer Pricing
                </a>
            </dd>
            <dd class="pull-right">
                <a href="/#about">
                    About G-Tracer
                </a>
            </dd>
        </dl>
      </div>
    </div>
  </menu>
  <menu class="colapsed-menu">
    <dl>
        <!--
        <dd>
            <a href="<?php echo base_url(); ?>about" class="<?php echo uri_string() == 'about' ? 'active' : ''; ?>">
                <?php echo lang('nav_about'); ?>
            </a>
        </dd>
        <dd>
            <a href="<?php echo base_url(); ?>how-it-works" class="<?php echo uri_string() == 'how-it-works' ? 'active' : ''; ?>">
                <?php echo lang('nav_how_it_works'); ?>
            </a>
        </dd>
        <dd>
            <a href="<?php echo base_url(); ?>pricing" class="<?php echo uri_string() == 'pricing' ? 'active' : ''; ?>">
                <?php echo lang('nav_pricing'); ?>
            </a>
        </dd>
        <?php if(isset($is_login) && $is_login == TRUE) : ?>
        <dd>
            <a href="<?php echo base_url(); ?>auth/logout" class="<?php echo uri_string() == 'auth/logout' ? 'active' : ''; ?>">
                <?php echo lang('logout'); ?>
            </a>
        </dd>
        <?php else : ?>
        <dd>
            <a href="<?php echo base_url(); ?>auth/login" class="<?php echo uri_string() == 'auth/login' ? 'active' : ''; ?>">
                <?php echo lang('nav_log_in_sign_up'); ?>
            </a>
        </dd>
        <?php endif; ?>
        <dd>
            <a href="<?php echo base_url(); ?>help" class="<?php echo uri_string() == 'help' ? 'active' : ''; ?>">
                <?php echo lang('nav_help'); ?>
            </a>
        </dd>
        <?php if(isset($is_login) && $is_login == TRUE) : ?>
        <dd>
        <a href="<?php echo base_url(); ?>gt" class="palette palette-turquoise">
            <span class="fui-cmd"></span> <?php echo lang('nav_gtracer'); ?>
        </a>
        </dd>
        <?php endif; ?>
        <?php if(isset($is_admin) && $is_admin == TRUE) : ?>
        <dd>
        <a href="<?php echo base_url(); ?>admin" class="palette palette-turquoise">
            <span class="fui-cmd"></span> <?php echo lang('nav_admin'); ?>
        </a>
        </dd>
        <?php endif; ?>
        -->
        <dd class="pull-right">
            <a href="/#about">
                About G-Tracer
            </a>
        </dd>
        <dd class="pull-right">
            <a href="/#pricing">
                G-Tracer Pricing
            </a>
        </dd>
        <?php if(!isset($is_login) OR $is_login != TRUE) : ?>
        <dd class="pull-right">
            <a href="<?php echo base_url(); ?>auth/login">
                G-Tracer Login
            </a>
        </dd>
        <?php endif; ?>
        <dd class="pull-right">
            <a href="http://lab543.com" target="_new">
                About LAB543
            </a>
        </dd>
        <dd class="pull-right">
            <a href="/#contact">
                Contact
            </a>
        </dd>
        <?php if(isset($is_admin) && $is_admin == TRUE) : ?>
        <dd class="pull-right">
            <a href="<?php echo base_url(); ?>admin">
                <b>Admin</b>
            </a>
        </dd>
        <?php endif; ?>
        <?php if(isset($is_login) && $is_login == TRUE) : ?>
        <dd class="pull-right">
            <a href="<?php echo base_url('gt'); ?>">
                <b>Console</b>
            </a>
        </dd>
        <dd class="pull-right">
            <a href="<?php echo base_url('auth/logout'); ?>">
                <b>Logout</b>
            </a>
        </dd>
        <?php endif; ?>
    </dl>
  </menu>
</nav>

<div class="page-wrapper">
    <div class="container">