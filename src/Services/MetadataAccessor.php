<?php

namespace Iteks\Support\Services;

use Iteks\Attributes\Metadata;

/**
 * Proxy class to provide property-like access to enum metadata.
 */
class MetadataAccessor
{
    /**
     * Create a new metadata accessor instance.
     */
    public function __construct(
        private readonly object $case
    ) {}

    /**
     * Magic method to access metadata values as properties.
     *
     * @param  string  $name  The property name to access.
     * @return mixed The metadata value if found, null otherwise.
     */
    public function __get(string $name): mixed
    {
        $metadata = HasAttributesService::tryAttributeClass(Metadata::class, $this->case)?->metadata;

        if ($metadata === null) {
            return null;
        }

        // Handle JSON string metadata
        if (is_string($metadata) && str_starts_with(trim($metadata), '{')) {
            $decoded = json_decode($metadata, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $metadata = $decoded;
            }
        }

        if (! is_array($metadata)) {
            return null;
        }

        return $metadata[$name] ?? null;
    }
}
