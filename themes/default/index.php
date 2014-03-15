<?php echo theme_view('_header'); ?>
<div class="popup-music" style="position: fixed; bottom: 1px;">
    <audio controls autoplay>
      <!--  <source src="/assets/492fe88d6f04.mp3" type="audio/mpeg">-->
    </audio>
</div>
<div class="container"> <!-- Start of Main Container -->

    <?php echo theme_view('_sitenav'); ?>

    <?php
        echo Template::message();
        echo isset($content) ? $content : Template::content();
    ?>

<?php echo theme_view('_footer'); ?>