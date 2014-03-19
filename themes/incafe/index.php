<?php echo theme_view('_header'); ?>
<div class="popup-music" style="position: fixed; bottom: 1px;">
    <audio controls autoplay>
        <!--<source src="/assets/492fe88d6f04.mp3" type="audio/mpeg">-->
    </audio>
</div>


<div class="container">
    <?php echo theme_view('_sitenav'); ?>
    <div class="index-blocks left-block">
        <?php echo Template::renderBlock('/base/mainMenu')?>
        <hr>
        <?php echo Template::renderBlock('/base/subscribers') ?>
        <hr><br>
        <?php echo Template::renderBlock('/base/mainUserNews') ?>
    </div>

    <div class="index-blocks center-block" text-align="center">

        <?php echo Template::renderBlock('/base/commercial') ?>
        <?php
            echo Template::message();
            echo isset($content) ? $content : Template::content();
        ?>

    </div>

    <div class="index-blight-block">
        right block
    </div>

<?php echo theme_view('_footer'); ?>