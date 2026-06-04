<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$users = User::with('roles')->get();
foreach ($users as $user) {
    echo "ID=" . $user->id . " | NAME=" . $user->name . " | EMAIL=" . $user->email . " | roles=" . json_encode($user->getRoleNames()->toArray()) . " | has(gestionnaire)=" . ($user->hasRole('gestionnaire') ? 'yes' : 'no') . " | has(Gestionnaire)=" . ($user->hasRole('Gestionnaire') ? 'yes' : 'no') . "\n";
}
