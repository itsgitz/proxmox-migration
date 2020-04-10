<?php

namespace ProxmoxMigration\DB;

class DatabaseRepository
{
    /**
     * 
     * export/import definition
     * 
     * */ 
    const IMPORT = 'import';
    const EXPORT = 'export';
    const STORAGE_DIR = './storage';
    const CSV_EXTENTIONS = '.csv';

    /**
     * System status message
     */
    const DB_INVALID_ARGUMENT = "Invalid argument! \n";
    const DB_CONNECTION_PROBLEM = "Database connection problem! \n";

    /* Table name and columns definition */

    /**
     * ProxmoxAddon_User
     */
    const PROXMOX_ADDON_USER_TABLENAME = 'ProxmoxAddon_User';
    const PROXMOX_ADDON_USER_COLUMNS = '(id,user_id,hosting_id,username,password,realm)';
    const PROXMOX_ADDON_USER_CSV_FILES = self::STORAGE_DIR . DIRECTORY_SEPARATOR . self::PROXMOX_ADDON_USER_TABLENAME . self::CSV_EXTENTIONS;

    /**
     * ProxmoxAddon_VmIpAddress
     */
    const PROXMOX_ADDON_VMIPADDRESS_TABLENAME = 'ProxmoxAddon_VmIpAddress';
    const PROXMOX_ADDON_VMIPADDRESS_COLUMNS = '(id,hosting_id,server_id,ip,mac_address,subnet_mask,gateway,cidr,trunks,tag,net)';
    const PROXMOX_ADDON_VMIPADDRESS_CSV_FILES = self::STORAGE_DIR . DIRECTORY_SEPARATOR . self::PROXMOX_ADDON_VMIPADDRESS_TABLENAME . self::CSV_EXTENTIONS;

    /**
     * mg_proxmox_addon_ip
     */
    const MG_PROXMOX_ADDON_IP_TABLENAME = 'mg_proxmox_addon_ip';
    const MG_PROXMOX_ADDON_IP_COLUMNS = '(id,ip,type,mac_address,subnet_mask,gateway,cidr,sid,visualization,last_check,private,hosting_id,trunks,tag,node)';
    const MG_PROXMOX_ADDON_IP_CSV_FILES = self::STORAGE_DIR . DIRECTORY_SEPARATOR . self::MG_PROXMOX_ADDON_IP_TABLENAME . self::CSV_EXTENTIONS;

    /* Users table, only for testing on local database server */
    const USERS_TABLENAME = 'users';
    const USERS_COLUMNS = '(id,created_at,updated_at,deleted_at,username,name,password,role,job_title)';
    const USERS_CSV_FILES = self::STORAGE_DIR . DIRECTORY_SEPARATOR . self::USERS_TABLENAME . self::CSV_EXTENTIONS;


    public function showListTables()
    {
        // Date
        $date = date('D, d F Y');

        // Print all tables that want to migrate
        echo "\n** $date \n";
        echo "** All tables that will migrate along with csv filename that should be produced: \n";
        echo self::PROXMOX_ADDON_USER_TABLENAME . ", '" . self::PROXMOX_ADDON_USER_CSV_FILES . "';
            - " . self::PROXMOX_ADDON_VMIPADDRESS_TABLENAME . ", '" . self::PROXMOX_ADDON_VMIPADDRESS_CSV_FILES . "'
            - " . self::MG_PROXMOX_ADDON_IP_TABLENAME . ", '" . self::MG_PROXMOX_ADDON_IP_CSV_FILES . "'
        \n";
    }
}