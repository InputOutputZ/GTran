<?php

return [
	'key' => env('GOOGLETRAN_KEY', ''),
	'host' => env('GOOGLETRAN_HOST','https://translation.googleapis.com'),
	'transpath' => env('GOOGLETRAN_TRAN', '/language/translate/v2'),
	'detectpath' => env('GOOGLETRAN_TRAN', '/language/translate/v2/detect'),
	'languagepath' => env('GOOGLETRAN_LANG', '/language/translate/v2/languages')
];