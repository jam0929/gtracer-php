$( document ).ready(function() {
    chart.init();
});

var getRevenue = function() {
    var origin = {
        'startDate': '2014-10-01',
        'endDate': '2014-10-31'
    };
    
    var compare = {
        'startDate': '2014-09-01',
        'endDate': '2014-09-30'
    };
    
    var data = {
        'metrics': 'ga:transactionRevenue',
        'dimensions' : 'ga:date'
    };
    
    var actionParam = {
        'callback' : chart.makeLineChart,
        'target' : '#revenue-chart'
    }
    
    jnGapi.makeQuery(
        'ga:72087850',
        origin, 
        compare,
        data,
        actionParam
    );
}

var getProduct = function() {
    var origin = {
        'startDate': '2014-11-01',
        'endDate': '2014-11-30'
    };
    
    var compare = {
        'startDate': '2014-10-01',
        'endDate': '2014-10-31'
    };
    
    var data = {
        'metrics': 'ga:itemRevenue',
        'dimensions' : 'ga:productName',
        'maxResults' : '10',
        'sort' : '-ga:itemRevenue'
    };
    
    var actionParam = {
        'callback' : chart.makeRank,
        'target' : '#product-rank'
    }
    
    jnGapi.makeQuery(
        'ga:72087850',
        origin, 
        compare,
        data,
        actionParam
    );
}

var numberWithCommas = function(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}