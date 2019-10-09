<?php

namespace App\Helpers;

use Novay\WordTemplate\Facade as WordTemplate;

class TemplateReplacer {
    public static function replace($file, $replaceArray, $filename) {
        $file = asset("format_surat/$file");
        $replace = [
            '[' => '',
            ']' => '',
        ];

        foreach($replaceArray as $key => $value) {
            $replace[$key] = $value;
        }

        return WordTemplate::export($file, $replace, $filename);
    }
}