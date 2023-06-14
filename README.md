# Catalyst PHP Script Task

A PHP script that is executed from the command line, which accepts a CSV file as input and processes it into a database table.

## Table Of Contents
- [Requirements](#requirements)
- [Console Directives](#console-directives)
- [Setup & Installation](#setup---installation)
- [Assumptions](#assumptions)
- [Demonstration](#demonstration)

## Technologies
* [PHP](https://www.php.net/)
* [Composer](https://getcomposer.org/)
* [PHP League CSV](https://github.com/thephpleague/csv)

## Requirements
* PHP
* Composer
* MySQL Server

## Console Directives
The following directives can be used in the console to perform actions. You may use multiple at a time:

| **Directive** | **Usage** | **Description** |
|---|---|---|
| --file | php user_upload.php --file=filename.csv | The name of the CSV to be parsed. |
| --create_table | php user_upload.php --create_table | Build the MySQL users table. |
| --dry_run | php user_upload.php --dry_run | Used with the **--file** directive to run the script but not insert data into the database. |
| -u | php user_upload.php -u=myusername | Specify a MySQL username. |
| -p | php user_upload.php -p=mypassword | Specify a MySQL password. |
| -h | php user_upload.php -h=databasehost | Specify a MySQL host. |
| --help | php user_upload.php --help | Output directive information. |

## Setup & Installation
1. Clone the repository onto your machine.
2. Navigate to the repository folder and complete the following actions.
3. Run `composer install` to install the composer dependencies.
4. Create a new file named `.env` and copy the contents of `.example.env` into the new file.
5. Create a new MySQL database schema on your machine and keep the details handy.
6. Configure the environment variables in the `.env` file.
7. You're all good to go!


## Assumptions
- The database should roll back when an error occurs.
- An environment file is required.
- Invalid CSV records are ignored.
- The CSV file will always have a header.
- The `users` table is dropped if it already exists.
- Helper classes should be made to assist in code readability.
- A lightweight solution. The Laravel framework could have been used to help complete the task but this solution is light weight.

## Demonstration

### Insertion Directive
![](https://imgur.com/BtdFFZF.png)

### Help Directive
![](https://imgur.com/lDoJfle.png)

### Database View
![](https://imgur.com/pmr6fhZ.png)