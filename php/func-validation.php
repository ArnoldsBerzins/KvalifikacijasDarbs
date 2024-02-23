<?php

function is_empty($var, $text, $location, $ms, $data) {
    if (empty($var)) {
        $em = "Lauks " . $text . " ir nepieciešams aizpildīt";
        header("Location: $location?$ms=$em&$data");
        exit;
    }
    return 0;
}