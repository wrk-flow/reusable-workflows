# Reusable Workflows for Wrkflow packages

See https://docs.github.com/en/actions/learn-github-actions/reusing-workflows#calling-a-reusable-workflow

## PHP

Projects using [larastrict/conventions](https://github.com/larastrict/conventions) or [strictphp/conventions](https://github.com/strictphp/conventions) already match the expected commands and tooling used by these workflows.


### ECS / Rector PHPStan

Use `.github/workflows/php-check.yml` to run code quality checks.

What it does:

1. Validates `composer.json` with `composer validate`
2. Installs dependencies with `composer install`
3. Runs ECS with `composer lint:check`
4. Runs Rector with `composer lint:upgrade:check`
5. Runs PHPStan with `composer analyse`
6. Runs static analysis on both lowest and highest dependency versions

Required project scripts and tools:

1. `composer analyse`
2. `composer lint:check`
3. `composer lint:upgrade:check`

Projects using [larastrict/conventions](https://github.com/larastrict/conventions) or [strictphp/conventions](https://github.com/strictphp/conventions) already match these required commands and tools.

Example:

```yaml
name: Check

on:
  pull_request:
  push:
    branches:
      - "*"
      - "!gh-pages"

jobs:
  check:
    uses: wrk-flow/reusable-workflows/.github/workflows/php-check.yml@main
    with:
      phpVersion: "8.3"
      workingDirectory: "."
    secrets: inherit
```

Available inputs:

1. `phpVersion` - PHP version to use, default `8.1`
2. `workingDirectory` - project directory, default `.`
3. `composerRequire` - extra packages to require before install
4. `composerRequireDev` - extra dev packages to require before install

### PHPUnit tests

![badge](https://img.shields.io/endpoint?url=https://gist.githubusercontent.com/pionl/de6a8c4102b8d237e822ca47ed805036/raw/coverage.json)

Use `.github/workflows/php-tests.yml` to run PHPUnit and optionally publish a coverage badge.

What it does:

1. Runs PHPUnit with coverage output
2. Tests both lowest and highest dependency versions
3. Extracts line coverage from the PHPUnit report
4. Optionally publishes coverage to a Gist as `coverage.json`

Required project setup:

1. `vendor/bin/phpunit` must be available
2. Xdebug coverage must work in your test suite

Example:

```yaml
name: Tests

on:
  pull_request:
  push:
    branches:
      - main

jobs:
  tests:
    strategy:
      matrix:
        phpVersion: ["8.3", "8.4"]
    uses: wrk-flow/reusable-workflows/.github/workflows/php-tests.yml@main
    with:
      phpVersion: ${{ matrix.phpVersion }}
      workingDirectory: "."
      gistID: "your-gist-id"
      gistOnPhpVersion: "8.3"
    secrets:
      GIST_SECRET: ${{ secrets.GIST_SECRET }}
```

Available inputs:

1. `phpVersion` - PHP version to use, default `8.1`
2. `workingDirectory` - project directory, default `.`
3. `composerRequire` - extra packages to require before install
4. `composerRequireDev` - extra dev packages to require before install
5. `composerRemove` - packages to remove after install
6. `dirsRemove` - directories to remove before running tests
7. `gistID` - Gist ID used for the coverage badge
8. `gistOnPhpVersion` - only publish the badge for this PHP version, default `8.1`
9. `badgeOnBranch` - only publish on this branch, default `main`
10. `badgeOnPullRequest` - also publish on pull requests, default `false`

Coverage badge notes:

1. Badge publishing only runs when `gistID` is set and `GIST_SECRET` is passed to the reusable workflow.
2. Create a Gist first and use `coverage.json` as the filename.
3. If you use an organization secret, pass it explicitly:

```yaml
secrets:
  GIST_SECRET: ${{ secrets.GIST_SECRET }}
```

4. `secrets: inherit` can be used for general secret forwarding, but for `php-tests.yml` it is safer to document `GIST_SECRET` explicitly because the reusable workflow declares that secret by name.

## Documentation

1. Create a file `.github/workflows/deploy-docs.yml`
2. Create `docs` folder and setup `package.json` with this command `npm run generate`
    1. Use NuxtJS content package
3. Deploy will build the site and deploy `docs/dist` to `gh-pages` (which is cleaned from original source code).
    1. Deploy on `main` branch
    2. Deploy on `v**` tags to ensure that NuxtJS content docs theme updates `Releases` page

```yaml
name: Documentation

on:
  push:
    branches:
      - main
    tags:
      - v**
jobs:
  run:
    uses: wrk-flow/reusable-workflows/.github/workflows/deploy-docs.yml@main
    secrets: inherit
```
