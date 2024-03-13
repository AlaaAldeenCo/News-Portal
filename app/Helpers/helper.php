<?php

use PhpParser\Node\Expr\Cast\String_;

/* Format News Tags */

use App\Models\Language;
use App\Models\Setting;

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
            setLanguage($language->lang);
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

/* Set Sidebar Items Active */
function setSidebarActive(array $routes): ?string
{
    foreach($routes as $route)
    {
        if(request()->routeIs($route))
        {
            return 'active';
        }
    }
    return '';
}

/* Check Permission */
function canAccess(array $permissions)
{
    // return auth()->guard('admin')->user()->hasPermissionTo($permissions, 'admin');
    $permission = auth()->guard('admin')->user()->hasAnyPermission($permissions);
    $superAdmin = auth()->guard('admin')->user()->hasRole('Super Admin');
    if($permission || $superAdmin)
    {
        return true;
    }

    else
    {
        return false;
    }
}

/* Check If Is It Super Admin */
// function isSuperAdmin()
// {
//     return auth()->guard('admin')->user()->hasRole('Super Admin');
// }

/* Get Admin Role Name */
function getRole()
{
    $role = auth()->guard('admin')->user()->getRoleNames();
    return $role->first();
}

/* Check Permission */
function checkPermission(string $permission)
{
    return $permission = auth()->guard('admin')->user()->hasPermissionTo($permission);
}


function getSetting($key){
    $data = Setting::where('key', $key)->first();
    return $data->value;
}
