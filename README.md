# Laravel Nano ID

<p align="center"><img src="/art/laravel-nano-id-logo.png" alt="Laravel Nano ID Logo" width="800"></p>

## Introduction
A simple package to generate Nano IDs in Laravel.

# What is a Nano ID?
A Nano ID is a URL-friendly, unique string ID.   
It is similar to UUIDs, but shorter and more readable.  
Nano IDs are 21 characters long by default and can be customized to be longer or shorter.
- Read more on Medium: [Nano ID: A Tiny, Secure URL-friendly Unique String ID Generator](https://medium.com/@gaspm/nano-id-popular-secure-and-url-friendly-unique-identifiers-1fa86c9fdf7c)
- Or on GitHub: [Nano ID](https://github.com/ai/nanoid)

# Table of Contents
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)
- [Testing](#testing)
- [Alternatives (and inspirations)](#alternatives-and-inspirations)

## Features
- A facade to generate Nano IDs
- A helper function to use as alternative to the facade
- Configuration options to customize the defaults for your Nano IDs
  - Prefix
  - Suffix
  - Alphabet
  - Size
  - Random function
  - More to come
- Easily extensible with custom validation rules (like uniqueness or swear word checks)

## Requirements
- PHP >= 8.0

## Installation

```bash
composer require fanmade/laravel-nanoid
```

## Usage

```php
use Fanmade\NanoId\Facades\NanoID;

echo NanoID::generate(); // Returns a Nano ID

echo NanoID::generate(length: 10); // Returns a Nano ID with a length of 10

echo NanoID::generate(length: 10, prefix: 'prefix_'); // Returns a Nano ID with a length of 10 and a prefix of 'prefix_'

echo NanoID::generate(suffix: '_suffix'); // Returns a Nano ID with a suffix of '_suffix'

echo NanoID::generate(alphabet: '0123456789'); // Returns a Nano ID only containing numbers

echo nano_id(); // The helper function accepts the same parameters as the generate method
```

## Configuration

Publish the configuration file

```bash
php artisan vendor:publish --tag=nanoid-config
```

| Option                     | Description                                                           | Default                                                                    |
|----------------------------|-----------------------------------------------------------------------|----------------------------------------------------------------------------|
| `prefix`                   | An optional prefix which will be added to the Nano ID                 | `''`                                                                       |
| `suffix`                   | An optional suffix which will be added to the Nano ID                 | `''`                                                                       |
| `alphabet`                 | The alphabet to use for generating the Nano ID                        | `0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_`+<br/>`abcdefghijklmnopqrstuvwxyz-` |
| `size`                     | The default size/length of the Nano ID                                | `21`                                                                       |
| `generator`                | The generator class to use for generating random bytes                | `\Hidehalo\Nanoid\Generator::class`                                        |
| `include_prefix_in_length` | Controls if the prefix is included or excluded in the size limitation | true                                                                       |
| `include_suffix_in_length` | Controls if the suffix is included or excluded in the size limitation | true                                                                       |

## Testing

```bash
vendor/bin/pest
```
or 
```bash
composer test
```

## Alternatives (and inspirations)

- [hidehalo/nanoid-php](https://github.com/hidehalo/nanoid-php) - The original Nano ID package for PHP. This is also used in the background of this package.
- [yondifon/laravel-nanoid](https://github.com/yondifon/laravel-nanoid) - More focused on adding the Nano IDs to the models.
- [ttbooking/laravel-nanoid](https://github.com/ttbooking/laravel-nanoid) - This one has more focus on extending the string helpers.

