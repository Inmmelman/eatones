<div style="font-weight: bold; ">

    ПОДПИСКИ <?php echo ( isset($current_user) && $current_user->subscribe !== false)? $current_user->subscribe['count'] : '' ?>
    <br>
    <?php if(isset($current_user) && $current_user->subscribe !== false): ?>
        <?php foreach($current_user->subscribe['shebangs'] as $userShebang ): ?>
            <div>
               <img style="width: 50px;height: 50px;" src="<?php echo $userShebang->shebang_avatar ?> ">
               <a href="/index.php/shebang/<?php echo $userShebang->id ?>">  <span style="font-size: 12px;" > <?php echo $userShebang->title ?> </span></a>
            </div>
        <?php endforeach;?>
    <?php endif;?>
</div>