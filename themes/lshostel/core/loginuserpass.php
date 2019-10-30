<?php
$this->data['header'] = $this->t('{lshostel:lshostel:user_pass_header}');


if (strlen($this->data['username']) > 0) {
	$this->data['autofocus'] = 'password';
} else {
	$this->data['autofocus'] = 'username';
}
$this->includeAtTemplateBase('includes/header.php');

?>

<?php
if ($this->data['errorcode'] !== null) {

    ?>
    <div class="alert alert-danger" >
        <p>
            <span class="glyphicon glyphicon-exclamation-sign" style="float:left; font-size: 38px; margin-right: 10px;"></span>

            <strong>
                <?php
                echo htmlspecialchars($this->t(
                    '{errors:title_' . $this->data['errorcode'] . '}',
                    $this->data['errorparams']
                ));
                ?>
            </strong>
        </p>
        <p>
            <?php
            echo htmlspecialchars($this->t(
                '{errors:descr_' . $this->data['errorcode'] . '}',
                $this->data['errorparams']
            ));
            ?>
        </p>
    </div>
    <?php

}

?>

	<p><?php echo $this->t('{lshostel:lshostel:user_pass_text}'); ?></p>
	<br>
	<form action="?" method="post" name="f" class="form-horizontal">
		<div class="form-group">
			<label for="username" class="col-sm-2 control-label"><?php echo $this->t('{lshostel:lshostel:email}'); ?></label>
			<div class="col-sm-10">
                <input id="username" type="email" name="username" class="form-control"
                       value="<?php echo htmlspecialchars($this->data['username']); ?>"/>
			</div>
		</div>
		<div class="form-group">
			<label for="password" class="col-sm-2 control-label"><?php echo $this->t('{login:password}'); ?></label>
			<div class="col-sm-10">
				<input id="password" type="password" name="password" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-8 col-sm-4">
                <button class="btn btn-success btn-block" type="submit">
                    <?php echo $this->t('{login:login_button}'); ?>
                </button>
            </div>

		</div>
        <div id="login_form_links" class="row">
            <div class="col-sm-6">
                <a href="<?php echo SimpleSAML\Module::getModuleURL("lshostel/pwd_reset.php");?>" class="btn btn-link btn-block">
                    <?php echo $this->t('{lshostel:lshostel:forgot_password}') ?>
                </a>
            </div>
            <div class="col-sm-6">
                <a href="https://perun.bbmri-eric.eu/non/registrar/?vo=lifescience_hostel" class="btn btn-link btn-block">
                    <?php echo $this->t('{lshostel:lshostel:register_acc_hostel}') ?>
                </a>
            </div>
        </div>
        <?php
        foreach ($this->data['stateparams'] as $name => $value) {
            echo('<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '" />');
        }
        ?>
	</form>

<?php

$this->includeAtTemplateBase('includes/footer.php');
