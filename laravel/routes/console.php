<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('educations', function () {
    $educations = App\Models\Residency\Education::all();
    foreach ($educations as $e) {
        $this->comment($e->residents->count() ?? '0');
    }
});

Artisan::command('bloodtype', function () {
    $r = App\Models\Residency\Resident::whereIn('id', [1, 2, 3])->count();
    $this->comment($r);
});
