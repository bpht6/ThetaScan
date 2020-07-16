# ThetaScan.io

A PHP block explorer for the Theta Blockchain.

**Setup**: 

To run this explorer a Theta node will need to ran on the local machine.  Please follow the Theta node [setup guide](https://github.com/thetatoken/theta-mainnet-integration-guide/blob/master/docs/setup.md#setup) provides the instructions to build and install the Theta Ledger on a Linux machine.

If you wish to run a test net node on the same machine copy the php files into the test net directory and configure the port of the node in test net.  (It can not be the same port as main net)

Apache must be installed.

```
sudo apt update
sudo apt install apache2
```

Curl must be installed.

```
sudo apt-get install curl
```

MySQL must be installed and configured.

```
sudo apt install mysql-server
```

PHP must be installed and configured.

```
sudo apt-get install php libapache2-mod-php php-mcrypt php-mysql php-curl
```
In MySQL create the following databases and tables.

```
CREATE DATABASE prices;
CREATE DATABASE transactions;

CREATE TABLE `prices`.`prices` (`name` TEXT NOT NULL, `price` TEXT NOT NULL,`volume` TEXT NOT NULLL,`percent_change` TEXT NOT NULL,`market` TEXT NOT NULL);
CREATE TABLE `transactions`.`coinbase` (`timestamp` TEXT NOT NULL, `block` TEXT NOT NULL,`address` TEXT NOT NULLL,`tfuel` TEXT NOT NULL,`compressed` TEXT NOT NULL);
CREATE TABLE `transactions`.`block` (`last_block` TEXT NOT NULL, `number` TEXT NOT NULL);
CREATE TABLE `transactions`.`guardian` (`timestamp` TEXT NOT NULL, `block` TEXT NOT NULL, `type` TEXT NOT NULL, `address` TEXT NOT NULL, `node` TEXT NOT NULL, `hash` TEXT NOT NULL, `theta` TEXT NOT NULL);
CREATE TABLE `transactions`.`staking_wallets` (`address` TEXT NOT NULL, `theta` TEXT NOT NULL, `status` TEXT NOT NULL, `timestamp` TEXT NOT NULL, `process` TEXT NOT NULL);
CREATE TABLE `transactions`.`transactions` (`block` TEXT NOT NULL, `fee_thetawei` TEXT NOT NULL, `fee_tfuelwei` TEXT NOT NULL, `add_from` TEXT NOT NULL, `sent_thetawei` TEXT NOT NULL, `sent_tfuelwei` TEXT NOT NULL, `add_to` TEXT NOT NULL, `type` TEXT NOT NULL, `hash` TEXT NOT NULL);
```

In crontab set the following processes.

```

1 * * * * php /var/thetascan/main_net_process_blocks.php
1 * * * * php /var/thetascan/main_net_process_guardian.php
10 * * * * php /var/thetascan/get_cmc_prices.php

```

Copy all the PHP files from the website folder to the corresponding folder in Apache.

Configure the config.ini to match the settings for MySQL.


