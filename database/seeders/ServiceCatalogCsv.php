<?php

namespace Database\Seeders;

use RuntimeException;
use SplFileObject;

class ServiceCatalogCsv
{
    public const PATH = 'seeders/data/service-id-catalog-final-price-NEW.csv';

    public static function rows(): array
    {
        $path = database_path(self::PATH);

        if (!is_file($path)) {
            throw new RuntimeException("Service catalog CSV not found at {$path}");
        }

        $file = new SplFileObject($path);
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY);

        $headers = [];
        $rows = [];

        foreach ($file as $line) {
            if ($line === [null] || $line === false) {
                continue;
            }

            $line = array_map(fn ($value) => is_string($value) ? trim($value) : $value, $line);

            if ($headers === []) {
                $headers = array_map(function ($header) {
                    return ltrim((string) $header, "\xEF\xBB\xBF");
                }, $line);
                continue;
            }

            if (count($line) < count($headers)) {
                $line = array_pad($line, count($headers), null);
            }

            $row = array_combine($headers, array_slice($line, 0, count($headers)));

            if (!$row || blank($row['service_item_id'] ?? null)) {
                continue;
            }

            $rows[] = $row;
        }

        return $rows;
    }

    public static function numericPrice(mixed $value): float
    {
        if ($value === null || $value === '') {
            return 0.0;
        }

        return (float) preg_replace('/[^0-9.]/', '', (string) $value);
    }
}
