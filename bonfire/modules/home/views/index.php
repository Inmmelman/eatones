<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
<h2> Новые заведения</h2>
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

            <div class="yashare-auto-init"
                data-yashareL10n="ru"
                data-yashareType="none"
                data-yashareDescription="<?php echo $shebang->description  ?> "
                data-yashareElement="<?php echo $key ?> "
                data-yashareTitle="Мне нравиться  <?php echo $shebang->title ?>"
                data-yashareImage="<?php echo $shebang->shebang_avatar ?>"
                data-yashareQuickServices="vkontakte"
                data-yashareTheme="">
            </div>
        </div>
    </div>
<?php endforeach; ?>
<div class="clear"></div>
<br>
<hr>
<br>
<h2>События</h2>
<div class="last-events">
<?php $i=0; foreach($lastEvents as $event): ?>
    <div class="event" style="margin-top: 10px;">
        <div style="float: left; width: 150px;" ><img  src="<?php echo $event->poster ?>"></div>
        <div style="float: left; margin-left: 30px">
            <div>
                <b><?php echo $event->event_title ?></b>

            </div>
            <div>
                <?php echo $event->event_description ?>
            </div>
            <div class="social">
               <b> Рассказать друзьям:</b>

                <div class="yashare-auto-init"
                     data-yashareL10n="ru"
                     data-yashareType="none"
                     data-yashareDescription="<?php echo $event->event_description  ?> "
                     data-yashareElement="<?php echo $i++ ?> "
                     data-yashareTitle="Я пойду на `<?php echo $event->event_title ?>`"
                     data-yashareImage="<?php echo $event->poster ?>"
                     data-yashareQuickServices="vkontakte"
                     data-yashareTheme="">
                </div>
            </div>
        </div>
    <div style="clear: both"></div>
    </div>
<?php endforeach; ?>
<div class="clear"></div>
</div>


<?php echo Template::message(); ?>


