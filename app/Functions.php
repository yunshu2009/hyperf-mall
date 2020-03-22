<?php

function get_milli_second()
{
    list($s1, $s2) = explode(' ', microtime());

    return intval((float)$s1 + (float)$s2) * 1000;
}
