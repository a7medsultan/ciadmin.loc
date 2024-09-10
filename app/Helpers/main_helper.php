<?php

// app/Helpers/info_helper.php
use CodeIgniter\CodeIgniter;

/**
 * Returns CodeIgniter's version.
 */
function ci_version(): string
{
    return CodeIgniter::CI_VERSION;
}

function pr($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die();
}

