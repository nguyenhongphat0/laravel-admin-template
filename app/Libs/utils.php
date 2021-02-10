<?php

function getFlagLanguage()
{
    $locale = app()->getLocale();

    switch ($locale) {
        case 'en':
            $name = 'us';
            break;

        default:
            $name = 'kr';
            break;
    }

    return $name;
}
