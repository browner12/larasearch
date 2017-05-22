# LaraSearch

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is a search package built to easily integrate with Laravel. It uses a driver based system to abstract the internals of each specific search provider away from you. Currently only Elasticsearch is supported.

## Why Not Use Scout?

There are 2 major differences between Scout and LaraSearch. First, Scout currently only has native support for Algolia, which is a service you pay for. They do have a free option, but this version has limits that will definitely be an issue for some. While Elasticsearch was originally supported, it was dropped due to complexity. There is a community effort to bring it back in as a native driver, but the road map on that is uncertain. 

The second, and more important difference is that LaraSearch allows for 'site wide' searching, while Scout does not. In Scout, the searching is done on the models.

```php
User::search('Andrew');
```

While this may be okay for some users, the far more common requirement is to be able to search an entire site. If a query is submitted for 'Andrew', I want to find the `User` Andrew, the `Department` he belongs to, and all of the `Blog` posts he has written. Additionally with LaraSearch, you are still able to restrict your search to a specific model if so desired.

## Install

``` bash
$ composer require browner12/larasearch
```

If you are using the Elasticsearch driver, you must also install their package

``` bash
$ composer require elasticsearch/elasticsearch
```

## Setup

Add the service provider to the providers array in  `config/app.php`.

``` php
'providers' => [
    browner12\larasearch\SearchServiceProvider::class,
];
```

## Publishing

You can publish everything at once

``` php
php artisan vendor:publish --provider="browner12\larasearch\SearchServiceProvider"
```

or you can publish groups individually.

``` php
php artisan vendor:publish --provider="browner12\larasearch\SearchServiceProvider" --tag="config"
```

## Usage

Your desired driver is bound to a `Searcher` interface, so anyplace you wish to use LaraSearch that supports automatic dependency resolution, you can simply type hint the interface.

``` php

class SearchController
{
    public function index(Searcher $searcher)
    {
        $results = $searcher->search('Andrew');
    }
}
```

Please see the [DOCUMENTATION](docs/) for more in-depth explanations.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email browner12@gmail.com instead of using the issue tracker.

## Credits

- [Andrew Brown][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/browner12/larasearch.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/browner12/larasearch/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/browner12/larasearch.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/browner12/larasearch.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/browner12/larasearch.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/browner12/larasearch
[link-travis]: https://travis-ci.org/browner12/larasearch
[link-scrutinizer]: https://scrutinizer-ci.com/g/browner12/larasearch/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/browner12/larasearch
[link-downloads]: https://packagist.org/packages/browner12/larasearch
[link-author]: https://github.com/browner12
[link-contributors]: ../../contributors
