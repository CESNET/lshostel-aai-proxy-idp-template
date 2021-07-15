<?php

/**
 * This is example configuration fot LSHostel module.
 * Copy this file to default config directory and edit the properties.
 *
 * copy command (from SimpleSAML base dir)
 * cp modules/lshostel/module_lshostel.php config/
 */
$config = [
    'register_link' => '',

    'pwd_reset' => [
        'lshostel_entity_id' => '',
        'lshostel_scope' => '',
        'vo_short_name' => '',
        'perun_namespace' => '',
        'perun_url' => '',
        'perun_email_attr' => ''
    ]
];
