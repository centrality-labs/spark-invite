<?php

Route::get('/invites/{token}', ['uses' => 'InviteController@consume', 'as' => 'consume']);
