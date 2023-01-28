
DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      forms/              contains forms definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 7.1 above


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

Now you should be able to access the application through the following URL, assuming `basic` is the directory
directly under the Web root.

~~~
http://localhost/basic/web/
~~~

CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=testing',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTES:**
- Check and edit the other files in the `config/` directory to customize your application as required.

** Configure "web.php" & "console.php" **

1) - Find the "setAlias", update the string to the AWS S3 bucket path to follow white label keyword

2) - Update important parameter
"name" : Current white label company name
"aws" : Setup the key, secret and the bucket name
"timezone" : Update if necessary on project basis
[Line 3] "project" : Update to project name

3) ** Check folder permission **

- Provide permission via chmod 777 for folder "runtime" and "web/assets"

4) ** Project installation **

- Execute commands
```
composer install
php yii migrate --migrationPath=@yii/rbac/migrations
php yii migrate
```

5) ** Initial system data insert **

- Find the sql file to insert under "data" folder
```
init_user_role (for user role purposes)
```

6) ** Create first administrator account for yourself **

- Execute commands for create an admin & provide full permission to the admin

```
    php yii system/create-user
    php yii rbac
```



7. Start web server:

    ```
    php yii serve
    ```