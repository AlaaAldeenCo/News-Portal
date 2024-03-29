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
        $directories = explode(',', $request->directory);
        $langaugeCode = $request->language_code;
        $fileName = $request->file_name;
        $localizationStrings = [];
        foreach($directories as $directory)
        {
            $directory = trim($directory);
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
            foreach ($files as $file) {
                if ($file->isDir()) {
                    continue;
                }
                $contents = file_get_contents($file->getPathname());
                preg_match_all('/__\([\'"](.+?)[\'"]\)/', $contents, $matches);
                if (!empty($matches[1])) {
                    foreach ($matches[1] as $match) {
                        $match = preg_replace('/^(frontend|admin)\./', '',$match);
                        $localizationStrings[$match] = $match;
                    }
                }
            }
        }

        $phpArray = "<?php\n\nreturn " . var_export($localizationStrings, true) . ";\n";

        if (!File::isDirectory(lang_path($langaugeCode)))
        {
            File::makeDirectory(lang_path($langaugeCode), 0755, true);
        }

        file_put_contents(lang_path($langaugeCode . '/' . $fileName . '.php'), $phpArray);

        toast(__('admin.Generated Successfully'), 'success');
        return redirect()->back();
    }

    public function updateLangString(Request $request)
    {
        $languageStrings = trans($request->file_name, [], $request->lang_code);
        $languageStrings[$request->key] = $request->value;
        $phpArray = "<?php\n\nreturn " . var_export($languageStrings, true) . ";\n";
        file_put_contents(lang_path($request->lang_code . '/' . $request->file_name . '.php'), $phpArray);
        toast(__('admin.Updated Successfully!'), 'success');
        return redirect()->back();
    }

    public function translateString(Request $request)
    {
        try
        {
            $langCode = $request->language_code;
            $languageStrings = trans($request->file_name, [], $langCode);
            $keyStrings = array_keys($languageStrings);
            $text = implode(' | ', $keyStrings);
            $response = Http::withHeaders([
                'X-RapidAPI-Host' => getSetting('site_microsoft_api_host'),
                'X-RapidAPI-Key' => getSetting('site_microsoft_api_key'),
                'content-type' => 'application/json',
            ])->post(
                "https://microsoft-translator-text.p.rapidapi.com/translate?to%5B0%5D=$langCode&api-version=3.0&profanityAction=NoAction&textType=plain",
                    [
                        [
                            "Text" => $text
                        ]
                    ]
            );

            $translatedText = json_decode($response->body())[0]->translations[0]->text;
            $translatedValuse = explode(' | ', $translatedText);
            $updatedArray = array_combine($keyStrings, $translatedValuse );
            $phpArray = "<?php\n\nreturn " . var_export($updatedArray, true) . ";\n";
            file_put_contents(lang_path($langCode . '/' . $request->file_name . '.php'), $phpArray);
            return response(['status' => 'success', __('admin.Translation is completed')]);
        }

        catch (\Throwable $th)
        {
            return response(['status' => 'error', $th->getMessage()]);
        }

    }
}
