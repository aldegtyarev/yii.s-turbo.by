<?php
/** @var $data ProductComments */
?>

<div id="questions-itm-<?= $data->id ?>" class="questions-itm">
    <div class="q">
        <div class="row">
            <div class="col-10">
                <img src="/img/user1m.png" alt="">
            </div>

            <div class="col-90">
                <b><?= $data->name?></b>
                <br>
                <?= nl2br($data->comment)?>
            </div>
        </div>
    </div>

    <?php if($data->answer != '') { ?>
        <div class="a">
            <div class="row">
                <div class="col-10">
                    <img src="/img/admin.png" alt="">
                </div>

                <div class="col-90">
                    <b>Администратор</b>
                    <br>
                    <?= $data->answer ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>


