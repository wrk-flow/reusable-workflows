# Contributing

## Commits

Use [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/) for all commit messages.

Format:

```text
type(scope): short summary
```

Rules:

1. Use the imperative mood, for example `add`, `fix`, `update`, `remove`
2. Keep the summary short and specific
3. Use a scope when it helps clarify the affected area
4. Use `!` after the type or scope for breaking changes

Examples:

```text
feat(workflows): add reusable PHP tests workflow
fix(php-check): install Composer v2 for static analysis
docs(readme): improve php-test secret usage example
chore(ci): update action versions
refactor(sample): simplify PHPUnit fixture
```

Common types:

1. `feat` for a new feature
2. `fix` for a bug fix
3. `docs` for documentation-only changes
4. `refactor` for code changes that do not change behavior
5. `test` for adding or updating tests
6. `chore` for maintenance work
7. `ci` for CI or workflow changes

Breaking changes:

1. Use `type(scope)!: summary`, for example `feat(workflows)!: rename php-test inputs`
2. Include a `BREAKING CHANGE:` footer when extra migration details are needed

Example with body and footer:

```text
feat(workflows): add badge publishing toggle

Allow projects to disable coverage badge publishing for pull requests.

Refs: #123
```

## Pull Requests

1. Keep each pull request focused on a single concern
2. Update documentation when workflow behavior or inputs change
3. Include example usage when adding or changing reusable workflow inputs
4. Prefer separate pull requests for unrelated changes
