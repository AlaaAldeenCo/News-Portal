<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
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
        foreach ($files as $file) {
            if ($file->isDir()) {
                continue;
            }
            $contents = file_get_contents($file->getPathname());
            preg_match_all('/__\([\'"](.+?)[\'"]\)/', $contents, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $match) {
                    $localizationStrings[$match] = $match;
                }
            }
        }
        $phpArray = "<?php\n\nreturn " . var_export($localizationStrings, true) . ";\n";

        if (!File::isDirectory(lang_path($langaugeCode))) {
            File::makeDirectory(lang_path($langaugeCode), 0755, true);
        }
        // dd(lang_path($langaugeCode.'/'.$fileName.'.php'));
        file_put_contents(lang_path($langaugeCode . '/' . $fileName . '.php'), $phpArray);
    }

    public function updateLangString(Request $request)
    {
        $languageStrings = trans($request->file_name, [], $request->lang_code);
        $languageStrings[$request->key] = $request->value;
        $phpArray = "<?php\n\nreturn " . var_export($languageStrings, true) . ";\n";
        file_put_contents(lang_path($request->lang_code . '/' . $request->file_name . '.php'), $phpArray);
        toast(__('Updated Successfully!'), 'success');
        return redirect()->back();
    }

    public function translateString(Request $request)
    {
        $langCode = $request->language_code;
        $languageStrings = trans($request->file_name, [], $langCode);
        $keyStrings = array_keys($languageStrings);
        $text = implode('|', $keyStrings);
        dd($text);
        $response = Http::withHeaders([
            'X-RapidAPI-Host' => 'microsoft-translator-text.p.rapidapi.com',
            'X-RapidAPI-Key' => '1b5d1d17aamsha9cae4a30ef4f68p1b7e92jsn80425bbdbb47',
            'content-type' => 'application/json',
        ])->post(
            'https://microsoft-translator-text.p.rapidapi.com/translate?to%5B0%5D=ar&api-version=3.0&profanityAction=NoAction&textType=plain',
                [
                    [
                        "Text" => "I would really like to drive your car around the block a few times."
                    ]
                ]
        );
        return $response->body();
    }
}
