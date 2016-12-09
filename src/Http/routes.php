<?php

$router->get('/invites/{code}', 'InviteController@consume')->name('zinethq.sparkinvite.consume');
