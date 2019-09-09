# Changelog

All Notable changes to `larasearch` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## [UNRELEASED]

## [2.0.0] 2019-09-08

### Added
- support for Laravel 6

### Removed
- support for Laravel 5

## [1.0.0] 2017-10-30

### Added
- Queue tubes are now customizable.
- Support for Laravel auto-discovery.

### Changed
- Rename the config file to `larasearch.php` to help avoid conflicts.
- Moving forward with PHP7. No longer supporting older versions.
- Rename the service provider.

### Fixed
- `getSearchContent()` was incorrectly spelled `gtSearchContent()` in the `CanBeSearched` trait.
- If the config does not contain a 'models' key, we will make sure we default to an array in the `IndexCommand`.

## [0.1.1] - 2017-06-04

### Fixed
- `getTotalHits` now uses the correct metadata
- `getMaxScore` now uses the correct metadata

## 0.1.0 - 2017-05-22

### Added
- New package :)

[unreleased]: https://github.com/browner12/larasearch/compare/v2.0.0...HEAD
[2.0.0]: https://github.com/browner12/larasearch/compare/v1.0.0...v2.0.0
[1.0.0]: https://github.com/browner12/larasearch/compare/v0.1.1...v1.0.0
[0.1.1]: https://github.com/browner12/larasearch/compare/v0.1.0...v0.1.1
