# Laravel NanoID (WIP)

## Introduction

A simple package to generate Nano IDs in Laravel.

## Alternatives

- [yondifon/laravel-nanoid](https://github.com/yondifon/laravel-nanoid) <- more focused on adding the Nano IDs to the
  models
- [hidehalo/nanoid-php](https://github.com/hidehalo/nanoid-php) <- a framework agnostic php package to generate Nano IDs

## Installation

```bash
composer require fanmade/laravel-nanoid
```

## Configuration

Publish the configuration file

```bash
php artisan vendor:publish --tag=nanoid-config
```

| Option           | Description                                                                                                                                                                                                                                  | Default                                                            |
|------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|--------------------------------------------------------------------|
| `prefix`         | An optional prefix which will be added to the Nano ID. It will be counted to the end size of the Nano ID. So if you use for example "xyz_" as the prefix and a length of 6 for ne nanoid, it will only contain tow random characters per ID, | `''`                                                               |
| `suffix`         | An optional suffix which will be added to the Nano ID                                                                                                                                                                                        | `''`                                                               |
| `alphabet`       | The alphabet to use for generating the Nano ID                                                                                                                                                                                               | `0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz-` |
| `size`           | The size/length of the Nano ID                                                                                                                                                                                                               | `21`                                                               |
| `randomFunction` | The function to use for generating random bytes                                                                                                                                                                                              | `random_bytes`                                                     |

## Usage

```php
$nanoId = \Fanmade\NanoId\Facades\NanoId::generate(); // Returns a Nano ID
```