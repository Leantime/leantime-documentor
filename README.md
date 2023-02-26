<h1 align="center">Leantime Documentor</h1>

[![Latest Stable Version](https://poser.pugx.org/pronamic/wp-documentor/v)](//packagist.org/packages/pronamic/wp-documentor)
[![Total Downloads](https://poser.pugx.org/pronamic/wp-documentor/downloads)](//packagist.org/packages/pronamic/wp-documentor)
[![Latest Unstable Version](https://poser.pugx.org/pronamic/wp-documentor/v/unstable)](//packagist.org/packages/pronamic/wp-documentor)
[![License](https://poser.pugx.org/pronamic/wp-documentor/license)](//packagist.org/packages/pronamic/wp-documentor)

## Table of contents

- [Table of contents](#table-of-contents)
- [Getting Started](#getting-started)
	- [First Run](#first-run)
- [Command Line Usage](#command-line-usage)
	- [`--format=FORMAT`](#--formatformat)
	- [`--template=FILE`](#--templatefile)
	- [`--type=TYPE`](#--typetype)
	- [`--output=FILE`](#--outputfile)
	- [`--memory-limit=VALUE`](#--memory-limitvalue)
	- [`--exclude=GLOB`](#--excludeglob)
	- [`--ignore-vcs-ignored`](#--ignore-vcs-ignored)
	- [`--prefix=PREFIX`](#--prefixprefix)
	- [Examples](#examples)
- [Ouput Examples](#ouput-examples)

## Getting Started

### First Run

To let Leantime Documentor analyse your codebase, you have to use the `parse` command and point it to the right directory:

```
vendor/bin/leantime-documentor parse src
```

## Command Line Usage

### `--format=FORMAT`

The format in which you want to export the hooks.

| Format              | Description                         |
| ------------------- | ----------------------------------- |
| `default`           | Symfony console table.              |
| `hookster`          | Hookster JSON.                      |
| `markdown`          | Markdown.                           |
| `phpdocumentor-rst` | RestructuredText for phpDocumentor. |

Example: `--format=markdown`

### `--template=FILE`

Custom PHP template, see for examples the [`templates`](templates) folder.

Example: `--template=templates/markdown.php`

### `--type=TYPE`

Specify whether you want to export `actions` or `filters`.

Example: `--type=actions` or `--type=filters`

### `--output=FILE`

Write output to file.

Example: `--output=docs/hooks.md`

### `--memory-limit=VALUE`

Specifies the memory limit in the same format `php.ini` accepts.

Example: `--memory-limit=-1`

### `--exclude=GLOB`

Exclude the specified folders/files.

Example: `--exclude=vendor`

### `--ignore-vcs-ignored`

If the search directory contains a `.gitignore` file, you can reuse those rules to exclude files and directories from the results with this option.

Example: `--ignore-vcs-ignored`

### `--prefix=PREFIX`

Only parse hooks starting with the specified prefixes.

Example: `--prefix=my_theme --prefix=my_plugin`

### Examples

```
vendor/bin/leantime-documentor parse ./tests/source
```

```
vendor/bin/leantime-documentor parse ./tests/source --format=hookster --type=actions --output=tests/docs/hookster-actions.json
vendor/bin/leantime-documentor parse ./tests/source --format=hookster --type=filters --output=tests/docs/hookster-filters.json
```

```
vendor/bin/leantime-documentor parse ./tests/source --format=markdown --output=tests/docs/hooks.md
```

```
vendor/bin/leantime-documentor parse ./tests/source --format=phpdocumentor-rst --type=actions --output=tests/docs/phpdocumentor-actions.rst
vendor/bin/leantime-documentor parse ./tests/source --format=phpdocumentor-rst --type=filters --output=tests/docs/phpdocumentor-filters.rst
```

## Ouput Examples

- [tests/docs/hooks.md](tests/docs/hooks.md)
- [tests/docs/hookster-actions.json](tests/docs/hookster-actions.json)
- [tests/docs/hookster-filters.json](tests/docs/hookster-filters.json)