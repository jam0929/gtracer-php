<div class="row row-app">
  <div class="col-md-12">
		<div class="col-separator col-separator-first bg-none">
			<div class="col-table">
				
				<div class="innerTB">
					<h3 class="margin-none pull-left">In-site 행동분석-페이지</h3>
					<ul class=" list-inline pull-right">
                        <li class="pull-right">
                            <select id="device-type" class="selectpicker" data-style="btn-default">
                                <option value="all" <?php echo isset($_GET['device']) && $_GET['device'] == 'all' ? 'selected' : ''; ?>>전체</option>
                                <option value="pc" <?php echo isset($_GET['device']) && $_GET['device'] == 'pc' ? 'selected' : ''; ?>>피씨</option>
                                <option value="mobile" <?php echo isset($_GET['device']) && $_GET['device'] == 'mobile' ? 'selected' : ''; ?>>모바일</option>
                            </select>
                        </li>
                        <li class="pull-right">
                            <select id="report-type" class="selectpicker" data-style="btn-default">
                                <option value="month">월간</option>
                                <option value="day">일간</option>
                                <option value="select">기간선택</option>
                            </select>
                        </li>
                        
                        <li id="report-type-month" class="report-type-details">
                            <input 
                                class="form-control datepicker" 
                                type="text" 
                                id="datepicker-month" />
                        </li>
                        
                        <li id="report-type-day" class="report-type-details">
                            <input 
                                class="form-control datepicker" 
                                type="text" 
                                id="datepicker-day" />
                        </li>
                        
                        <li id="report-type-select" class="report-type-details">
                            <ul class="list-inline">
                                <li>
                                    <input 
                                        class="form-control datepicker datepicker-select" 
                                        type="text" 
                                        id="datepicker-select-origin-from" />
                                </li>
                                <li>
                                    ~
                                </li>
                                <li>
                                    <input 
                                        class="form-control datepicker datepicker-select" 
                                        type="text" 
                                        id="datepicker-select-origin-to" />
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a 
                                data-table="product-rank-chart"
                                data-filename="행동분석-페이지"
                                href="#" 
                                class="btn btn-success btn-excel-export"
                            >EXCEL</a>
                        </li>
					</ul>
					<div class="clearfix"></div>
				</div>
				
				<div class="col-separator-h"></div>
				
				<div id="report-tab" class="row">
                    <div class="col-xs-12">
<!-- 상품 START -->
<div class="box-generic padding-none overflow-hidden">
    <div class="heading-buttons innerR half border-bottom bg-primary">
        <h4 class="innerAll margin-none pull-left text-white"><i class="fa fa-fw fa-money"></i>페이지</h4>
        <div class="clearfix"></div>
    </div>
    <div>페이지 행동분석 리포트는 엑셀다운만 가능합니다.</div>
    <div class="innerAll inner-2x bg-gray">
        <!-- Table -->
        <table 
            class="footable table table-striped table-primary chart hidden"
            id="product-rank-chart"
            data-ga-metrics="ga:pageviews,ga:exits,ga:exitRate,ga:pageValue"
            data-ga-dimensions="ga:pagePath"
            data-ga-sort="-ga:pageviews"
            data-chart-type="table"
        >
            <thead>
            <tr>
                <th class="center" style="width: 1%" data-sort-ignore="true">No.</th>
                <th class="center" >페이지URL</th>
                <th class="center" data-type="numeric">페이지뷰</th>
                <th class="center" data-type="numeric">이탈수</th>
                <th class="center" data-type="numeric" data-view-mode="percent">이탈률</th>
                <th class="center" data-type="numeric" data-view-mode="won">페이지가치</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <!-- // Table END -->
    </div>
</div>
<!-- // 상품 END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>