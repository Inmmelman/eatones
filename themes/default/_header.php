<?php
    Assets::add_js( 'bootstrap.min.js' );
    Assets::add_css( array('bootstrap.min.css', 'bootstrap-responsive.min.css'));

    $inline  = '$(".dropdown-toggle").dropdown();';
    $inline .= '$(".tooltips").tooltip();';

    Assets::add_js( $inline, 'inline' );
?>
<!doctype html>
<head>

    <title><?php echo isset($page_title) ? $page_title .' : ' : ''; ?> <?php if (class_exists('Settings_lib')) e(settings_item('site.title')); else echo 'Bonfire'; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo js_path(); ?>jquery-1.7.2.min.js"><\/script>')</script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="//vk.com/js/api/openapi.js?105"></script>

    <?php echo Assets::css(); ?>

    <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico">
</head>
<body>
