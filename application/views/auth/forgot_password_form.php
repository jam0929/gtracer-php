<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
    'class' => 'form-control input-lg',
    'placeholder' => '',
    'required' => 'true',
	'maxlength'	=> 80,
);
if ($this->config->item('use_username', 'tank_auth')) {
	$login_label = 'Email or login';
} else {
	$login_label = 'Email';
}
$submit = array(
    'name' => 'reset',
    'value' => 'Get a new password',
    'class'=>'btn btn-primary btn-lg btn-block',
);
?>
<div class="container">
    <?php echo form_open($this->uri->uri_string()); ?>
        <div class="form-group">
            <?php echo form_label($login_label, $login['id']); ?>
            <?php echo form_input($login); ?>
        </div>
        <div class="form-group text-danger">
            <?php echo form_error($login['name']); ?>
            <?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
        </div>
    <?php echo form_submit($submit); ?>
    <?php echo form_close(); ?>
</div>