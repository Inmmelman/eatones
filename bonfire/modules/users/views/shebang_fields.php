<?php /* /bonfire/modules/users/views/user_fields.php */

$currentMethod = $this->router->fetch_method();

$errorClass     = empty($errorClass) ? ' error' : $errorClass;
$controlClass   = empty($controlClass) ? 'span4' : $controlClass;
$registerClass  = $currentMethod == 'register' ? ' required' : '';
$editSettings   = $currentMethod == 'edit';

$defaultLanguage = isset($user->language) ? $user->language : strtolower(settings_item('language'));
$defaultTimezone = isset($current_user) ? $current_user->timezone : strtoupper(settings_item('site.default_user_timezone'));

?>
<div class="control-group<?php echo iif(form_error('phone'), $errorClass); ?>">
    <label class="control-label required" for="email"><?php echo lang('bf_phone'); ?></label>
    <div class="controls">
        <input class="<?php echo $controlClass; ?>" type="text" id="phone" name="phone" value="<?php echo set_value('phone', isset($user) ? $user->phone : ''); ?>" />
        <span class="help-inline"><?php echo form_error('phone'); ?></span>
    </div>
</div>
<div class="control-group<?php echo iif(form_error('display_name'), $errorClass); ?>">
    <label class="control-label" for="display_name"><?php echo lang('bf_display_name'); ?></label>
    <div class="controls">
        <input class="<?php echo $controlClass; ?>" type="text" id="display_name" name="display_name" value="<?php echo set_value('display_name', isset($user) ? $user->display_name : ''); ?>" />
        <span class="help-inline"><?php echo form_error('display_name'); ?></span>
    </div>
</div>

<div class="control-group<?php echo iif(form_error('password'), $errorClass); ?>">
    <label class="control-label<?php echo $registerClass; ?>" for="password"><?php echo lang('bf_password'); ?></label>
    <div class="controls">
        <input class="<?php echo $controlClass; ?>" type="password" id="password" name="password" value="" />
        <span class="help-inline"><?php echo form_error('password'); ?></span>
        <p class="help-block"><?php if (isset($password_hints) ) { echo $password_hints; } ?></p>
    </div>
</div>
<div class="control-group<?php echo iif(form_error('pass_confirm'), $errorClass); ?>">
    <label class="control-label<?php echo $registerClass; ?>" for="pass_confirm"><?php echo lang('bf_password_confirm'); ?></label>
    <div class="controls">
        <input class="<?php echo $controlClass; ?>" type="password" id="pass_confirm" name="pass_confirm" value="" />
        <span class="help-inline"><?php echo form_error('pass_confirm'); ?></span>
    </div>
</div>
<?php if ($editSettings) : ?>
<div class="control-group<?php echo iif(form_error('force_password_reset'), $errorClass); ?>">
    <div class="controls">
        <label class="checkbox" for="force_password_reset">
            <input type="checkbox" id="force_password_reset" name="force_password_reset" value="1" <?php echo set_checkbox('force_password_reset', empty($user->force_password_reset)); ?> />
            <?php echo lang('us_force_password_reset'); ?>
        </label>
    </div>
</div>
<?php endif; ?>
