<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
        $langaugeCode = $request->language_code;
        $fileName = $request->file_name;

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
            if(!empty($matches[1]))
            {
                foreach($matches[1] as $match)
                {
                    $localizationStrings[$match] = $match;
                }
            }

        }
        $phpArray = "<?php\n\nreturn " . var_export($localizationStrings, true) . ";\n";

        if(!File::isDirectory(lang_path($langaugeCode)))
        {
            File::makeDirectory(lang_path($langaugeCode), 0755, true);
        }
        // dd(lang_path($langaugeCode.'/'.$fileName.'.php'));
        file_put_contents(lang_path($langaugeCode.'/'.$fileName.'.php'), $phpArray);
    }

    public function updateLangString(Request $request)
    {
        $languageStrings = trans($request->file_name, [], $request->lang_code);
        $languageStrings [$request->key] = $request->value;
        $phpArray = "<?php\n\nreturn " . var_export($languageStrings, true) . ";\n";
        file_put_contents(lang_path($request->lang_code.'/'.$request->file_name.'.php'), $phpArray);
        toast(__('Updated Successfully!'), 'success');
        return redirect()->back();
    }

    public function translateString(Request $request)
    {
        dd($request->all());
    }
}
