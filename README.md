# GTran
Making Google Cloud translation API version 2 consumption easier in Laravel 5+.

### Through this integration you can do the following
- Detect information about text such as language code and script. Refer to GTran@detectTextInformation.
- Translates text from one language to another. Accepts String or concatenated Strings as translation query. Refer to GTran@translateText.
- Translates text from one language to another. Accepts Array as translation query. Refer to GTran@translateTextWithoutConcat.
- Request available languages for translation including list of languages code. Refer to GTran@translationsAvailable.

## Laravel Google Cloud Translator Integration

There are 3 files to have a look at so to understand how the integration works

- config/gtran.php (Configuration of API endpoints & authorisation key)
- routes.php (Configuring PlayWithAPIController routes)
- GTran\Translate\PlayWithAPIController (A Controller with on hand methods playing with the API endpoints)

### Required Packages

```php
"guzzlehttp/guzzle": "^7.0.1",
```

# Installation for Laravel 5+. Tested on 8.40.

- 1- Go to your laravel project root directory and install the package locally:-

```php
composer require "gtran/translate"
```

- 2- Install the service provider and load config as well as routes references:-

```php
php artisan vendor:publish
```
- 3- Choose "GTran\Translate\GTranServiceProvider" provider from the list via typing its index value.

- 4- Go to env file and include at the bottom:-

```php
GOOGLETRAN_KEY=Google Cloud API KEY
```

- 5- Well Done!

# Installation for older Laravel 
### You may expect more debugging to get it working.

- 1- Go to your laravel project root directory and install the package locally:-
```php
composer require "gtran/translate"
```

- 2- Add GTran service provider manually to the providers list in config/app.php:-
```php
'providers' => [
    // ...
    GTran\Translate\\GTranServiceProvider::class,
]
```

- 3- Load config as well as routes references:-
```php
php artisan vendor:publish --force --provider="GTran\Translate\GTranServiceProvider"
```

- 4- Go to env file and include at the bottom:-

```php
GOOGLETRAN_KEY=Google Cloud API KEY
```

- 5- Well Done!

# Demo with PlayWithAPIController and Postman

## Configuration

- Codebase Configuration

-1 Go To PlayWithAPIController

-2 Go to definition of detectTextInformation and translateText.

-3 Examine the functions

- detectTextInformation | Postman Configuration to route "http://yourwebsite.com/gdetecttext" and POST type.

-1 Include following headers:-

```php
Accept: application/json
```

2- Include following Body: form-data

```php
KEY     TEXT
query    Hello
```

3- Response

```php
{
  "data": {
    "detections": [
      [
        {
          "confidence": 1,
          "isReliable": false,
          "language": "en"
        }
      ]
    ]
  }
}
```

- translationsAvailable | Postman Configuration to route "http://yourwebsite.com/gtranslationavailable" and POST type.

-1 Include following headers:-

```php
Accept: application/json
```

2- Include following Body: form-data

```php
KEY     TEXT
model    base, P.S. you can go for nmt, Neural Machine Translation.
locale   en
```

3- Response

```php
{
  "data": {
    "languages": [
      {
        "language": "af",
        "name": "Afrikaans"
      },
      {
        "language": "sq",
        "name": "Albanian"
      },
      {
        "language": "am",
        "name": "Amharic"
      },
      {.................................
```

# Usage

### Import Use at the top in any of your laravel project controllers / traits.
```php
use GTran;
```

### Access functions through 

```php
GTran::detectTextInformation($query);
```

## Available functions

- detectTextInformation($query,$concat = false,$concatType = false)
- translateTextWithoutConcat($queries, $target, $source, $format, $model)
- translateText($query,$target,$source,$format,$model,$concat = false,$concatType = false)
- translationsAvailable($model,$locale)

## About

The GTran package was published under The Unlicense licence. If you have any problems, please feel free to reach out at hi@zakaria.website.
