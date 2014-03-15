<?php
    function make_seed() {
        list($usec, $sec) = explode(' ', microtime());
        return (float) $sec + ((float) $usec * 100000);
    }

    function randemail(){

        $end = array('ru','ua','com');
        $characters = array('gmail','mail','list','ukrpost');
        $characters2 = 'abcdefghijklmnopqrstuvwxyz0123456789';

        $result = rand(1,count($end)-1);
        $resul2 = rand(1,count($characters)-1);
        $resul3 = rand(1,strlen($characters2)-1);

        $mailString = '';
        $iterator = rand(3,14);

        for($i=0;$i<$iterator;$i++){

            mt_srand(make_seed());
            $resul3 = rand(1,strlen($characters2)-1);
            $mailString .= $characters2[$resul3];
        }
        $mailString.='@';
        $mailString.= $characters[$resul2]. '.'.$end[$result];
        return $mailString;
    }
?>
<?php
    /*
     * шифруем айдишник заведения
     */
    $shebangId = $shebang->id;
    $hashShebangId = encode_key($shebangId ,$this->config->config['encryption_key']);
?>
<div>

    <div class="head-in" style="height: 140px;  background-color:<?php printf( "#%06X\n", mt_rand( 0, 0xFFFFFF )); ?>;">

    </div>
    <div class="inner-in">
        <div class="inner-in-left" style="float: left;  margin-top: -29px;  height: 100%; width: 110px; margin-left: 20px;">
            <img style="width: 100px;  height: 100px;  border-radius: 130px; border: 1px solid black;" src="<?php echo $shebang->shebang_avatar ?>">
            <div class="buttons">
                <?php /*Template::block('buttons_owner'); */?>
                <?php /*Template::block_module('buttons_guest'); */?>
                <button style="margin-top: 10px;  width: 100%;">Заказать стол</button>
                <button class="subscribe" style="margin-top: 10px;  width: 100%;">Я посещаю</button>
            </div>
            <div>
                <div style="text-align: center;margin-top: 20px">Посетители</div>
            </div>
        </div>
        <div class="inner-in-right" style="float: right;width: 540px;margin-left: 20px;">

            <div style="font-size: 25px;">
                <?php echo $shebang->description ?>
                <hr style="margin-top: 10px;margin-bottom: 10px;">
            </div>

            <div class="photo-block">
                <?php for($i=0;$i<5;$i++): ?>
                    <div class="photo" style="float: left;margin-right: 10px">
                        <?php $tmp = randemail(); ?>
                        <img src="<?php echo "http://www.gravatar.com/avatar/" . md5( strtolower( trim($tmp ) ) ) . "?s=96&r=pg&d=identicon" ?>">
                    </div>
                <?php endfor;?>
            <div style="clear: both"></div>
            </div>
            <div>

                Меню
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>

<div id="base-popup" title="Информация">
</div>

<script>
    $('.subscribe').click(function(){
        $.ajax({
            type: 'POST',
            url: "/index.php/users/subscribe",
            data: {
                params:'<?php echo $hashShebangId ?>'
            }
        }).success(function(response){
            $( "#base-popup").html('<p>'+response+'</p>');

            $(function() {
                $( "#base-popup").dialog({ modal: true });
            });
        });
    });
</script>