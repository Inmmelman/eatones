<?php

$validation_errors = validation_errors();
$errorClass = ' error';
$controlClass = 'span6';
$fieldData = array(
    'errorClass'    => $errorClass,
    'controlClass'  => $controlClass,
);

?>
<style>
p.already-registered {
    text-align: center;
}
</style>
<section id="register">
    <h1 class="page-header"><?php echo lang('us_sign_up'); ?></h1>
    <?php if ($validation_errors) : ?>
	<div class="alert alert-error fade in">
		<?php echo $validation_errors; ?>
	</div>
    <?php endif; ?>
    <div  id="accordion">
        <h3>Обычный пользвоатель</h3>
        <div >
            <?php echo form_open( site_url(REGISTER_URL), array('class' => "form-horizontal", 'autocomplete' => 'off')); ?>
				<?php Template::block('user_fields', 'user_fields', $fieldData);?>
                <div class="control-group">
                    <div class="controls">
                        <input class="btn btn-primary" type="submit" name="register" id="submit" value="<?php echo "Продолжить"; ?>"  />
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>
        <h3>Заведение<h3>
        <div>
            <?php echo form_open( site_url(REGISTER_URL), array('class' => "form-horizontal", 'autocomplete' => 'off')); ?>
            <?php Template::block('shebang_fields', 'shebang_fields', $fieldData);?>
            <div class="control-group">
                <div class="controls">
                    <input type="hidden" name="userinfos">
                    <input class="btn btn-primary" type="submit" name="register" id="submit" value="<?php echo "Продолжить"; ?>"  />
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $( "#accordion" ).accordion({
            active: false,
            collapsible: true
        });
    });
</script>