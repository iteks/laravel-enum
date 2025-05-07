## [1.1.0] - 2025-05-06

### Added

-   `meta()` accessor for property-style access to enum metadata.
-   `keyBy` support in `descriptions()`, `labels()`, `ids()`, and `metadatum()` for keyed associative outputs (by case `name` or `value`).
-   `mapCasesTo()` abstraction to DRY up attribute accessor logic.
-   New example enum class: `BackedEnumShape` (used in tests and documentation).
-   Pest tests to verify `meta()` accessor behavior.
-   README updates with new usage examples for `meta()` and `keyBy` features.

### Updated

-   Refactored `HasAttributesService` to use `mapCasesTo()` and support `keyBy`.
-   Updated `EnumService` and facade docblocks to reflect new method signatures.
-   Replaced old example enums in dev/test files with `BackedEnumShape`.

### Fixed

-   Minor documentation typos and improved consistency across example output.
