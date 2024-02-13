<?php

/* Format News Tags */

use App\Models\Language;

function formatTags(array $tags)
{
    return implode(',', $tags);
}

/* Get Selected Language From Session */
function getLanguage()
{
    if(session()->has('language'))
    {
        return session('language');
    }

    else
    {
        try
        {
            $language = Language::where('default',1)->first();
            setLanguage($language);
            return $language->lang;
        }
        catch (\Throwable $th)
        {
            setLanguage('en');
            return $language->lang;
        }
    }
}

/* Set Language Code In Session */
function setLanguage(string $code)
{
    session(['language' => $code]);
}

/* Truncate The Text */
function truncate(string $text, int $limit = 45)
{
    return \Str::limit($text, $limit, '....');
}

/* Add K Format For View Number */
function convertToKFormat(int $number)
{
    if($number < 1000)
    {
        return $number;
    }
    elseif($number < 1000000)
    {
        return round($number/1000, 1).'K';
    }
    else
    {
        return round($number/1000000, 1).'M';
    }
}
