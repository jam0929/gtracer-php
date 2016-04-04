var dateUtil = {
    dateStringToDate : function(dateString, format) {
        if(format == 'yyyy-mm-dd') {
            return new Date(
                dateString.substring(0,4),
                dateString.substring(5,7) - 1,
                dateString.substring(8,10)
            );
        } else if(format == 'yyyy-mm') {
            return new Date(
                dateString.substring(0,4),
                dateString.substring(5,7) - 1
            );
        }
    },

    dateToDateString : function(date, returnFormat) {
        var m = (date.getMonth() + 1) < 10 
                ? '0' + (date.getMonth() + 1) 
                : (date.getMonth() + 1);
        
        var d = date.getDate() < 10 
                ? '0' + date.getDate() 
                : date.getDate();
        
        return dateUtil._changeFormat(
            date.getFullYear() + '-' + m + '-' + d, 
            'yyyy-mm-dd', 
            returnFormat
        );
    },
    
    getMonthStartEndDate : function(dateString, format, returnFormat) {
        var dateObject = {};
    
        if(format == 'yyyy-mm') {
            var year = dateString.substring(0,4);
            var month = dateString.substring(5,7);
            
            dateObject = {
                'startDate' : dateString + '-01',
                'endDate' : dateString + '-' 
                    + (new Date(year, month, 0)).getDate()
            }
        }
        
        return {
            'startDate' : dateUtil._changeFormat(
                dateObject.startDate,
                'yyyy-mm-dd', 
                returnFormat
            ),
            'endDate' : dateUtil._changeFormat(
                dateObject.endDate,
                'yyyy-mm-dd', 
                returnFormat
            )
        }
    },
    
    add: function(dateString, val, format, returnFormat) {
        var date = dateUtil.dateStringToDate(dateString, format);
        
        if(val.year) {
            date.setFullYear(date.getFullYear() + val.year);
        }
        
        if(val.month) {
            date.setMonth(date.getMonth() + val.month);
        }
        
        if(val.date) {
            date.setDate(date.getDate() + val.date);
        }
        
        return dateUtil.dateToDateString(date, returnFormat);
    },
    
    _changeFormat : function(dateString, format, returnFormat) {
        if(format == returnFormat) return dateString;
        else if(returnFormat == 'yyyy-mm') {
            return dateString.substring(0,7);
        }
    }
}

var numberUtil = {
    isNumber : function(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    },
    
    isInt : function(n){
        return Number(n)===parseInt(n) && n%1===0;
    }
}

var htmlUtil = {
    tableToArray : function(tableId) {
        var returnArr = [];
        
        $('#'+tableId+' tr').not('.subchart').each(function(i, v) {
            var tdArr = [];
            
            $('th, td', $(v)).each(function(i2,v2) {
                if($('input', $(v2)).length) {
                    tdArr.push($('input', $(v2)).val());
                } else {
                    tdArr.push($(v2).text());
                }
            });
            returnArr.push(tdArr);
        });
        
        return returnArr;
    }
}