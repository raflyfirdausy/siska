<?php
use App\Models\General\Option;

if (! function_exists('option')) {
    function option() {
        return Option::with('provinsi', 'kabupaten', 'kecamatan', 'desa')->first();
    }
}