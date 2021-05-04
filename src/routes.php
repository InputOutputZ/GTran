<?php

Route::post('gdetecttext', '\GTran\Translate\PlayWithAPIController@detectText');
Route::post('gtranslatetext', '\GTran\Translate\PlayWithAPIController@translateText');
Route::post('gtranslationavailable', '\GTran\Translate\PlayWithAPIController@translationAvailable');
