var siteStatus = {
    "notActivated" : "NOT ACTIVATED",
    "pending" : "PENDING",
    "activated" : "ACTIVATED",
    "activatedPending" : "ACTIVATED PENDING",
};

var hourLabel = [
    "00",
    "01",
    "02",
    "03",
    "04",
    "05",
    "06",
    "07",
    "08",
    "09",
    "10",
    "11",
    "12",
    "13",
    "14",
    "15",
    "16",
    "17",
    "18",
    "19",
    "20",
    "21",
    "22",
    "23"
];

var dateLabel = [
    "01",
    "02",
    "03",
    "04",
    "05",
    "06",
    "07",
    "08",
    "09",
    "10",
    "11",
    "12",
    "13",
    "14",
    "15",
    "16",
    "17",
    "18",
    "19",
    "20",
    "21",
    "22",
    "23",
    "24",
    "25",
    "26",
    "27",
    "28",
    "29",
    "30",
    "31"
];

var weekLabel = [
    "01",
    "02",
    "03",
    "04",
    "05"
];

var monthLabel = [
    "01",
    "02",
    "03",
    "04",
    "05",
    "06",
    "07",
    "08",
    "09",
    "10",
    "11",
    "12"
];

var datepickerMonthOption = {
    'viewMode' : 1, 
    'minViewMode' : 1,
    'format' : 'yyyy-mm'
}

var datepickerWeekOption = {
    'viewMode' : 0, 
    'minViewMode' : 0,
    'format' : 'yyyy-mm-dd'
}

var datepickerDayOption = {
    'viewMode' : 0, 
    'minViewMode' : 0,
    'format' : 'yyyy-mm-dd'
}

var defaultRankHtml = 
'\
<tr class="selectable"> \
<td class="center">{{rank}}</td> \
<td class="strong">{{name}}</td> \
<td class="center">{{icon}}{{changed}}</td> \
<td class="center">{{value}}</td> \
<td class="center">{{value1}}</td> \
</tr> \
';

var rankUpIcon = '<i class="fa fa-fw fa-arrow-up text-success"></i>';
var rankDownIcon = '<i class="fa fa-fw fa-arrow-down text-danger"></i>';
var rankEqualIcon = '<i class="fa fa-fw fa-minus text-primary"></i>';
var rankNewIcon = '<span class="label label-primary">new</span>';

var krwIcon = '<i class="fa fa-krw"></i>';