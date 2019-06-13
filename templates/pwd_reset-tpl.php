<?php
/**
 * @author Pavel Vyskocil <vyskocilpavel@muni.cz>
 */


namespace SimpleSAML\Module\lshostel;

$this->data['header'] = $this->t('{lshostel:pwd_reset:header}');

$this->includeAtTemplateBase('includes/header.php');

if (isset($_POST['username'])) {
    $userName = $_POST['username'];
    try {
        sendPasswordResetEmail($userName);
        ?>
        <div class="alert alert-success" >
            <span class="glyphicon glyphicon-exclamation-sign" style="float:left; font-size: 38px; margin-right: 10px;"></span>

            <strong><?php echo $this->t('{lshostel:pwd_reset:ok_header}');?></strong>

            <p><?php echo $this->t('{lshostel:pwd_reset:ok_text}');?></p>
        </div>

        <?php
    } catch (\Exception $exception) {
        ?>
        <div class="alert alert-danger" >
            <span class="glyphicon glyphicon-exclamation-sign" style="float:left; font-size: 38px; margin-right: 10px;"></span>

            <strong><?php echo $this->t('{lshostel:pwd_reset:err_header}');?></strong>

            <p><?php echo $this->t('{lshostel:pwd_reset:err_text_part1}');?></p>
            <p><?php echo $this->t('{lshostel:pwd_reset:err_text_part2}');?>
                <a href="mailto:idm@ics.muni.cz"><?php echo $this->t('{lshostel:pwd_reset:support}');?>
                </a>.
            </p>
        </div>


        <?php
    }
}

?>

    <p><?php echo $this->t('{lshostel:pwd_reset:text}'); ?></p>

    <br>

    <form action="?" method="post" name="passwd_reset" class="form-horizontal">

        <div class="form-group">
            <label for="username" class="col-sm-2 control-label"><?php echo $this->t('{lshostel:pwd_reset:email}'); ?></label>
            <div class="col-sm-10">
                <input id="username" type="text" name="username" class="form-control"/>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-8 col-sm-4">
                <button class="btn btn-success btn-block"
                        onclick="this.value='<?php echo $this->t('{login:processing}'); ?>';
                            this.disabled=true; this.form.submit(); return true;" tabindex="6">
                    <?php echo $this->t('{lshostel:pwd_reset:submit}'); ?>
                </button>
            </div>

        </div>

    </form>


<?php

$this->includeAtTemplateBase('includes/footer.php');

