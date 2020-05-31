<?php

if (!defined('DW_KIDO_PATH')) {
    define('DW_KIDO_PATH', trailingslashit(get_template_directory()));
}

if (!defined('DW_KIDO_URI')) {
    define('DW_KIDO_URI', trailingslashit(get_template_directory_uri()));
}


// Core Functionality
// --------------------------------------------
require_once DW_KIDO_PATH . '/core/customizer.php';
require_once DW_KIDO_PATH . '/core/init.php';
require_once DW_KIDO_PATH . '/core/sidebars.php';
require_once DW_KIDO_PATH . '/core/scripts.php';
require_once DW_KIDO_PATH . '/core/template-tags.php';
require_once DW_KIDO_PATH . '/core/extras.php';
require_once DW_KIDO_PATH . '/core/activation.php';


// Extra Features
// --------------------------------------------
require_once DW_KIDO_PATH . '/extra/forms.php';
require_once DW_KIDO_PATH . '/extra/twitter.php';
