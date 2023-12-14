<?php

namespace App\Helpers;

class CsvHelper
{
    public static function normalizeHeaders(array $headers): array
    {
        $normalizedHeaders = [];

        foreach ($headers as $header) {
            $normalizedHeaders[] = static::trimCommas($header);
        }

        return $normalizedHeaders;
    }

    public static function trimCommas(string $str): string
    {
        return rtrim($str, '/[, ]+/');
    }

    public static function trimCommaQuotation(string $str): string
    {
        return trim($str, '",\\');
    }

    public static function removeCommas(string $str): string
    {
        return preg_replace('/[\'"]/', '', $str);
    }
}
