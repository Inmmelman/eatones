<?php foreach($newShebangs as $key => $shebang): ?>
    <div class="last-shebang">
        <div style="float: left">
        <img src="<?php echo $shebang->shebang_avatar ?>" width="200" height="113" style="height: 113px">
        </div>
        <div style="float: left; width: 470px; margin-left: 10px;">
        <h3><a href="/index.php/shebang/<?php echo $shebang->id ?>" ><?php echo $shebang->title ?></a></h3>
        <div><?php echo $shebang->description ?> </div>
        </div>
        <div class="clear"></div>
        <div class="social">

            <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
            <div class="yashare-auto-init" data-yashareL10n="ru"
            data-yashareDescription="<?php echo $shebang->description  ?> "
            data-yashareElement="<?php echo $key ?> "
            data-yashareTitle="Мне нравиться  <?php echo $shebang->title ?>"
            data-yashareImage="<?php echo $shebang->shebang_avatar ?>"
            data-yashareQuickServices="vkontakte" data-yashareTheme="counter">
            </div>
        </div>
    </div>
<?php endforeach; ?>


<div class="clear"></div>
<?php echo Template::message(); ?>


