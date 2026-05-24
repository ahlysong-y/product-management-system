<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\App\Models\User::whereNull('profile_code')->get()->each(function($u) {
    $u->profile_code = 'USR-' . strtoupper(\Illuminate\Support\Str::random(6));
    $u->save();
});
echo "Done.";
