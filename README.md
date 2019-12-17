# MusicHub

A music discovery website/catalog built as a project for systems integration at NJIT.

### Prerequisites

These directions are written assuming the user is running Ubuntu Server 18.04.

Get these dependencies/requirements:
```
sudo apt-get install php apache2 mysql-server rabbitmq-server php-bcmath php-mbstring composer php-curl php-gettext php-mysql

composer require php-amqplib/php-amqplib
```

### Installing

Everything you need to do to get a working copy of this project running on your machine(s).

Front -

1. Clone this repository.

2. Inside "Front End Server" folder, modify `.ini` files to use RMQ Server's IP address.

3. Inside the "Front End Server" folder, execute: `sudo mv -r * /var/www/html`.

4. Start browser, enter localhost in address bar, then test.

Database - 

If new install of MySQL, first execute `sudo mysql` then after logging in: `ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';` then `FLUSH PRIVILEGES;`.

1. Execute: `mysql -u root -p`, make a database called "website".

2. Inside "SQL Files" folder, execute: `mysql -u root -p website < music.sql` (also `users.sql`).

3. Inside "Database Server" folder, modify `.ini` files to use RMQ Server's IP address.

4. Run each file that has "receiver" in its name using `php <receiver_name>.php`.

RMQ - 

1. Execute:
```
sudo rabbitmqctl add_user admin password 
sudo rabbitmqctl set_user_tags admin administrator
sudo rabbitmqctl set_permissions -p / admin ".*" ".*" ".*"
```
2. Execute:
```
sudo rabbitmq-plugins enable rabbitmq_management
```
3. Start browser, enter localhost:15672 in address bar, then test.

API - 

1. Inside "API Server" folder, modify `.ini` files to use RMQ Server's IP address.

2. Run each file that has "receiver" in its name using `php <receiver_name>.php`.

## Authors

See the list of [contributors](https://github.com/adr50/MusicHub/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.
