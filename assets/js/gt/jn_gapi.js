(function(d, t) {
    var g = d.createElement(t),
        s = d.getElementsByTagName(t)[0];
    g.src = '//apis.google.com/js/client.js?onload=jnGapiInit';
    s.parentNode.insertBefore(g, s);
}(document, 'script'));

function jnGapiInit() {
    gapi.client.setApiKey(jnGapi.apiKey);
    
    if($('#my-google-account').val()) {
        jnGapi.myGoogleAccout = $('#my-google-account').val();
        jnGapi.login();
    } else {
        if(confirm(
            '아직 연결된 구글 계정이 없습니다.\n'
            + '구글 계정 연동을 시작합니다. \n'
            + '한번 연동된 구글 계정은 결제 진행 후 변경이 불가하오니 신중하게 선택해주세요.'
        )) {    
            jnGapi.login();
        } else {
            $('a.connection').show();
        }
    }
}

// Google Oauth Information
var jnGapi = {
	clientId: '264752365528-anfr0unhnrjafqbithimn8a979bhqdrs.apps.googleusercontent.com',
	apiKey: 'AIzaSyBiH5ObpEoh3GPirVLXsyP-D27cQMnO-io',
	scopes: 'https://www.googleapis.com/auth/analytics.readonly \
            https://www.googleapis.com/auth/userinfo.email',
	data: [],
	accounts: null,
	properties: null,
	profiles: null,
    isConnected: false,
    myGoogleAccout: null,
    loginCallback: null,
    
    login: function() {
        gapi.auth.authorize({
			client_id: jnGapi.clientId, scope: jnGapi.scopes, immediate: true
		}, function(authResult) {
            if(authResult.error) {                    
                gapi.auth.authorize({
                    client_id: jnGapi.clientId, 
                    scope: jnGapi.scopes, 
                    immediate: false
                }, jnGapi._checkGoogleAccount);
                $('a.connection').show();
            } else {
                jnGapi._checkGoogleAccount();
            }
        });
    },
    
    _checkGoogleAccount: function() {
        gapi.client.load('oauth2', 'v2', function() {
            gapi.client.oauth2.userinfo.get().execute(function(userResult) {
                var param = {'googleAccount' : userResult.email};
                $.get(basePath+'gt/ajaxCheckGoogleAccount', param, function(resp) {
                    resp = JSON.parse(resp);
                    
                    if(resp.response != 200) {
                        alert('G-Tracer의 계정은 한개의 구글 계정과 연동됩니다.\n올바른 구글 계정으로 로그인해 주세요.');
                        $('#popup_msg').hide();
                        $('#wrong_id').show();
                        jnGapi.isConnected = false;
                        $('a.btn-google').hide();
                        $('a.logout').show();
                    } else {
                        jnGapi.isConnected = true;
                        $('a.btn-google').hide();
                        $('a.site-update').show();
                        gapi.client.load('analytics', 'v3', function() {
                            jnGapi.loginCallback();
                        });
                    }
                });
            });
        });
    },
    
    siteUpdate:function() {
        gapi.client.load('analytics', 'v3', function() {
            //이런 형태로 promise 가능
            gapi.client.analytics.management.accounts.list()
            .then(
                function(resp) {
                    jnGapi.accounts = resp.result;
                    chk_finish();
                }, 
                function(reson) {
                    console.log('Error: ' + reason.result.error.message);
                }
            );

            gapi.client.analytics.management.webproperties.list({
                'accountId' : '~all'
            }).then(
                function(webpropertiesResults) {
                    if(webpropertiesResults) {
                        jnGapi.properties = webpropertiesResults.result;
                        //console.log('prop get');
                        chk_finish();
                    } else {
                        setTimeout(jnGapi._handleAuthorized(), 1000);
                    }
                },
                function(reson) {
                    console.log('Error: ' + reason.result.error.message);
                }
            );
            
            gapi.client.analytics.management.profiles.list({
                'accountId' : '~all',
                'webPropertyId' : '~all'
            }).then(
                function(profilesResults) {
                    if(profilesResults) {
                        jnGapi.profiles = profilesResults.result;
                        //console.log('profile get');
                        chk_finish();
                    } else {
                        setTimeout(jnGapi._handleAuthorized(), 1000);
                    }
                },
                function(reson) {
                    console.log('Error: ' + reason.result.error.message);
                }
            );
            
            var chk_finish = function() {
                //console.log('chk');
                //data merge
                if(jnGapi.accounts != null && jnGapi.properties != null && jnGapi.profiles != null) {
                    //data mapping
                    for(i in jnGapi.accounts.items) {
                        jnGapi.data[jnGapi.accounts.items[i].id] = jnGapi.accounts.items[i];
                        jnGapi.data[jnGapi.accounts.items[i].id].properties = [];
                    }
                    for(i in jnGapi.properties.items) {
                        jnGapi.data[jnGapi.properties.items[i].accountId].properties[jnGapi.properties.items[i].id] = jnGapi.properties.items[i];
                        jnGapi.data[jnGapi.properties.items[i].accountId].properties[jnGapi.properties.items[i].id].profiles = [];
                    }
                    for(i in jnGapi.profiles.items) {
                        jnGapi.data[jnGapi.profiles.items[i].accountId].properties[jnGapi.profiles.items[i].webPropertyId].profiles[jnGapi.profiles.items[i].id] = jnGapi.profiles.items[i];
                    }
                    
                    jnGapi._onload();
                }
            }
        });
    },
	
	_onload: function() {
        var convArrToObj = function(array){
            var thisEleObj = new Object();
            if(typeof array == "object"){
                for(var i in array){
                    var thisEle = convArrToObj(array[i]);
                    thisEleObj[i] = thisEle;
                }
            } else {
                thisEleObj = array;
            }
            return thisEleObj;
        };
        
        var param = {};
        param[$('#csrf_token').attr('name')] = $('#csrf_token').val();
        param['sites'] = JSON.stringify(convArrToObj(jnGapi.data));
        param['username'] = jnGapi.accounts.username;
        
        $.post(basePath+'gt/ajaxCreateSites', param, function(resp) {
            location.reload();
        });
	},
    
    makeQuery: function(id, origin, compare, data, actionParam) {
        var param = jnGapi._setParam(id, origin, data);
        
        gapi.client.analytics.data.ga.get(param).then(
            function(result) {
                var originResult = result;
                
                param = jnGapi._setParam(id, compare, data);
                
                gapi.client.analytics.data.ga.get(param).then(
                    function(result) {
                        actionParam.callback(
                            originResult.result, 
                            result.result, 
                            actionParam
                        );
                    }
                );
            }
        );
    },
    
    _setParam: function (id, date, data) {
        var param = {
            'ids': id,
            'start-date': date.startDate,
            'end-date': date.endDate,
            'metrics' : data.metrics
        };
        
        if(data.dimensions) {
            param['dimensions'] = data.dimensions
        }
        
        if(data.filters) {
            param['filters'] = data.filters
        }
        
        if(data.maxresults) {
            param['max-results'] = data.maxresults
        }
        
        if(data.output) {
            param['output'] = data.output
        }
        
        if(data.samplinglevel) {
            param['samplingLevel'] = data.samplinglevel
        }
        
        if(data.segment) {
            param['segment'] = data.segment
        }
        
        if(data.sort && typeof(data.sort) != "function") {
            param['sort'] = data.sort
        }
        
        if(data.startindex) {
            param['start-index'] = data.startindex
        }
        
        if(data.fields) {
            param['fields'] = data.fields
        }
        
        return param;
    }
};