var report = ['','',''];

$( document ).ready(function() {
    $('.goals').hide();
    $('.goals > ul > li').hide();
    jnGapi.loginCallback = loginCallback;
    
    $('#datepicker-month').datepicker(datepickerMonthOption);
    $('#datepicker-day').datepicker(datepickerDayOption);
    
    $('#datepicker-select-origin-from').datepicker(datepickerDayOption);
    $('#datepicker-select-origin-to').datepicker(datepickerDayOption);
    
    $('#report-tab').hide();
    $('#report').hide();
    $('.report-type-details').hide();
    
    $('#report-type').on('change', changeReportType);
    $('#device-type').on('change', clickViewReport);
    $('#menu_switch').on('change', linkClick);
    
    $('#view-report').on('click', clickViewReport);
    
    $('#navigation_current_page .hasSubmenu a').not('[data-toggle=collapse]').on('click', linkClick);
	$('.btn-excel-export').on('click', excelExport);
    
    $('#get_product').on('click', getProductList);
    $('#save_product').on('click', saveProduct);
});

var excelExport = function(e) {
    e.preventDefault();

    var $this = $(e.currentTarget);
    var tableId = $this.data('table');
    
    var param = {
        filename : $this.data('filename'),
        data : JSON.stringify(htmlUtil.tableToArray(tableId))
    };
    param[$('#csrf_token').attr('name')] = $('#csrf_token').val();
    
    $.post(basePath+'gt/ajaxExcelDownload', param, function(resp) {
        resp = JSON.parse(resp);
        
        if(resp && resp.response == '200') {
            window.open(resp.url);
        }
    });
};

var linkClick = function(e) {
    e.preventDefault();

    var $this = $(e.currentTarget);
    var url = $this.attr('href') ? $this.attr('href') : $(location).attr('href');
    var dType = $('#report-type').val();
    
    if (url.indexOf("?")>-1){
        url = url.substr(0,url.indexOf("?"));
    }
    
    url = url + '?select=' + $("#menu_switch option:selected").data('ga');
    url = url + '&device=' + $("#device-type").val();
    
    switch(dType) {
        case 'day' : 
            url = url + '&dtype='+dType
                +'&start-date='+$('#datepicker-day').val()
                +'&end-date='+$('#datepicker-day').val();
            break;
        case 'month' : 
            url = url + '&dtype='+dType
                +'&start-date='+$('#datepicker-month').val()
                +'&end-date='+$('#datepicker-month').val();
            break;
        case 'select' : 
            url = url + '&dtype='+dType
                +'&start-date='+$('#datepicker-select-origin-from').val()
                +'&end-date='+$('#datepicker-select-origin-to').val();
            break;
        default :
            break;
    }
    
    $(location).attr('href', url);
};

var changeReportType = function(e) {
    var $this = $(e.currentTarget);
    
	$('.report-type-details').hide();
	
    switch($this.val()) {
        case 'month' : 
            $('#report-type-month').show();
			$('#datepicker-month').datepicker()
				.on('changeDate', function(ev){
					$('#datepicker-month').datepicker('hide');
					clickViewReport();
			});
            break;
        case 'day' : 
            $('#report-type-day').show();
			$('#datepicker-day').datepicker()
				.on('changeDate', function(ev){
					$('#datepicker-day').datepicker('hide');
					clickViewReport();
			});
            break;
        case 'select' :
            $('#report-type-select').show();
			$('#datepicker-select-origin-from').datepicker()
				.on('changeDate', function(ev){
					$('#datepicker-select-origin-from').datepicker('hide');
					clickViewReport();
			});
			$('#datepicker-select-origin-to').datepicker()
				.on('changeDate', function(ev){
					$('#datepicker-select-origin-to').datepicker('hide');
					clickViewReport();
			});
    }
	
	clickViewReport();
};

var clickViewReport = function() {
    if($('#report-type').val() == 'month' && !$('#datepicker-month').val()) {
        alert(clickViewReportAlert);
        return false;
    }
    
    if($('#report-type').val() == 'day' && !$('#datepicker-day').val()) {
        alert(clickViewReportAlert);
        return false;
    }
    
    if($('#report-type').val() == 'select'  
        && (
            !$('#datepicker-select-origin-from').val() 
            || !$('#datepicker-select-origin-to').val()
        )
    ) {
        alert(clickViewReportAlert);
        return false;
    }
    
    chart.destory();
    report = ['','',''];
    $('.chart').hide();
    
    var duration = makeDuration();

    var origin = duration.origin;
    var compare = duration.compare;
    var originLabel = duration.originLabel;
    var compareLabel = duration.compareLabel;
    var profileId = $("#menu_switch option:selected").data('ga');
    
    $('.chart').each(function() {
        var data = {};
        var gaData = $(this).data();
        var searchWord = 'ga';
        var substringNum = 2;
        
        var actionParam = {
            'originLabel' : originLabel,
            'compareLabel' : compareLabel
        };
        
        if($(this).data('dayormonth')) {
            searchWord = 'ga' 
                + ($('#report-type').val() == 'day' ? 'Day' : 'Month');
            substringNum = $('#report-type').val() == 'day' ? 5 : 7;
            
            actionParam['labels'] = $('#report-type').val();
        }
        
        data = makeQueryParam(gaData,searchWord,substringNum);
        
        switch($(this).data('chart-type')) {
            case 'line' : 
                actionParam['callback'] = chart.makeLineChart;
                actionParam['forExcel'] = $(this).data('for-excel-table');
                break;
            case 'rank' :
                actionParam['callback'] = chart.makeRank;
                actionParam['valueType'] = $(this).data('ap-value-type');
                break;
            case 'table' : 
                actionParam['callback'] = chart.makeTable;
        }
        
        actionParam['target'] = '#' + $(this).attr('id');
        actionParam['report'] = $(this).data('report');
        actionParam['reportIndex'] = $(this).data('report-index');
        
        jnGapi.makeQuery(
            profileId,
            origin, 
            compare,
            data,
            actionParam
        );
    });
    $('#report-tab').show();
};

var makeDuration = function() {
    var origin = {};
    var compare = {};
    var originLabel = '';
    var compareLabel = '';
    
    switch($('#report-type').val()) {
        case 'month' :
            origin = dateUtil.getMonthStartEndDate(
                $('#datepicker-month').val(), 'yyyy-mm', 'yyyy-mm-dd'
            );
            
            compare = dateUtil.getMonthStartEndDate(
                dateUtil.add(
                    $('#datepicker-month').val(), 
                    {'month' : -1}, 
                    'yyyy-mm', 
                    'yyyy-mm'
                ),
                'yyyy-mm', 
                'yyyy-mm-dd'
            );
            
            originLabel = origin['startDate'].substring(5,7) + '월';
            compareLabel = compare['startDate'].substring(5,7) + '월';
            
            break;
        case 'day' :
            origin['startDate'] = $('#datepicker-day').val();
            origin['endDate'] = $('#datepicker-day').val();
            compare['startDate'] = dateUtil.add(
                $('#datepicker-day').val(), 
                {'date' : -1}, 
                'yyyy-mm-dd', 
                'yyyy-mm-dd'
            );
            compare['endDate'] = compare['startDate'];
                
            originLabel = origin['startDate'];
            compareLabel = compare['startDate'];
            
            break;
        case 'select' :
            origin['startDate'] = $('#datepicker-select-origin-from').val();
            origin['endDate'] = $('#datepicker-select-origin-to').val();
            
            var originStartDate = dateUtil.dateStringToDate(
                origin['startDate'], 'yyyy-mm-dd'
            );
            
            var originEndDate = dateUtil.dateStringToDate(
                origin['endDate'], 'yyyy-mm-dd'
            );
            
            var diff = originEndDate - originStartDate;
            
            if(diff < 0) {
                alert(selectDatepickerAlert);
                return false;
            }
            
            var compareStartDate = dateUtil.dateStringToDate(
                dateUtil.add(
                    origin['startDate'], 
                    {'date' : -1}, 
                    'yyyy-mm-dd', 
                    'yyyy-mm-dd'
                ),
                'yyyy-mm-dd'
            );
            
            var compareEndDate = dateUtil.dateStringToDate(
                dateUtil.add(
                    origin['endDate'], 
                    {'date' : -1}, 
                    'yyyy-mm-dd', 
                    'yyyy-mm-dd'
                ),
                'yyyy-mm-dd'
            );
            
            compare['startDate'] = dateUtil.dateToDateString(
                new Date(compareStartDate.getTime() - diff), 
                'yyyy-mm-dd'
            );
            
            compare['endDate'] = dateUtil.dateToDateString(
                new Date(compareEndDate.getTime() - diff),
                'yyyy-mm-dd'
            );
            
            originLabel = origin['startDate']+'~'+origin['endDate'];
            compareLabel = compare['startDate']+'~'+compare['endDate'];
    }
    
    return {
        'origin' : origin,
        'compare' : compare,
        'originLabel' : originLabel,
        'compareLabel' : compareLabel
    };
};

var makeQueryParam = function(gaData, searchWord, substringNum) {
    var data = [];
    
    for(key in gaData) {
        if(key.search(searchWord) != -1) {
            data[key.substring(substringNum).toLowerCase()] = gaData[key];
        } 
    }
    
    switch($('#device-type').val()) {
        case 'pc' :
            data['segment'] = 'sessions::condition::ga:deviceCategory==desktop,ga:deviceCategory==tablet';
            break;
        case 'mobile' :
            data['segment'] = 'sessions::condition::ga:deviceCategory==mobile';
            break;
        default : 
            break;
    }
    
    return data;
};

var makeReport = function(string, idx) {
    report[parseInt(idx)] = string;
    
    for(var i=0; i<4; i++) {
        if(report[i] == '') return false;
    }
    
    if($('#report-type').val() == 'month') {
        $('#report-title').html('전월 대비 보고서');
    } else if($('#report-type').val() == 'day') {
        $('#report-title').html('전일 대비 보고서');
    } else {
        $('#report-title').html('기간 대비 보고서');
    }
    
    for(i in report) {
        $('#report'+i).html(report[i]);
    }
    
    $('#report').show();
};

var loginCallback = function() {
    $('#alert-message').hide();
    $('.datepicker').datepicker('setValue', new Date());
    
    switch(fromDType) {
        case 'day' :
            $('#datepicker-day').val(fromStartDate);
            break;
        case 'month' :
            $('#datepicker-month').val(fromStartDate);
            break;
        case 'select' :
            $('#datepicker-select-origin-from').val(fromStartDate);
            $('#datepicker-select-origin-to').val(fromEndDate);
            break;
        default :
            fromDType = 'day';
            break;
    }
    
	$('#report-type').val(fromDType).change();
    
    var sid = $("#menu_switch option:selected").data('sid');
    if($('li[data-sid='+sid+']').length > 0) {
        $('.goals').show();
        $('li[data-sid='+sid+']').show();
    }
    
    var $menu = $('ul.collapse.in');
    $menu.collapse('hide');
    
};

var getProductList = function() {
    var origin = {
        'startDate' : '365daysAgo',
        'endDate' : 'today'
    };
    
    var compare = {
        'startDate' : 'today',
        'endDate' : 'today'
    };
    
    var profileId = $("#menu_switch option:selected").data('ga');
    
    jnGapi.makeQuery(
        profileId,
        origin, 
        compare,
        {
            'metrics' : 'ga:ItemRevenue',
            'dimensions' : 'ga:productName',
            'sort' : 'ga:productName',
            'filters' : 'ga:productName!@(not;ga:productName!@개인결제',
            'maxresults' : '10000'
        },
        {
            'callback' : callbackProductList
        }
    );
};

var callbackProductList = function(origin, compare, param) {
    $('#product-list').html('');
    
    for(i in origin.rows) {
        var trHtml =  
"<tr name='product'>"
    +"<td name='product_name'>"+origin.rows[i][0]+"</td>"
    +"<td><input name='product_roi' type='text' value='0'></input></td>"
+"</tr>"; 

        $('#product-list').append(trHtml);
    }
};

var saveProduct = function() {
    var $product = $('[name=product]');
    var productList = [];
    
    $product.each(function() {
        var product = {};
        
        product['name'] = $('[name=product_name]', $(this)).text();
        product['roi'] = $('[name=product_roi]', $(this)).val();
        
        productList.push(product);
    });
    
    var param = {
        'productList' : JSON.stringify(productList),
        'sid' : $('#menu_switch option:selected').attr('data-sid')
    };
    
    param[$('#csrf_token').attr('name')] = $('#csrf_token').val();
    
    $.post(basePath+'gt/ajaxSetProductList', param, function(resp) {
        resp = JSON.parse(resp);
        
        if(resp && resp.response == '200') {
            alert('상품 원가 정보가 업로드 되었습니다.');
        }
    });
};