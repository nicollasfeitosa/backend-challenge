<?php

namespace App\Utils;

class ExporterHelper
{
    private const CSV_DELIMITER = ';';

    public static function exportCsv(array $data, array $headers, string $path)
    {
        $file = fopen($path, 'w');
        fputcsv($file, $headers);

        foreach ($data as $row) {
            fputcsv($file, $row, self::CSV_DELIMITER);
        }

        fclose($file);
    }
}
