<?php

Route::post('gdetecttext', '\GoogleTran\Translate\PlayWithAPIController@detectText');
Route::post('gtranslatetext', '\GoogleTran\Translate\PlayWithAPIController@translateText');
Route::post('gtranslationavailable', '\GoogleTran\Translate\PlayWithAPIController@translationAvailable');
