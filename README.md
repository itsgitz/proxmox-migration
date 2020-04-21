# Proxmox Data Migration Script

This is program/script that created for WHMCS Proxmox Addon Module data migration with PHP. It's migrate data from old Proxmox Addon Module version (v2.5) to new module version (v2.7.3).

# Why did I create this script for?

Old version of Proxmox Addon module and new or current version has difference data table structure, such as difference table name and column name, but has similiar values. So I create this PHP script for auto migration.

# How does this work?

This script will exporting data on old version proxmox tables to CSV file format, then importing these data into new proxmox tables with different table name and column name. This script has two mode, production mode (`prod`) and development mode (`dev`).

# Usage

```shell
# php -q app.php [action, import|export] [mode, dev|prod]
```

# Contributor

Anggit M Ginanjar (anggit.ginanjar@outlook.com)