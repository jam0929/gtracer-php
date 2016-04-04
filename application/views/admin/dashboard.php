<div class="row row-app">
  <div class="col-md-12">
		<div class="col-separator col-separator-first bg-none">
			<div class="col-table">
				
				<div class="innerTB">
					<h3 class="margin-none pull-left">Dashboard &nbsp;<i class="fa fa-fw fa-pencil text-muted"></i></h3>
					<!--
                    <div class="btn-group pull-right">
						<a href="dashboard_analytics.html" class="btn btn-primary"><i class="fa fa-fw fa-bar-chart-o"></i> Analytics</a>
						<a href="dashboard_users.html" class="btn btn-default"><i class="fa fa-fw fa-user"></i> Users</a>
						<a href="dashboard_overview.html" class="btn btn-default"><i class="fa fa-fw fa-dashboard"></i> Overview</a>
					</div>
                    
                    -->
					<div class="clearfix"></div>
				</div>
				
				<div class="col-separator-h"></div>
                
                <div class="row">
					<div class="col-xs-6 col-md-3">
                        <!-- OVERALL PERFORMANCE START -->
                        <div class="box-generic innerAll inner-2x text-center">
                            <h4>전체 사용자</h4>
                            <p class="innerTB inner-2x text-xlarge text-condensed strong text-primary"><?php echo $users_count; ?></p>
                        </div>
                        <!-- // END OVERALL PERFORMANCE -->
                    </div>
					<div class="col-xs-6 col-md-3">
                        <!-- OVERALL PERFORMANCE START -->
                        <div class="box-generic innerAll inner-2x text-center">
                            <h4>유료 사용자</h4>
                            <p class="innerTB inner-2x text-xlarge text-condensed strong text-primary"><?php echo $paid_users_count; ?></p>
                        </div>
                        <!-- // END OVERALL PERFORMANCE -->
                    </div>
					<div class="col-xs-6 col-md-3">
                        <!-- OVERALL PERFORMANCE START -->
                        <div class="box-generic innerAll inner-2x text-center">
                            <h4>전체 사이트</h4>
                            <p class="innerTB inner-2x text-xlarge text-condensed strong text-primary"><?php echo $sites_count; ?></p>
                        </div>
                        <!-- // END OVERALL PERFORMANCE -->
                    </div>
					<div class="col-xs-6 col-md-3">
                        <!-- OVERALL PERFORMANCE START -->
                        <div class="box-generic innerAll inner-2x text-center">
                            <h4>유료 사이트</h4>
                            <p class="innerTB inner-2x text-xlarge text-condensed strong text-primary"><?php print_r($paid_sites_count); ?></p>
                        </div>
                        <!-- // END OVERALL PERFORMANCE -->
                    </div>
                    
                    
                    
                </div>
                
            </div>
        </div>
    </div>
</div>