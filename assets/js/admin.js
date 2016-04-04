if (typeof $.fn.bdatepicker == 'undefined')
	$.fn.bdatepicker = $.fn.datepicker.noConflict();
    
$(function(){
    $('#datepicker-inline').bdatepicker({
        format: 'yyyy-mm-dd',
        inline: true, 
        showOtherMonths:true
    }).on(
        'changeDate', 
        function(e){
            $('#activate-date').val(e.format()+" 23:59:59");
    });

    $('#modal-change').on('show.bs.modal', function(event) {
        var self = $(this);
        var btn = $(event.relatedTarget); // Button that triggered the modal
        var dialogType = btn.data('dialog-type'); // Extract info from data-* attributes
        var uid = btn.data('uid');
        var username = btn.data('username');
        
		self.find('form').hide();
		self.find('form.for-'+dialogType+' #uid').val(uid);

        switch(dialogType) {
            case 'google-init':
                self.find('.modal-title').text(username+'\'s google account init');
                break;
            case 'password':
                self.find('.modal-title').text(username+'\'s password change');
                break;
            case 'permission':
                self.find('.modal-title').text(username+'\'s permission change');
                break;
            case 'disable': 
                self.find('.modal-title').text(username+'\'s account disable');
				self.find('#is_banned').val(btn.data('is_banned'));
                break;
            case 'user-delete':
                self.find('.modal-title').text(username+'\'s account delete');
            default: break;
        }
		
		//form action bind
		self.find('form.for-'+dialogType).unbind('submit');
		self.find('form.for-'+dialogType).on('submit', function(e) {
            e.preventDefault();
			
			$.post(
				$(this).attr('action'), 
				$(this).serialize(), 
				function(resp) {
                    resp = JSON.parse(resp);
                    if(resp.response == 200) {
                        if(dialogType == 'permission') {
                            $('.user-permission', btn.parent()).text(resp.isAdmin == 1 ? '어드민' : '기본유저');
                        } else if(dialogType == 'disable') {
                            if(btn.data('is_banned') == '1') {
                                alert('계정이 활성화 되었습니다.')
                                btn.data('is_banned', '0');
                                btn.text('비활성화');
                                btn.removeClass('btn-success');
                                btn.addClass('btn-warning');
                            } else {
                                alert('계정이 비활성화 되었습니다.')
                                btn.data('is_banned', '1');
                                btn.text('활성화');
                                btn.removeClass('btn-warnig');
                                btn.addClass('btn-success');
                            }
                        } else if(dialogType == 'password') {
                            alert('패스워드가 변경되었습니다.');
                        } else if(dialogType == 'google-init') {
                            alert('연결되어 있던 구글 계정이 초기화되었습니다.');
                        } else if(dialogType == 'user-delete') {
                            var footable = $('.user-table').data('footable');
                            var row = $('.user-table > tbody > tr[data-uid='+uid+']');
                            
                            footable.removeRow(row);
                            alert('계정이 삭제되었습니다.');
                        } 
                    } else {
                        alert(resp.message);
                    }
                    
					self.modal('hide');
				}
			);
		});
		
		//show dialog
		self.find('form.for-'+dialogType).show();
    });
    
    $('#modal-sites').on('show.bs.modal', function(event) {
        var self = $(this);
        var btn = $(event.relatedTarget);
        var dialogType = btn.data('dialog-type');
        var formType = btn.data('form-type');
        var sid = btn.data('sid');
        var uid = btn.data('uid');
        var goalId = btn.data('goal-id');
        var $td = btn.parent();
        
		self.find('form').hide();
		self.find('form.for-'+formType+' #sid').val(sid);
        self.find('form.for-'+formType+' #uid').val(uid);
        self.find('form.for-'+formType+' #datepicker-inline').hide();

        switch(dialogType) {
            case 'activate':
                self.find('.modal-title').text('사이트 활성화');
                self.find('form.for-'+formType+' #msg').text('사이트를 활성화 합니다. 종료일을 선택 하세요.');
                self.find('#status').val('ACTIVATED');
                self.find('#btn-submit').text('활성화');
                self.find('#datepicker-inline').show();
                break;
            case 'add-date':
                self.find('.modal-title').text('활성화 기간 연장');
                self.find('form.for-'+formType+' #msg').text('활성화 기간을 연장합니다. 종료일을 선택 하세요.');
                self.find('#status').val('ACTIVATED');
                self.find('#btn-submit').text('연장');
                self.find('#datepicker-inline').show();
				break;
            case 'cancel-activate': 
                self.find('.modal-title').text('활성화 해제');
                self.find('form.for-'+formType+' #msg').text('사이트 활성화를 해제합니다.');
                self.find('#status').val('NOT ACTIVATED');
                self.find('#btn-submit').text('해제');
                break;
            case 'agree-request': 
                self.find('.modal-title').text('활성화 요청 수락');
                self.find('form.for-'+formType+' #msg').text('사이트 활성화 요청을 수락합니다. 종료일을 선택 하세요.');
                self.find('#status').val('ACTIVATED');
                self.find('#btn-submit').text('활성화');
                self.find('#datepicker-inline').show();
                break;
            case 'reject-request': 
                self.find('.modal-title').text('활성화 요청 거절');
                self.find('form.for-'+formType+' #msg').text('사이트 활성화 요청을 거절합니다.');
                self.find('#status').val('NOT ACTIVATED');
                self.find('#btn-submit').text('거절');
                break;
            case 'agree-pending-request': 
                self.find('.modal-title').text('활성화 연장 요청 수락');
                self.find('form.for-'+formType+' #msg').text('사이트 활성화 연장 요청을 수락합니다. 종료일을 선택 하세요.');
                self.find('#status').val('ACTIVATED');
                self.find('#btn-submit').text('연장');
                self.find('#datepicker-inline').show();
                break;
            case 'reject-pending-request': 
                self.find('.modal-title').text('활성화 연장 요청 거절');
                self.find('form.for-'+formType+' #msg').text('사이트 활성화 연장 요청을 거절합니다.');
                self.find('#status').val('ACTIVATED');
                self.find('#btn-submit').text('거절');
                self.find('#activate-date').val(btn.data('activate-date'));
                break;
            case 'add-goal':
                self.find('.modal-title').text('목표 추가');
                self.find('form.for-'+formType+' #msg').text('사이트에 목표를 추가합니다. 설정하고자 하는 목표의 이름과 번호를 입력해주세요.');
                $('#goal_name').val('');
                $('#goal_num').val('');
                break;
            case 'delete-goal':
                self.find('.modal-title').text('목표 삭제');
                self.find('form.for-'+formType+' #msg').text('해당 목표를 삭제하시겠습니까?');
                console.log('form.for-'+formType+' #gid');
                self.find('form.for-'+formType+' #gid').val(goalId);
                break;
            default: break;
        }
		
		//form action bind
		self.find('form.for-'+formType).unbind('submit');
		self.find('form.for-'+formType).on('submit', function(e) {
            e.preventDefault();
			
			$.post(
				$(this).attr('action'), 
				$(this).serialize(), 
				function(resp) {
                    resp = JSON.parse(resp);
                    if(resp.response == 200) {
                        switch(dialogType) {
                            case 'activate':
                                alert('사이트를 활성화 하였습니다.');
                                $td.html(activatedHtml(sid));
                                break;
                            case 'add-date':
                                alert('사이트 활성화 기간을 연장 하였습니다.');
                                $td.html(activatedHtml(sid));
                                break;
                            case 'cancel-activate': 
                                alert('사이트 활성화를 해제 하였습니다.');
                                $td.html(notActivatedHtml(sid));
                                break;
                            case 'agree-request': 
                                alert('사이트를 활성화 요청을 수락 하였습니다.');
                                $td.html(activatedHtml(sid));
                                break;
                            case 'reject-request': 
                                alert('활성화 요청을 취소하였습니다.');
                                $td.html(notActivatedHtml(sid));
                                break;
                            case 'agree-pending-request': 
                                alert('사이트를 활성화 연장 요청을 수락 하였습니다.');
                                $td.html(activatedHtml(sid));
                                break;
                            case 'reject-pending-request': 
                                alert('활성화 연장 요청을 취소하였습니다.');
                                $td.html(activatedHtml(sid));
                                break;
                            case 'add-goal':
                            console.log(resp);
                                alert('목표가 추가되었습니다.');
                                $('div[name=goals][data-sid='+sid+']').append(
                                    goalHtml(
                                        resp.goalId, 
                                        $('#goal_num').val(), 
                                        $('#goal_name').val()
                                    )
                                );
                                break;
                            case 'delete-goal':
                                alert('목표가 삭제되었습니다.');
                                $('div[data-goal-id='+goalId+']').remove();
                                break;
                            default: break;
                        }
                    } else {
                        alert(resp.message);
                    }
                    
					self.modal('hide');
				}
			);
		});
		
		//show dialog
		self.find('form.for-'+formType).show();
    });
    
    $('#modal-permission').on('show.bs.modal', function(event) {
        var self = $(this);
        var btn = $(event.relatedTarget); // Button that triggered the modal
        var dialogType = btn.data('dialog-type'); // Extract info from data-* attributes
        
        /*
		self.find('form').hide();
		self.find('form.for-'+dialogType+' #uid').val(uid);
        
        switch(dialogType) {
            case 'google-init':
                self.find('.modal-title').text(username+'\'s google account init');
                break;
            case 'password':
                self.find('.modal-title').text(username+'\'s password change');
                break;
            case 'permission':
                self.find('.modal-title').text(username+'\'s permission change');
                break;
            case 'disable': 
                self.find('.modal-title').text(username+'\'s account disable');
				self.find('#is_banned').val(btn.data('is_banned'));
                break;
            case 'user-delete':
                self.find('.modal-title').text(username+'\'s account delete');
            default: break;
        }
        */
		
		//form action bind
		self.find('form.for-'+dialogType).unbind('submit');
		self.find('form.for-'+dialogType).on('submit', function(e) {
            e.preventDefault();
			
			$.post(
				$(this).attr('action'), 
				$(this).serialize(), 
				function(resp) {
                    resp = JSON.parse(resp);
                    if(resp.response == 200) {
                        if(dialogType == 'permission') {
                            $('.user-permission', btn.parent()).text(resp.isAdmin == 1 ? '어드민' : '기본유저');
                        } else if(dialogType == 'disable') {
                            if(btn.data('is_banned') == '1') {
                                alert('계정이 활성화 되었습니다.')
                                btn.data('is_banned', '0');
                                btn.text('비활성화');
                                btn.removeClass('btn-success');
                                btn.addClass('btn-warning');
                            } else {
                                alert('계정이 비활성화 되었습니다.')
                                btn.data('is_banned', '1');
                                btn.text('활성화');
                                btn.removeClass('btn-warnig');
                                btn.addClass('btn-success');
                            }
                        } else if(dialogType == 'password') {
                            alert('패스워드가 변경되었습니다.');
                        } else if(dialogType == 'google-init') {
                            alert('연결되어 있던 구글 계정이 초기화되었습니다.');
                        } else if(dialogType == 'user-delete') {
                            var footable = $('.user-table').data('footable');
                            var row = $('.user-table > tbody > tr[data-uid='+uid+']');
                            
                            footable.removeRow(row);
                            alert('계정이 삭제되었습니다.');
                        } 
                    } else {
                        alert(resp.message);
                    }
                    
					self.modal('hide');
				}
			);
		});
		
		//show dialog
		self.find('form.for-'+dialogType).show();
    });
    
    $('#pem-type').change(function(e) {
        $this = $(e.currentTarget);
        
        $(location).attr('href', basePath+'admin/permissions/'+$this.val());
    });
    
    $('input[name="pem_chk"]').bootstrapSwitch({
        'onColor' : 'success',
        'offColor' : 'default'
    });
    
    $('#pem_save').on('click', function() {
        if(confirm("변경사항을 저장하시겠습니까?")) {
            var pem_ids = getPemIds();
            
            if(originPemIds == pem_ids) {
                alert('변경사항이 없습니다.');
                return false;
            }
            
            var param = {
                'pem_ids' : pem_ids,
                'pid' : $('#pem-type').val()
            };
            
            param[$('#csrf_token').attr('name')] = $('#csrf_token').val();
            
            $.post(basePath+'admin/ajaxUpdatePermission', param, function(resp) {
                resp = JSON.parse(resp);
                
                if(resp && resp.response == '200') {
                    alert('저장되었습니다.');
                }
            });
        } else {
            return false;
        }
    });
    
    $('#pem_delete').on('click', function() {
        if(confirm("'"+$('#pem-type option:selected').text().trim()+"' 권한을 삭제하시겠습니까?")) {
            var param = {
                'pid' : $('#pem-type').val()
            };
            
            param[$('#csrf_token').attr('name')] = $('#csrf_token').val();
            
            $.post(basePath+'admin/ajaxDeletePermission', param, function(resp) {
                resp = JSON.parse(resp);
                
                if(resp && resp.response == '200') {
                    alert('삭제되었습니다.');
                    $(location).attr('href', basePath+'admin/permissions/');
                }
            });
            
        } else {
            return false;
        }
    });
    
    $('#site-permission').change(function(e) {
        $this = $(e.currentTarget);
        
        if(confirm("'"+$('option:selected', $this).text().trim()+"' 권한으로 변경하시겠습니까?")) {
            var param = {
                'pid' : $this.val(),
                'sid' : $this.closest('td').attr('data-sid')
            };
            
            param[$('#csrf_token').attr('name')] = $('#csrf_token').val();
            
            $.post(basePath+'admin/ajaxSitePermissionChange', param, function(resp) {
                resp = JSON.parse(resp);
                
                if(resp && resp.response == '200') {
                    alert('권한이 변경되었습니다.');
                }
            });
        }
    });
    
    var getPemIds = function() {
        var temp = '';
        
        $('input[name="pem_chk"').each(function(){
            if($(this).bootstrapSwitch('state')) {
                if(temp != '') {
                    temp += ',' + $(this).closest('tr').attr('data-pid');
                } else {
                    temp += $(this).closest('tr').attr('data-pid');
                }
            };
        });
        
        return temp;
    };
    
    var originPemIds = getPemIds();
    
    /*
    $('input[name="pem_chk"').on('switchChange.bootstrapSwitch', function(event, state) {
        var $this = $(this);
        var mid = $this.closest('tr').attr('data-pid');
        var pid = $('#pem-type').val();
    });
    */
    
    var notActivatedHtml = function(sid) {
        var html = 
'<button \
    class="btn btn-primary btn-xs" \
    data-toggle="modal" \
data-target="#modal-sites" \
data-dialog-type="activate" \
data-form-type="activate" \
data-sid="'+sid+'" \
data-whatever="@twbootstrap"> \
활성화 \
</button>';

        return html;
    };
    
    var activatedHtml = function(sid,date) {
        var html = 
$('#activate-date').val()+' \
<button \
    class="btn btn-success btn-xs" \
    data-toggle="modal" \
    data-target="#modal-sites" \
    data-dialog-type="add-date" \
    data-form-type="activate" \
    data-sid="'+sid+'" \
    data-whatever="@twbootstrap"> \
    연장 \
</button> \
<button \
    class="btn btn-danger btn-xs" \
    data-toggle="modal" \
    data-target="#modal-sites" \
    data-dialog-type="cancel-activate" \
    data-form-type="cancel-activate" \
    data-sid="'+sid+'" \
    data-whatever="@twbootstrap"> \
    해제 \
</button>';

        return html;
    };
    
    var goalHtml = function(goalId, goalNumber, goalName) {
        var html = 
'<div name="goal" data-goal-id="'+goalId+'">'
    + goalNumber + ' : ' + goalName + 
    '<span>\
        <button \
            class="btn btn-danger btn-xs" \
            data-toggle="modal" \
            data-target="#modal-sites" \
            data-dialog-type="delete-goal" \
            data-form-type="delete-goal" \
            data-goal-id="'+goalId+'" \
            data-whatever="@twbootstrap"> \
            제거 \
        </button> \
    </span> \
</div>';

        return html;
    };
});