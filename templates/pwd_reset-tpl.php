<?php declare(strict_types=1);

use SimpleSAML\Configuration;

$config = Configuration::getInstance();

if (!isset($_POST['passwordResetOk'])) {
    $_POST['passwordResetOk'] = false;
}

/*
 * Support the htmlinject hook, which allows modules to change header, pre and post body on all pages.
 */
$this->data['htmlinject'] = [
    'htmlContentPre' => [],
    'htmlContentPost' => [],
    'htmlContentHead' => [],
];

$jquery = [];
if (array_key_exists('jquery', $this->data)) {
    $jquery = $this->data['jquery'];
}

if (array_key_exists('pageid', $this->data)) {
    $hookinfo = [
        'pre' => &$this->data['htmlinject']['htmlContentPre'],
        'post' => &$this->data['htmlinject']['htmlContentPost'],
        'head' => &$this->data['htmlinject']['htmlContentHead'],
        'jquery' => &$jquery,
        'page' => $this->data['pageid'],
    ];

    SimpleSAML\Module::callHooks('htmlinject', $hookinfo);
}

header('X-Frame-Options: SAMEORIGIN');

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0" />
    <script type="text/javascript" src="/<?php echo $this->data['baseurlpath']; ?>resources/script.js"></script>
    <title>LS Hostel</title>

    <link rel="stylesheet" type="text/css" href="/<?php echo $this->data['baseurlpath']; ?>resources/default.css" />
    <link rel="icon" type="image/icon" href="/<?php echo $this->data['baseurlpath']; ?>resources/icons/favicon.ico" />

    <?php

    if (!empty($this->data['htmlinject']['htmlContentHead'])) {
        foreach ($this->data['htmlinject']['htmlContentHead'] as $c) {
            echo $c;
        }
    }

    if ($this->isLanguageRTL()) {
        ?>
        <link rel="stylesheet" type="text/css" href="/<?php echo $this->data['baseurlpath']; ?>resources/default-rtl.css" />
        <?php
    }
    ?>

    <link rel="stylesheet" type="text/css" href="<?php echo SimpleSAML\Module::getModuleUrl('lshostel/res/bootstrap/css/bootstrap.min.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo SimpleSAML\Module::getModuleUrl('lshostel/res/css/lshostel.css'); ?>" />

    <meta name="robots" content="noindex, nofollow" />


    <?php
    if (array_key_exists('head', $this->data)) {
        echo '<!-- head -->' . $this->data['head'] . '<!-- /head -->';
    }
    ?>
</head>
<?php
$onLoad = '';
if (array_key_exists('autofocus', $this->data)) {
    $onLoad .= 'SimpleSAML_focus(\'' . $this->data['autofocus'] . '\');';
}
if (isset($this->data['onLoad'])) {
    $onLoad .= $this->data['onLoad'];
}

if ('' !== $onLoad) {
    $onLoad = ' onload="' . $onLoad . '"';
}
?>
<body<?php echo $onLoad; ?>>


<div id="wrap">

    <div id="content">
        <div class="row pl-0 pr-0">
            <div class="col-sm-6 logo-wrap col-align--center">
                <img src="<?php echo SimpleSAML\Module::getModuleUrl('lshostel/res/img/lshostel_256.png'); ?>" alt="Life Science Hostel logo">
            </div>
            <div class="col-sm-6">
                <?php
echo '<h1> ' . $this->t('{lshostel:pwd_reset:header}') . '</h1>';
$userName = '';
if (isset($_POST['username'])) {
    $userName = $_POST['username'];
    try {
        if (!$_POST['passwordResetOk']) {
            sendPasswordResetEmail($userName);
            $_POST['passwordResetOk'] = true;
            unset($_POST['username']);
        } ?>
        <div class="alert alert-success" >
            <p>
                <span class="glyphicon glyphicon-exclamation-sign" style="float:left; font-size: 38px; margin-right: 10px;"></span>
                <strong><?php echo $this->t('{lshostel:pwd_reset:ok_header}'); ?></strong>
            </p>
            <p><?php echo $this->t('{lshostel:pwd_reset:ok_text}'); ?></p>
        </div>

        <?php
    } catch (\Exception $exception) {
        ?>
        <div class="alert alert-danger" >
            <span class="glyphicon glyphicon-exclamation-sign" style="float:left; font-size: 38px; margin-right: 10px;"></span>
            <strong><?php echo $this->t('{lshostel:pwd_reset:err_header}'); ?></strong>
            <p><?php echo $this->t('{lshostel:pwd_reset:err_text_part1}'); ?></p>
            <p><?php echo $this->t('{lshostel:pwd_reset:err_text_part2}'); ?>
                <a href="<?php echo $config->getString(
            'technicalcontact_email'
        ); ?>"><?php echo $this->t('{lshostel:pwd_reset:support}'); ?></a>.
            </p>
        </div>

        <?php
    }
}

if (!$_POST['passwordResetOk']) {
    ?>

    <p><?php echo $this->t('{lshostel:pwd_reset:text}'); ?></p>

    <br>

    <form action="" method="post" name="passwd_reset" class="form-horizontal">
        <div class="form-group">
            <label class="sr-only" for="inlineFormInputGroup"><?php echo $this->t('{{lshostel:pwd_reset:email}'); ?></label>
            <div class="input-group mb-2">
                <span class="input-group-addon" id="basic-addon1">@</span>
                <input id="username" type="email" name="username" class="form-control" value="<?php echo $userName; ?>" placeholder="Email" aria-describedby="basic-addon1"/>
            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-success btn-block" type="submit">
                <?php echo $this->t('{lshostel:pwd_reset:submit}'); ?>
            </button>
        </div>
    </form>

    <?php
}
 ?>
            </div>

            <?php

$this->includeAtTemplateBase('includes/footer.php');
