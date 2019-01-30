<?php

Route::post('gdetecttext', '\GoogleTran\Translate\PlayWithAPIController@detectText');
Route::post('gtranslatetext', '\GoogleTran\Translate\PlayWithAPIController@translateText');
Route::get('gtranslationavailable', '\GoogleTran\Translate\PlayWithAPIController@translationAvailable');
