
# Install

## 1. 啟動 docker 環境

```shell
$ docker-composer up -d
```

## 2. 執行安裝

```shell
$ cp config_si.php.example config_si.php
```

修改 config_si.php 裡面的內容

```shell
$ docker exec suitecrm_suitecrm_1 curl http://localhost/install.php\?goto\=SilentInstall\&cli\=true
```

## 3. 安裝完成後訪問 127.0.0.1:5000

確認看到登入畫面

## 4. insert admin user

```sql
INSERT INTO `users` (`id`, `user_name`, `user_hash`, `system_generated_password`, `pwd_last_changed`, `authenticate_id`, `sugar_login`, `first_name`, `last_name`, `is_admin`, `external_auth_only`, `receive_notifications`, `description`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `title`, `photo`, `department`, `phone_home`, `phone_mobile`, `phone_work`, `phone_other`, `phone_fax`, `status`, `address_street`, `address_city`, `address_state`, `address_country`, `address_postalcode`, `deleted`, `portal_only`, `show_on_employees`, `employee_status`, `messenger_id`, `messenger_type`, `reports_to_id`, `is_group`, `factor_auth`, `factor_auth_interface`) VALUES
('1', 'admin', '$2y$10$FIiySm10KM/RNZXkbbbwfOuj1PjQgoGo/dKJkCaSsBrtzyYVm./Yi', '0', NULL, NULL, '1', NULL, 'Administrator', '1', '0', '1', NULL, '2020-12-02 08:04:24', '2020-12-02 08:04:24', '1', '', 'Administrator', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, NULL, '0', '0', '1', 'Active', NULL, NULL, NULL, '0', NULL, NULL);
```

## 5. api key (需要 安裝完之後的 config 檔案)
./vendor/bin/robo api:generate-keys

會在 Api/Oauth2/ 底下產生 private.key, public.key

## 6. modified tables (需要 安裝完之後的 config 檔案)
產生 cache
./vendor/bin/robo repair:quick-repair-and-rebuild

## 7. config_override.php 為系統上線後的*進階*系統設定檔
config_override.php 裡面的參數為進階系統設定存放的地方

直接覆蓋 config_override

```shell
$ cp config_override.php.example => config_override.php
```

之後修改 config_override.php 的參數

```shell
sed '/\$sugar_config\[\x27logger\x27\]\[\x27level\x27\] = \x27debug2\x27/a $sugar_config[\x27logger\x27][\x27default\x27] = \x27CustomSugarLogger\x27;' config_override.php || sed '/\$sugar_config\[\x27logger\x27\]\[\x27level\x27\] = \x27debug\x27/a $sugar_config[\x27logger\x27][\x27default\x27] = \x27CustomSugarLogger\x27;' config_override.php
```

# .gitignore
有調整過追蹤 custom 目錄底下的客制功能

