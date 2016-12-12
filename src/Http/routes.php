<?php

$router->get('/invites/{token}', 'InviteController@consume')->name('zinethq.sparkinvite.consume');
