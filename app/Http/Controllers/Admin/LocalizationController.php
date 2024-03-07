<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class LocalizationController extends Controller
{
    public function adminIndex()
    {
        $languages = Language::all();
        return view('admin.localization.admin-index', compact('languages'));
    }

    public function frontendIndex()
    {
        $languages = Language::all();
        return view('admin.localization.frontend-index', compact('languages'));
    }

    public function extractLocalizationStrings(Request $request)
    {
        $directory = $request->directory;
        $langaugeCode = $request->languageCode;

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        $localizationStrings = [];
        foreach($files as $file)
        {
            if($file->isDir())
            {
                continue;
            }
            $contents = file_get_contents($file->getPathname());
            preg_match_all('/__\([\'"](.+?)[\'"]\)/', $contents, $matches);
            dd($matches);
        }

    }
}
