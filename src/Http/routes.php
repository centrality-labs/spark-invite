<?php

Route::get('/invites/{token}', 'InviteController@consume')->name('zinethq.sparkinvite.consume');
