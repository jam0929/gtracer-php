$( document ).ready(function() {
    $('a.btn-google').hide();

    $('#modal-change').on('show.bs.modal', openRequestModal);
    $('a.site-update').on('click', clickSiteUpdate);
    $('a.connection').on('click', clickConnection);
    
    $('.make-switch:not(.has-switch)').bootstrapSwitch();
    $('.make-switch').on('switch-change', switchChanged);
});

var openRequestModal = function(e) {
    var self = $(this);
    var btn = $(e.relatedTarget);
    var sid = btn.parent().parent().data('sid');
    var dialogType = btn.data('dialog-type');
    
    self.find('form').hide();
    self.find('form #sid').val(sid);
    
    switch(dialogType) {
        case 'activate':
            self.find('.modal-title').text(activateRequestModalTitle);
            self.find('#msg').text(activateRequestModalMsg);
            self.find('#btn-submit').text(activateRequestModalSubmitBtn);
            self.find('form #status').val(siteStatus.pending);
            break;
        case 'activate-pending':
            self.find('.modal-title').text(activatedPendingRequestModalTitle);
            self.find('#msg').text(activatedPendingRequestModalMsg);
            self.find('#btn-submit').text(activatedPendingRequestModalSubmitBtn);
            self.find('form #status').val(siteStatus.activatedPending);
            break;
        case 'cancel-activate':
            self.find('.modal-title').text(activateRequestCancelModalTitle);
            self.find('#msg').text(activateRequestCancelModalMsg);
            self.find('#btn-submit').text(activateRequestCancelModalSubmitBtn);
            self.find('form #status').val(siteStatus.notActivated);
            break;
        case 'cancel-activate-pending':
            self.find('.modal-title').text(activatedPendingRequestCancelModalTitle);
            self.find('#msg').text(activatedPendingRequestCancelModalMsg);
            self.find('#btn-submit').text(
                activatedPendingRequestCancelModalSubmitBtn
            );
            self.find('form #status').val(siteStatus.activated);
            break;
        default: break;
    }
    
    self.find('form').unbind('submit');
    self.find('form').on('submit', function(e) {
        e.preventDefault();
        
        $.post(
            $(this).attr('action'), 
            $(this).serialize(), 
            function(resp) {
                resp = JSON.parse(resp);
                if(resp.response == 200) {
                    switch(dialogType) {
                        case 'activate':
                            alert(activateRequestModalAlert);
                            btn.data('dialog-type','cancel-activate');
                            btn.removeClass('btn-primary');
                            btn.addClass('btn-success');
                            btn.text(activateRequestModalChangeBtn);
                            break;
                        case 'activate-pending':
                            alert(activatedPendingRequestModalAlert);
                            btn.data('dialog-type','cancel-activate-pending');
                            btn.removeClass('btn-primary');
                            btn.addClass('btn-success');
                            btn.text(activatedPendingRequestModalChangeBtn);
                            break;
                        case 'cancel-activate':
                            alert(activateRequestCancelModalAlert);
                            btn.data('dialog-type','activate');
                            btn.removeClass('btn-success');
                            btn.addClass('btn-primary');
                            btn.text(activateRequestCancelModalChangeBtn);
                            break;
                        case 'cancel-activate-pending':
                            alert(activatedPendingRequestCancelModalAlert);
                            btn.data('dialog-type','activate-pending');
                            btn.removeClass('btn-success');
                            btn.addClass('btn-primary');
                            btn.text(activatedPendingRequestCancelModalChangeBtn);
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
    self.find('form').show();
}

var clickSiteUpdate = function() {
    if(jnGapi.isConnected) {
        jnGapi.siteUpdate();
    } else {
        alert(siteUpdateAlert);
    }
}

var clickConnection = function() {
    jnGapi.login();
}

var switchChanged = function(e, data) {
    $('.make-switch').bootstrapSwitch('setActive', false);
    $this = $(e.currentTarget);
    sid = $this.parent().parent().data('sid');
    
    if(data.value) {
        var param = {
            'sid' : sid,
            'isDefault' : 1,
        };
        param[$('#csrf_token').attr('name')] = $('#csrf_token').val();
        
        $.post(
            'ajax-set-default-site',
            param,
            function(resp) {
                $('.make-switch').each(function() {
                    if($(this) != $this) {
                        $(this).bootstrapSwitch('setState', false, true);
                    }
                });
        
                $this.bootstrapSwitch('setState', true, true);
                $("[data-status="+siteStatus.activated+"] .make-switch")
                    .bootstrapSwitch('setActive', true);
            }
        );
    } else {
        alert(defaultSwitchAlert);
        $this.bootstrapSwitch('setState', true);
        $("[data-status="+siteStatus.activated+"] .make-switch")
            .bootstrapSwitch('setActive', true);
    }
}