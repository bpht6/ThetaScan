# ThetaScan.io

A PHP block explorer for the Theta Blockchain.

**Setup**: 

To run this explorer a Theta node will need to ran on the local machine.  Please follow the Theta node [setup guide](https://github.com/thetatoken/theta-mainnet-integration-guide/blob/master/docs/setup.md#setup) provides the instructions to build and install the Theta Ledger on a Linux machine.


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

```

Copy all the PHP files from the website folder to the corresponding folder in Apache.

Configure the config.ini to match the settings for MySQL.


