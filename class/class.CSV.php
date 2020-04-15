<?php

namespace ProxmoxMigration\DB;

use ProxmoxMigration\DB\DatabaseRepository as DB_REPO;

class CSV
{   
    /**
     * generateToCsv
     * 
     * @param string tablename
     * @param array data
     * @return array ['filename', 'true']
     * 
     */
    public function exportToCsv($table, $data)
    {
        $filename = DB_REPO::STORAGE_DIR . DIRECTORY_SEPARATOR . $table . DB_REPO::CSV_EXTENTIONS;
        $fp = fopen($filename, 'w');

        // fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

        // insert into csv file
        foreach ($data as $d) {
            fputcsv($fp, $d);
        }

        fclose($fp);

        // check if file successfully created (data exported)
        if (file_exists($filename)) {
            return [
                'filename' => $filename,
                'status' => true,
            ];
        } else {
            return [
                'status' => false,
            ];
        }
    }
}