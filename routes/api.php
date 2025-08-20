<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

const KEY_HASH="ad490e47a66386a3082ec1f8fa126da3e6f13db22f0c95dde423f3a1f884b9ad";
const ADMIN_PASS_HASH="$2y$12$2j.KBAwPP2GKHNm9wG4WNOUVkA6P2UfWRux8asgO9Kt.s8CSDCQmu";

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/db-init', function (Request $request) {
    $key = $request->get("key", "test");
    if(hash('sha256', $key) == KEY_HASH) {
        $user = new User();
        $user->name = "Admin";
        $user->email = "admin";
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
                $user->email = "admin";

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
