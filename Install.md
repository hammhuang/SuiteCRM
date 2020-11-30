
# Install
## 安裝(會需要 config_si.php)

```shell
$ cp config_si.php.example => config_si.php
```

```php
$sugar_config_si = array(
    'setup_create_default_user' => 0,// Custom variable
    'default_currency_iso4217' => 'TWD',
    'default_currency_name' => 'Taiwan Dollars',
    'default_currency_significant_digits' => '2',
    'default_currency_symbol' => '$',
    'default_date_format' => 'Y-m-d',
    'default_decimal_seperator' => '.',
    'default_export_charset' => 'UTF-8',
    'default_language' => 'en_us',
    'default_locale_name_format' => 's f l',
    'default_number_grouping_seperator' => ',',
    'default_time_format' => 'H:i',
    'export_delimiter' => ',',
    'setup_db_admin_password' => 'secret', # 需修改
    'setup_db_admin_user_name' => 'suitecrm', # 需修改
    'setup_db_create_database' => 0,
    'setup_db_database_name' => 'suitecrm', # 需修改
    'setup_db_drop_tables' => 0,
    'setup_db_host_name' => 'suite_mysql', # 需修改
    'setup_db_pop_demo_data' => false,
    'setup_db_type' => 'mysql',
    'setup_db_username_is_privileged' => true,
    'setup_db_create_sugarsales_user' => 0,
    'setup_site_admin_password' => 'admin', # 需修改
    'setup_site_admin_user_name' => 'admin', # 需修改
    'setup_site_url' => 'http://127.0.0.1:5000', # 需修改
    'setup_system_name' => 'Site Name', # 需修改
);
```

curl http://localhost/install.php?goto=SilentInstall&cli=true

## api key (需要 安裝完之後的 config 檔案)
./vendor/bin/robo api:generate-keys

## modified tables (需要 安裝完之後的 config 檔案)
./vendor/bin/robo repair:quick-repair-and-rebuild

## config_override.php 為系統上線後的系統設定檔
config_override.php 的東西 是安裝完之後的

# .gitignore
有調整過追蹤 custom 目錄底下的客制功能

