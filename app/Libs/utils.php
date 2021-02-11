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

function writeLogging($exception, $type = 'error')
{
    $message = '';

    if ($exception->getCode()) {
        $message .= $exception->getCode() . ' ';
    }

    if ($exception->getFile()) {
        $message .= 'File: ' . $exception->getFile() . ' ';
    }

    if ($exception->getLine()) {
        $message .= 'at line:' . $exception->getLine() . ': ';
    }

    if ($exception->getMessage()) {
        $message .= $exception->getMessage();
    }

    logger()->$type($message);

    return $message;
}

function convertDate($datetime)
{
    if ($datetime) {
        return date('Y.m.d', strtotime($datetime));
    } else {
        return '';
    }
}

function convertMoney($money)
{
    return number_format($money, 0);
}