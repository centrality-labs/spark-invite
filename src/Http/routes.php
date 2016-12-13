<?php

Route::get(config('sparkinvite.routes.accept'), ['uses' => 'InviteController@accept', 'as' => 'accept']);
Route::get(config('sparkinvite.routes.reject'), ['uses' => 'InviteController@reject', 'as' => 'reject']);
