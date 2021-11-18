<?php

declare (strict_types = 1);

error_reporting(E_ALL);
ini_set('display_errors', "1");

function dump($data)
{
    echo '<div
        style="
        background: #CCCC;
        display: inline-block;
        padding: 10px;"
    >
    <pre>';
    print_r($data);
    echo '</div>
    </pre>
    </br>';
}