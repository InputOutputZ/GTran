<?php

return [
	'key' => env('GOOGLETRAN_KEY', ''),
	'host' => env('GOOGLETRAN_HOST','https://translation.googleapis.com/language/translate/v2'),
	'detectpath' => env('GOOGLETRAN_TRAN', '/detect'),
	'languagepath' => env('GOOGLETRAN_LANG', '/languages')
];