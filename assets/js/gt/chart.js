var chart = {
    charts: [],
    destory: function() {
        for(i in chart.charts) {
            chart.charts[i].destroy();
        }
        
        chart.charts = [];
    },
    
    init: function() {
        Chart.defaults.global = {
            // Boolean - Whether to animate the chart
            animation: true,

            // Number - Number of animation steps
            animationSteps: 60,

            // String - Animation easing effect
            animationEasing: "easeOutQuart",

            // Boolean - If we should show the scale at all
            showScale: true,

            // Boolean - If we want to override with a hard coded scale
            scaleOverride: false,

            // ** Required if scaleOverride is true **
            // Number - The number of steps in a hard coded scale
            scaleSteps: null,
            // Number - The value jump in the hard coded scale
            scaleStepWidth: null,
            // Number - The scale starting value
            scaleStartValue: null,

            // String - Colour of the scale line
            scaleLineColor: "rgba(0,0,0,.1)",

            // Number - Pixel width of the scale line
            scaleLineWidth: 1,

            // Boolean - Whether to show labels on the scale
            scaleShowLabels: true,

            // Interpolated JS string - can access value
            scaleLabel: "<%=value%>",

            // Boolean - Whether the scale should stick to integers, not floats even if drawing space is there
            scaleIntegersOnly: true,

            // Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
            scaleBeginAtZero: false,

            // String - Scale label font declaration for the scale label
            scaleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

            // Number - Scale label font size in pixels
            scaleFontSize: 12,

            // String - Scale label font weight style
            scaleFontStyle: "normal",

            // String - Scale label font colour
            scaleFontColor: "#666",

            // Boolean - whether or not the chart should be responsive and resize when the browser does.
            //responsive: false,
            responsive: true,

            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,

            // Boolean - Determines whether to draw tooltips on the canvas or not
            showTooltips: true,

            // Array - Array of string names to attach tooltip events
            tooltipEvents: ["mousemove", "touchstart", "touchmove"],

            // String - Tooltip background colour
            tooltipFillColor: "rgba(0,0,0,0.8)",

            // String - Tooltip label font declaration for the scale label
            tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

            // Number - Tooltip label font size in pixels
            tooltipFontSize: 14,

            // String - Tooltip font weight style
            tooltipFontStyle: "normal",

            // String - Tooltip label font colour
            tooltipFontColor: "#fff",

            // String - Tooltip title font declaration for the scale label
            tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

            // Number - Tooltip title font size in pixels
            tooltipTitleFontSize: 14,

            // String - Tooltip title font weight style
            tooltipTitleFontStyle: "bold",

            // String - Tooltip title font colour
            tooltipTitleFontColor: "#fff",

            // Number - pixel width of padding around tooltip text
            tooltipYPadding: 6,

            // Number - pixel width of padding around tooltip text
            tooltipXPadding: 6,

            // Number - Size of the caret on the tooltip
            tooltipCaretSize: 8,

            // Number - Pixel radius of the tooltip border
            tooltipCornerRadius: 6,

            // Number - Pixel offset from point x to tooltip edge
            tooltipXOffset: 10,

            // String - Template string for single tooltips
            tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= numberWithCommas(value) %>",

            // String - Template string for single tooltips
            multiTooltipTemplate: "<%if (datasetLabel){%><%=datasetLabel%>: <%}%><%= numberWithCommas(value) %>",

            // Function - Will fire on animation progression.
            onAnimationProgress: function(){},

            // Function - Will fire on animation completion.
            onAnimationComplete: function(){}
        }
    },
    
    makeRank : function(originResult, compareResult, actionParam) {
        var $table = $(actionParam.target);
        $table = $('tbody', $table);
        
        $table.html('');
        
        var tableData = [];
        var originRows = originResult.rows;
        var compareRows = compareResult.rows;
        
        for(i in originRows) {
            var data = {
                'name' : originRows[i][0],
                'rank' : parseInt(i)+1,
                'value1' : parseInt(originRows[i][2])
            };
            
            switch(actionParam.valueType) {
                case 'won' :
                    data['value'] 
                        = krwIcon + numberWithCommas(parseFloat(originRows[i][1]));
                    break;
                case 'percent':
                    data['value'] 
                        = parseFloat(originRows[i][1]).toFixed(2) + '%';
                    break;
            }
            
            for(j in compareRows) {
                data['changed'] = -9999;
                if(originRows[i][0] == compareRows[j][0]) {
                    data['changed'] = j - i;
                    data['changedRank'] = j - i;
                    break;
                }
            }
            
            if(data.changed == -9999) {
                data['changed'] = '';
                data['icon'] = rankNewIcon;
            } else if(data.changed > 0) {
                data['changed'] = data.changed + ' 상승';;
                data['icon'] = rankUpIcon;
            } else if(data.changed < 0) {
                data['changed'] = Math.abs(data.changed) + ' 하락';
                data['icon'] = rankDownIcon;
            } else {
                data['changed'] = '유지';
                data['icon'] = rankEqualIcon;
            }
            
            tableData.push(data);
        }
        
        if(actionParam.report && tableData.length > 0) {
            var minI = [0,0];
            var maxI = [0,0];
            
            for(i in tableData) {
                if(tableData[i].changedRank < minI[1]) {
                    minI[0] = i;
                    minI[1] = tableData[i].changedRank;
                }
                
                if(tableData[i].changedRank > maxI[1]) {
                    maxI[0] = i;
                    maxI[1] = tableData[i].changedRank;
                }
            }
            
            var reportObject = {
                'name1' : tableData[maxI[0]].name ? tableData[maxI[0]].name : '',
                'value1' : maxI[1],
                'name2' : tableData[minI[0]].name ? tableData[minI[0]].name : '',
                'value2' : Math.abs(minI[1])
            }
            
            var reportString = actionParam.report;
            
            for(key in reportObject) {
                reportString 
                    = reportString.replace("{{"+key+"}}", reportObject[key]);
            }
            
            makeReport(reportString, actionParam.reportIndex);
        } else if(tableData.length == 0) {
            makeReport("데이터 없음.", actionParam.reportIndex);
        }
        
        for(i in tableData) {
            if(i > 9) break;
            var trHtml = actionParam.trHtml? actionParam.trHtml : defaultRankHtml;
            
            for(key in tableData[i]) {
                trHtml = trHtml.replace("{{"+key+"}}", tableData[i][key]);
            }
            
            $table.append(trHtml);
        }
        
        $(actionParam.target).show();
    },

    makeLineChart : function(originResult, compareResult, actionParam) {
        var ctx = $(actionParam.target).get(0).getContext("2d");
        
        var originData = [];
        var compareData = [];
        var labels = [];
        var isSetLabels = false;
        
        if(actionParam['labels'] == 'month') {
            labels = dateLabel;
            isSetLabels = true;
        } else if(actionParam['labels'] == 'day') {
            labels = hourLabel;
            isSetLabels = true;
        } 
        
        for(i in originResult.rows) {
            originData.push(parseFloat(originResult.rows[i][1]));
            if(!isSetLabels) {
                labels.push(
                    originResult.rows[i][0].substring(4)
                    +" / "
                    +compareResult.rows[i][0].substring(4)
                );
            }
        }
        
        for(i in compareResult.rows) {
            compareData.push(parseFloat(compareResult.rows[i][1]));
        }
        
        if(actionParam.report) {
            var originValue = 0;
            var compareValue = 0;
            
            for(i in originData) {
                originValue += originData[i];
            }
            
            for(i in compareData) {
                compareValue += compareData[i];
            }
            
            var reportObject = {
                'value1':numberWithCommas(originValue),
                'value2':originValue - compareValue > 0 
                    ? (((originValue - compareValue)/compareValue)*100).toFixed(2)
                    : (((compareValue - originValue)/compareValue)*100).toFixed(2),
                'updown':originValue - compareValue > 0 ? "증가" : "감소"
            };
            
            var reportString = actionParam.report;
            
            for(key in reportObject) {
                reportString 
                    = reportString.replace("{{"+key+"}}", reportObject[key]);
            }
            
            makeReport(reportString, actionParam.reportIndex);
        }
        
        var $excelTable = $('#'+actionParam.forExcel);
        $excelTable = $('tbody', $excelTable);
        $excelTable.html('');
        
        for(i=0; i<originData.length || i<compareData.length; i++) {
            var trHtml = '<tr><td>'+(parseInt(i) + 1)+'</td><td>'+labels[i]+'</td>';
            
            if(originData[i]) {
                trHtml = trHtml
                    +'<td>'+actionParam.originLabel+'</td>'
                    +'<td>'+originData[i]+'</td>';
            } else {
                trHtml = trHtml
                    +'<td>'+actionParam.originLabel+'</td>'
                    +'<td>0</td>';
            }
            
            if(compareData[i]) {
                trHtml = trHtml
                    +'<td>'+actionParam.compareLabel+'</td>'
                    +'<td>'+compareData[i]+'</td>';
            } else {
                trHtml = trHtml
                    +'<td>'+actionParam.compareLabel+'</td>'
                    +'<td>0</td>';
            }
            
            trHtml += "</tr>";
            $excelTable.append(trHtml);
        }
        var data = {
            labels: labels,
            datasets: [
                {
                    label: actionParam.originLabel,
                    fillColor: "rgba(235,106,90,0.2)",
                    strokeColor: "rgba(235,106,90,1)",
                    pointColor: "rgba(235,106,90,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(235,106,90,1)",
                    data: originData
                },
                {
                    label: actionParam.compareLabel,
                    fillColor: "rgba(220,220,220,0.2)",
                    strokeColor: "rgba(220,220,220,1)",
                    pointColor: "rgba(220,220,220,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: compareData
                }
            ]
        };
        
        var myLineChart = new Chart(ctx).Line(data, Chart.defaults.Line);
        chart.charts.push(myLineChart);
        $(actionParam.target).show();
    },
    
    makeTable : function(originResult, compareResult, actionParam) {
        var $table = $(actionParam.target);
        
        var viewMode = [];
        
        $('th', $table).each(function(idx, th) {
            if($(th).data('view-mode')) {
                viewMode[idx] = $(th).data('view-mode');
            } else {
                viewMode[idx] = 'default';
            }
        });
        
        $table = $('tbody', $table);
        
        $table.html('');
        
        var originRows = originResult.rows;
		
        var countColumns;
        
        if($(actionParam.target).attr('data-roi')) {
            var param = {'sid' : $("#menu_switch option:selected").data('sid')}
            $.get(basePath+'gt/ajaxGetProducts', param, function(resp) {
                resp = JSON.parse(resp);
        
                if(resp && resp.response == '200') {
                    for(i in originRows) {
                        var trHtml = '<tr><td>'+(parseInt(i) + 1)+'</td>';
                        countColumns = 1;
                        
                        var j = 1;
                        for(key in originRows[i]) {
                            trHtml = trHtml + "<td>";
                            
                            switch(viewMode[j++]) {
                                case 'won' : 
                                    trHtml = trHtml
                                        + krwIcon 
                                        + numberWithCommas(parseFloat(originRows[i][key])) 
                                        + "</td>"; 
                                    break;
                                case 'second' : 
                                    trHtml = trHtml
                                        + parseFloat(originRows[i][key]).toFixed(2)
                                        + "초</td>"; 
                                    break;
                                case 'percent' : 
                                    trHtml = trHtml 
                                        + parseFloat(originRows[i][key]).toFixed(2)
                                        +"%</td>"; 
                                    break;
                                case 'fixed2' :
                                    trHtml = trHtml 
                                        + parseFloat(originRows[i][key]).toFixed(2)
                                        +"</td>"; 
                                    break;
                                default : 
                                    trHtml = trHtml 
                                        + originRows[i][key];
                                        +"</td>";
                            }                    
                            
                            countColumns++;
                        }
                        
                        trHtml = trHtml + "<td>";
                        
                        for(key in resp.products) {
                            if(resp.products[key].name == originRows[i][0]) {
                                trHtml = trHtml
                                    + krwIcon 
                                    + numberWithCommas(parseFloat(resp.products[key].roi)) 
                                    + "</td><td>";
                                    
                                var roi = parseFloat(originRows[i][2])
                                    - (parseFloat(resp.products[key].roi) 
                                    * parseFloat(originRows[i][1]))
                                
                                trHtml = trHtml
                                    + krwIcon 
                                    + numberWithCommas(parseFloat(roi)) 
                                    + "</td>";
                                break;
                            }
                        }
                        
                        trHtml += "</tr>";
                        $table.append(trHtml);
                    }
                } else {
                    alert('원가 정보를 불러오는데 실패했습니다.');
                }
            });
        } else {
            for(i in originRows) {
                var trHtml = '<tr><td>'+(parseInt(i) + 1)+'</td>';
                countColumns = 1;
                
                var j = 1;
                for(key in originRows[i]) {
                    trHtml = trHtml + "<td>";
                    
                    switch(viewMode[j++]) {
                        case 'won' : 
                            trHtml = trHtml
                                + krwIcon 
                                + numberWithCommas(parseFloat(originRows[i][key]).toFixed(2)) 
                                + "</td>"; 
                            break;
                        case 'second' : 
                            trHtml = trHtml
                                + parseFloat(originRows[i][key]).toFixed(2)
                                + "초</td>"; 
                            break;
                        case 'percent' : 
                            trHtml = trHtml 
                                + parseFloat(originRows[i][key]).toFixed(2)
                                +"%</td>"; 
                            break;
                        case 'fixed2' :
                            trHtml = trHtml 
                                + parseFloat(originRows[i][key]).toFixed(2)
                                +"</td>"; 
                            break;
                        default : 
                            trHtml = trHtml 
                                + originRows[i][key];
                                +"</td>";
                    }                    
                    
                    countColumns++;
                }
                
                trHtml += "</tr>";
                $table.append(trHtml);
            }
        }
        
        $(actionParam.target).show();
        //$(actionParam.target).data('footable').redraw();
		
		//20150116 Hwan Oh
        if($(actionParam.target).data('subchart')) {
            $('tr', $table).on('click', function(e) {
                var $this = $(e.currentTarget);
                
                if($this.hasClass('opened')) {
                    //close
                    $this.removeClass('opened');
                    $this.next().hide().remove();
                    
                } else {
                    var duration = makeDuration();
                    var origin = duration.origin;
                    var profileId = $("#menu_switch option:selected").data('ga');
                    var gaData = makeQueryParam(
                        $(actionParam.target).data(), 
                        'subchart', 
                        8
                    );
                    
                    if(gaData.filters) {
                        gaData.filters = gaData.filters
                            + $('td', $this).eq(
                                $(actionParam.target).data('subchart-filter-index')
                            ).html().replace('<br>','<BR />');
                    }
                    
                    var param = jnGapi._setParam(profileId, origin, gaData);
                    
                    gapi.client.analytics.data.ga.get(param).then(
                        function(result) {
                            var headers = $(actionParam.target).data(
                                'subchart-column-header'
                            ).split(',');
                            
                            var types = $(actionParam.target).data(
                                'subchart-column-type'
                            ).split(',');
                            
                            //open
                            html = '<tr class="subchart">'
                                +'	<td colspan="'+countColumns+'">'
                                +'		<table class="table margin-none">'
                                +'			<thead>'
                                +'              <tr class="subchart">';
                            
                            for(i in headers) {
                                html = html + '				<th>'+headers[i]+'</th>';
                            }
                            html = html 
                                +'      </tr>'
                                +'          </thead>'
                                +'			<tbody>';
                            
                            for(i=0;i<result.result.rows.length;i++ ){
                                html = html +'				<tr class="subchart">';
                                for(j=0;j<result.result.rows[i].length;j++) {
                                    switch(types[j]) {
                                        case 'won' : 
                                            html = html 
                                                +'<td>'
                                                + krwIcon 
                                                + numberWithCommas(parseFloat(result.result.rows[i][j]))
                                                +'</td>';
                                            break;
                                        case 'num' : 
                                            html = html 
                                                +'<td>'
                                                + numberWithCommas(parseFloat(result.result.rows[i][j]))
                                                +'</td>';
                                            break;
                                        case 'str' : 
                                            html = html 
                                                +'<td>'
                                                + result.result.rows[i][j]
                                                +'</td>';
                                            break;
                                    }
                                }
                                html = html +'				</tr>';
                            }
                            
                            html = html +'			</tbody>'
                                +'		</table>'
                                +'	</td>'
                                +'</tr>';
                            
                            $(html).insertAfter($this);
                            $this.addClass('opened');
                        }
                    );
                }
            });
        }
    }
};