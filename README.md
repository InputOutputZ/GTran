# GoogleTran
Making Google Cloud translator API version 2 consumption easier in Laravel 5.7+.

### Through this integration you can do the following
- Detect text information such as language code and script. Refer to GoogleTran@detectTextInformation.
- Get translation of one or several text segments from one language to another. Refer to GoogleTran@translateText.
- Request available languages for translation including list of languages code. Refer to GoogleTran@translationsAvailable.

## Laravel Google Cloud Translator Integration

There are 3 files to have a look at so to understand how the integration works

- config/googletran.php (Configuration of API endpoints & authorization key)
- routes.php (Configuring PlayWithAPIController routes)
- GoogleTran\Translate\PlayWithAPIController (A Controller with on hand methods playing with the API endpoints)

### Required Packages

```php
"guzzlehttp/guzzle": "^6.3",
```

# Installation for Laravel 5.7+

- 1- Go to your laravel project root directory and get the package locally:-

```php
composer require "googletran/translate"
```

- 2- Install the service provider and load config as well as routes references:-

```php
php artisan vendor:publish
```
- 3- Choose "GoogleTran\Translate\GoogleTranServiceProvider" provider from the list via typing its index value.

- 4- Go to env file and include at the bottom:-

```php
GOOGLETRAN_KEY=Google Cloud API KEY
```

- 5- Well Done!

# Installation for older Laravel 
## Please expect more digging to get it work if you are planning to go down to 4.

- 1- Go to your laravel project root directory and get the package locally:-
```php
composer require "googletran/translate"
```

- 2- Add GoogleTran service provider manually into config/app.php:-
```php
'providers' => [
    // ...
    GoogleTran\Translate\\GoogleTranServiceProvider::class,
]
```

- 3- Load config as well as routes references:-
```php
php artisan vendor:publish --force --provider="GoogleTran\Translate\GoogleTranServiceProvider"
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

### Import Use at the top in any of your laravel project controllers
```php
use GoogleTran;
```

### Access functions through 

```php
GoogleTran::detectTextInformation($query);
```

## Available functions

- detectTextInformation($query,$concat = false,$concatType = false) (Returns detections object)
- translateText($query,$target,$source,$format,$model,$concat = false,$concatType = false) (Returns translations object)
- translationsAvailable($model,$locale) (Returns languages object)

## About

The GoogleTran package was published under MIT licence. If you have any problems, please feel free to reach out on hello@princez.uk.

Goodbye.
