<?php
function mb_ucfirst($value)
{
    $firstLetter = mb_strtoupper(mb_substr($value, 0, 1, 'UTF-8'), 'UTF-8');
    $otherLetters = mb_substr($value, 1, null, 'UTF-8');

    return $firstLetter . $otherLetters;
}