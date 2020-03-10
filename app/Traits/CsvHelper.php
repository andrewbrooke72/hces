<?php

/**
 * Created by PhpStorm.
 * User=> admin
 * Date=> 2018-11-22
 * Time=> 5=>54 PM
 */

namespace HCES\Traits;

trait CsvHelper
{
    public function getFileHeaders($file_path)
    {
        $file = fopen($file_path, 'r');
        $file_columns = [];
        $index = 0;
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            if ($index > 0) {
                break;
            }
            foreach ($data as $data_value) {
                array_push($file_columns, $data_value);

            }
            $index++;
        }
        fclose($file);
        return $file_columns;
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    if (count($header) != count($row)) {
                        continue;
                    }
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }

    function arrayToCsv($data, $delimiter = ',', $enclosure = '"')
    {
        $handle = fopen('php://temp', 'r+');
        foreach ($data as $line) {
            fputcsv($handle, $line, $delimiter, $enclosure);
        }
        rewind($handle);
        $contents = null;
        while (!feof($handle)) {
            $contents .= fread($handle, 8192);
        }
        fclose($handle);
        return $contents;
    }

    public function utf8_converter($array)
    {
        array_walk_recursive($array, function (&$item, $key) {
            if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);
            }
        });

        return $array;
    }

}
