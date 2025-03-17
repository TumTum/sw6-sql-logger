# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Support for dumping with [myray.app](https://myray.app).

### Changed
- Now only compatible with Shopware ^6.6.5.
- Now requires PHP ^8.0.

## [v1.1.0] - 2023-08-03

### Fixed

- output of SQL Parameters in Hexadecimal

### Added

- you can use `StartSQLLog(useVarDumper: true)` to dump the SQLs into the `VarDumper::Server` and put out the result into a HTML file

## [v1.0.0] - 2023-07-31

### Added

- Global function `StartSQLLog` and `StopSQLLog`
- Display SQL Querys on Browser or CLI
