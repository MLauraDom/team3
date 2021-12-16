<?php
function sanitize($dataEntries)
{
    $cleanData = array();
    foreach ($dataEntries as $val) {
        // trim: strips whitespace or other invalid characters from beginning and end of string
        $val = trim($val);
        // strip_tags strips HTML and PHP tags so no script can be uploaded through form
        $val = strip_tags($val);
        // htmlspecialchars converts special characters to html entities/elements
        $newVal = htmlspecialchars($val);
        array_push($cleanData, $newVal);
    }

    return $cleanData;
}