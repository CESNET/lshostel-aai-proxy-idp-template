<?php

declare(strict_types=1);

use SimpleSAML\Configuration;
use SimpleSAML\Error\Exception;
use SimpleSAML\Logger;
use SimpleSAML\XHTML\Template;

const LSHOSTEL_ENTITY_ID = 'https://login.bbmri-eric.eu/lshostel/';
const LSHOSTEL_SCOPE = '@lifescience-hostel.org';
const VO_SHORT_NAME = 'lifescience_hostel';
const PERUN_NAMESPACE = 'lifescience-hostel';
const PERUN_URL = 'https://perun.bbmri-eric.eu/';
const EMAIL_ATTR_URN = 'urn:perun:user:attribute-def:def:preferredMail';
const LANG_EN = 'en';

$config = Configuration::getInstance();

$t = new Template($config, 'lshostel:pwd_reset-tpl.php');
$t->show();

function sendPasswordResetEmail($userName)
{
    $rpcAdapter = new sspmod_perun_AdapterRpc();

    $userName = trim($userName);
    $userNameParts = explode('@', $userName, 2);
    $userName = $userNameParts[0] . '_' . strtolower($userNameParts[1]);

    $uid = [$userName . LSHOSTEL_SCOPE];
    $user = null;
    try {
        $user = $rpcAdapter->getPerunUser(LSHOSTEL_ENTITY_ID, $uid);
    } catch (Exception $ex) {
        throw new Exception('There are no LifeScience Hostel user with username: ' . $userName, $ex);
    }
    if (null === $user) {
        throw new Exception('There are no LifeScience Hostel user with username: ' . $userName);
    }

    $vo = $rpcAdapter->getVoByShortName(VO_SHORT_NAME);
    $member = $rpcAdapter->getMemberByUser($user, $vo);

    $connector = $rpcAdapter->getConnector();

    $response = $connector->post(
        'membersManager',
        'sendPasswordResetLinkEmail',
        [
            'member' => $member->getId(),
            'namespace' => PERUN_NAMESPACE,
            'url' => PERUN_URL,
            'emailAttributeURN' => EMAIL_ATTR_URN,
            'language' => LANG_EN,
        ]
    );

    Logger::debug(print_r($response, true));
}
