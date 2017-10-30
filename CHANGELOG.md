# Changelog

All Notable changes to `larasearch` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## [UNRELEASED]

### Added
- Queue tubes are now customizable.

### Changed
- Rename the config file to `larasearch.php` to help avoid conflicts.
- Moving forward with PHP7. No longer supporting older versions.

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

[unreleased]: https://github.com/browner12/larasearch/compare/v0.1.1...HEAD
[0.1.1]: https://github.com/browner12/larasearch/compare/v0.1.0...v0.1.1
