<div class="row row-app">
  <div class="col-md-12">
		<div class="col-separator col-separator-first bg-none">
            <div id="alert-message">
                이 글이 사라지지 않을 경우 다음 사항을 확인해보세요.
                1. 브라우저의 팝업 차단으로 인하여 구글 로그인 창이 열리지 않은 경우입니다. 팝업 차단을 해제한 후 다시 시도해 주세요.
                2. 현재 연결되어 있는 구글 계정이 G-Tracer에 등록되어 있는 계정이 아닌 경우입니다. 현재 구글 계정에서 로그아웃 하시고 올바른 구글계정으로 로그인 후 다시 시도해 주세요.
            </div>
			<div class="col-table">
				
				<div class="innerTB">
					<h3 class="margin-none pull-left">대시보드</h3>
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
					</ul>
					<div class="clearfix"></div>
				</div>
				
				<div class="col-separator-h"></div>
				
				<div id="report-tab" class="row">

<!-- EXPENSE START -->
<div class="box-generic padding-none overflow-hidden">
    <div class="heading-buttons innerR half border-bottom">
        <h4 id="report-title" class="innerAll margin-none pull-left">Monthly Spend</h4>
        <div class="clearfix"></div>
    </div>
    <div class="innerAll inner-2x bg-gray border-bottom">   
        <ol>
            <li id="report0"></li>
            <li id="report1"></li>
            <li id="report2"></li>
        </ol>
        <ul class="margin-none">
            <li id="report3"></li>
        </ul>
    </div>
</div>
<!-- // END EXPENSE -->

<!-- // END DETAILS -->
                    <div class="col-xs-12">
<!-- 수익 START -->
<div class="box-generic padding-none overflow-hidden">
    <div class="heading-buttons innerR half border-bottom bg-primary">
        <h4 class="innerAll margin-none pull-left text-white"><i class="fa fa-fw fa-money"></i>수익</h4>
        <ul class=" list-unstyled pull-right">
            <li>
                <a 
                    data-table="for-excel"
                    data-filename="대시보드-수익"
                    href="#" 
                    class="btn btn-success btn-excel-export"
                >EXCEL</a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="innerAll inner-2x bg-gray">
        <canvas 
            class="chart" 
            id="revenue-chart"
            data-dayormonth="true"
            data-ga-month-metrics="ga:transactionRevenue"
            data-ga-month-dimensions="ga:date"
            data-ga-day-metrics="ga:transactionRevenue"
            data-ga-day-dimensions="ga:dateHour"
            data-chart-type="line"
            data-report="총 수익 {{value1}}원으로 {{value2}}% {{updown}}하였습니다."
            data-report-index="3"
            data-for-excel-table="for-excel"
        ></canvas>
    </div>
</div>
<!-- // 수익 END -->

<!-- 수익 START -->
<div class="hidden">
    <!-- Table -->
    <table id="for-excel">
        <thead>
        <tr>
            <th class="center" style="width: 1%" data-sort-ignore="true">No.</th>
            <th>기준시(일)</th>
            <th>날짜1</th>
            <th>수익1</th>
            <th>날짜2</th>
            <th>수익2</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <!-- // Table END -->
</div>
<!-- // 수익 END -->
                    </div>
                    <div class="col-xs-12">
<!-- 상품 START -->
<div class="box-generic padding-none overflow-hidden">
    <div class="heading-buttons innerR half border-bottom bg-primary">
        <h4 class="innerAll margin-none pull-left text-white"><i class="fa fa-fw fa-money"></i>상품</h4>
        <ul class=" list-unstyled pull-right">
            <li>
                <a 
                    data-table="product-rank-chart"
                    data-filename="대시보드-상품"
                    href="#" 
                    class="btn btn-success btn-excel-export"
                >EXCEL</a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="innerAll inner-2x bg-gray">
        <!-- Table -->
        <table 
            class="footable table table-vertical-center margin-none chart footable"
            id="product-rank-chart"
            data-ga-metrics="ga:itemRevenue,ga:itemQuantity"
            data-ga-dimensions="ga:productName"
            data-ga-sort="-ga:itemRevenue"
            data-chart-type="rank"
            data-ap-value-type="won"
            
            data-report="상품 {{name1}}의 판매량이 {{value1}} 단계 증가, {{name2}}의 판매량이 {{value2}} 단계 감소"
            data-report-index="0"
        >
            <thead>
            <tr>
                <th class="center" style="width: 1%" data-sort-ignore="true">No.</th>
                <th>상품명</th>
                <th class="center" data-sort-ignore="true">순위</th>
                <th class="center" data-type="numeric">수익</th>
                <th class="center" data-type="numeric">수량</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <!-- // Table END -->
    </div>
</div>
<!-- // 상품 END -->
<!-- 전환율 START -->
<div class="box-generic padding-none overflow-hidden">
    <div class="heading-buttons innerR half border-bottom bg-primary">
        <h4 class="innerAll margin-none pull-left text-white"><i class="fa fa-fw fa-money"></i>전환율</h4>
        <ul class=" list-unstyled pull-right">
            <li>
                <a 
                    data-table="source-medium-conversion-rank-chart"
                    data-filename="대시보드-전환율"
                    href="#" 
                    class="btn btn-success btn-excel-export"
                >EXCEL</a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="innerAll inner-2x bg-gray">
        <!-- Table -->
        <table 
            class="footable table table-vertical-center margin-none chart"
            id="source-medium-conversion-rank-chart"
            
            data-ga-metrics="ga:transactionsPerSession,ga:transactions"
            data-ga-dimensions="ga:sourceMedium"
            data-ga-sort="-ga:transactionsPerSession"
            data-ga-filters="ga:transactions>9;ga:sourceMedium!@not set"
            
            data-chart-type="rank"
            data-ap-value-type="percent"
            
            data-report="{{name1}}채널의 전환율이 {{value1}} 단계 증가, {{name2}}채널의 전환율이 {{value2}} 단계 감소"
            data-report-index="1"
        >
            <thead>
            <tr>
                <th class="center" style="width: 1%" data-sort-ignore="true">No.</th>
                <th>소스/매체</th>
                <th class="center" data-sort-ignore="true">순위</th>
                <th class="center" data-type="numeric">전환율</th>
                <th class="center" data-type="numeric">전환수</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <!-- // Table END -->
    </div>
</div>
<!-- // 전환율 END -->

<!-- 이탈율 START -->
<div class="box-generic padding-none overflow-hidden">
    <div class="heading-buttons innerR half border-bottom bg-primary">
        <h4 class="innerAll margin-none pull-left text-white"><i class="fa fa-fw fa-money"></i>이탈율</h4>
        <ul class=" list-unstyled pull-right">
            <li>
                <a 
                    data-table="source-medium-bounce-rank-chart"
                    data-filename="대시보드-이탈율"
                    href="#" 
                    class="btn btn-success btn-excel-export"
                >EXCEL</a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="innerAll inner-2x bg-gray">
        <!-- Table -->
        <table 
            class="footable table table-vertical-center margin-none chart"
            id="source-medium-bounce-rank-chart"
            data-dayormonth="true"
            
            data-ga-month-metrics="ga:bounceRate,ga:bounces"
            data-ga-month-dimensions="ga:sourceMedium"
            data-ga-month-sort="-ga:bounceRate"
            data-ga-month-filters="ga:bounces>999;ga:sourceMedium!@not set"
            
            data-ga-day-metrics="ga:bounceRate,ga:bounces"
            data-ga-day-dimensions="ga:sourceMedium"
            data-ga-day-sort="-ga:bounceRate"
            data-ga-day-filters="ga:bounces>99;ga:sourceMedium!@not set"
            
            data-chart-type="rank"
            data-ap-value-type="percent"
            
            data-report="{{name1}}채널의 이탈율이 {{value1}} 단계 증가, {{name2}}페이지의 이탈율이 {{value2}} 단계 감소"
            data-report-index="2"
        >
            <thead>
            <tr>
                <th class="center" style="width: 1%" data-sort-ignore="true">No.</th>
                <th>소스/매체</th>
                <th class="center" data-sort-ignore="true">순위</th>
                <th class="center" data-type="numeric">이탈율</th>
                <th class="center" data-type="numeric">이탈수</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <!-- // Table END -->
    </div>
</div>
<!-- // 전환율 END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>