<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

const KEY_HASH="20cbdcfcc66c2b3fd94557f785f6448001f057db96a14b111c5757cc4b211b32";
const ADMIN_PASS_HASH='$2y$12$NbOhlvu6nRWsl.jUdj/iX.tE9fKMRAtnIOdzRpuUdN7JRoRWR7Lve';

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/db-init', function (Request $request) {
    $key = $request->get("key", "test");
    if(hash('sha256', $key) == KEY_HASH) {
        $user = new User();
        $user->name = "Admin";
        $user->email = "admin@ddmluby.cz";
        // Disable the hashed cast temporarily
        $user->mergeCasts([
            'password' => 'string', // Treat it as a plain string
        ]);

        $user->password = ADMIN_PASS_HASH;
        $user->current_team_id = 1;
        $user->save();
    }
});

Route::get('/run-migrations', function (Request $request) {

    $key = $request->get("key", "test");
    if(hash('sha256', $key) == KEY_HASH) {
        $seed = $request->get("seed", "false");
        $fresh = $request->get("fresh", "false");
        $pretend = $request->get("pretend", "false");
        $admin = $request->get("admin", "false");

        try {
            $params = ["--database" => "main_admin"];
            if($seed == "true") {
                $params["--seed"] = "true";
            }
            if($pretend == "true") {
                $params["--pretend"] = "true";
            }
            Artisan::call(($fresh == "true") ? 'migrate:fresh' : 'migrate', $params);

            if($admin == "true") {
                $user = new User();
                $user->name = "Admin";
                $user->email = "admin@ddmluby.cz";

                // Disable the hashed cast temporarily
                $user->mergeCasts([
                    'password' => 'string', // Treat it as a plain string
                ]);

                $user->password = ADMIN_PASS_HASH;
                $user->current_team_id = 1;
                $user->save();
            }

            return Artisan::output();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    } else {
        abort(404);
    }

});
