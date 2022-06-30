# Reusable Workflows for Wrkflow packages

See https://docs.github.com/en/actions/learn-github-actions/reusing-workflows#calling-a-reusable-workflow

## PHP  Check

1. Create a file `.github/workflows/check.yml`
2. Runs PHP stan **(needs to be installed).**
3. Runs Rector PHP **(needs to be installed).**
4. Runs ECS **(needs to be installed).**
5. Runs PHP unit tests
    1. PHP 8.1
    2. Highest / lowest depedencies
6. Publishes code coverage (only on main branch, not triggered if `secrets.GIST_SECRET` and `inputs.gistID` is not set)
    1. Using dynamic badges ([Follow how to create GIST](https://github.com/marketplace/actions/dynamic-badges))
        1. Use `coverage.json` file name
    2. You need to create GIST and pass the id (hash) `with.gistID`
    3. Ensure that `GIST_SECRET` is set in your repo secrets.

```yaml
name: Check

on:
  pull_request:
  push:
    branches:
      - "*"
      - "!gh-pages"

jobs:
  run:
    uses: wrk-flow/reusable-workflows/.github/workflows/php-check.yml@main
    secrets: inherit
    with:
      gistID: hash
```

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
