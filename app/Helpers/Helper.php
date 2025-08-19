<?php

if (!function_exists('toEnglish')) {
    function toEnglish(string $value): string
    {
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $english  = ['0','1','2','3','4','5','6','7','8','9'];

        $value = str_replace(['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'], $english, $value);
        return str_replace($persian, $english, $value);
    }
}
