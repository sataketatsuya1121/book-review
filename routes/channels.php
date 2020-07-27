<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('rankUpChannel', function () {
    return true;
});

Broadcast::channel('registerChannel', function () {
    return true;
});

Broadcast::channel('reviewChannel', function () {
    return true;
});

