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
     * @return file
     * 
     */
    public function exportToCsv($table, $data)
    {
        $filename = DB_REPO::STORAGE_DIR . DIRECTORY_SEPARATOR . $table . DB_REPO::CSV_EXTENTIONS;
        $fp = fopen($filename, 'w');

        // insert into csv file
        foreach ($data as $d) {
            fputcsv($fp, $d);
        }

        fclose($fp);
    }
}