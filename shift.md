This pull request includes the changes for upgrading to Laravel 11.x. Feel free to commit any additional changes to the `master` branch.

**Before merging**, you need to:

- Checkout the `master` branch
- Review **all** pull request comments for additional changes
- Run `composer update` (if the scripts fail, try with `--no-scripts`)
- Clear any config, route, or view cache
- Thoroughly test your application ([no tests?](https://laravelshift.com/laravel-test-generator), [no CI?](https://laravelshift.com/ci-generator))

If you need help with your upgrade, check out the [Human Shifts](https://laravelshift.com/human-shifts).


1. :information_source: To slim down the Laravel installation, Laravel 11 no longer has most of the core files previously included in the default Laravel application. While you are welcome to publish and customize these files, they are no longer required.

Shift takes an iterative approach to removing core files which are not customized or where its customizations may be done elsewhere in a modern Laravel 11 application. As such, you may see some commits removing files and others _re-registering_ your customizations.

2. :information_source: Laravel 11 no longer requires you to maintain the default configuration files. Your configuration [now merges with framework defaults](https://laravel-news.com/laravel11-streamlined-configs). 

Shift [streamlined your configuration files]({#commit:54c601ecfd1bf8ba52bea17cd333244ac1805fbe}) by removing options that matched the Laravel defaults and preserving your _true customizations_. These are values which are not changeable through `ENV` variables.

If you wish to keep the full set of configuration files, Shift recommends running `artisan config:publish --all --force` to get the latest configuration files from Laravel 11, then reapplying the customizations Shift streamlined.

3. :information_source: Shift detected customized options within your configuration files which may be set with an `ENV` variable. To help keep your configuration files streamlined, you may set the following variables. Be sure adjust any values per environment.

```txt
BCRYPT_ROUNDS=10
CACHE_STORE=file
DB_CONNECTION=mysql
MAIL_MAILER=smtp
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
```

**Note:** some of these may simply be values which changed between Laravel 10 and Laravel 11. You may ignore any `ENV` variables you do not need to customize.

4. :warning: The `BROADCAST_DRIVER`, `CACHE_DRIVER`, and `DATABASE_URL` environment variables were renamed in Laravel 11 to `BROADCAST_CONNECTION`, `CACHE_STORE`, and `DB_URL`, respectively.

Shift [automated this change]({#commit:11c81ba166d27be5be88bfcac31a1dcb1a9c63fa}) for your committed files, but you should review any additional locations where your environment is configured and update to the new variable names.

5. :x: The `app/Console/Kernel.php` file has been removed in Laravel 11. Shift [overwrote your file]({#commit:ccae4908b578e4ec90a7cf12fabcb20956d889db}), but detected it may have contained customizations. You should review the diff to see if any of your customizations are still needed. If so, you may re-apply them to the `routes/console.php` file or the new `bootstrap/app.php` file. [Review the documentation](https://laravel.com/docs/11.x/artisan#registering-commands) for additional details.

6. :information_source: Shift [updated your dependencies]({#commit:1d0c847ad803f7d9e8845e78c7baa53caa3913aa}) for Laravel 11. While many of the popular packages are reviewed, you may have to update additional packages in order for your application to be compatible with Laravel 11. Watch [dealing with dependencies](https://laravelshift.com/videos/update-incompatible-composer-dependencies) for tips on handling any Composer issues.

The following dependencies were updated by a major version and may have their own changes. You may check their changelog for any additional upgrade steps.

- [ ] [laravel/sanctum](https://packagist.org/packages/laravel/sanctum)

7. :information_source: The base `Controller` class has been marked as `abstract` in Laravel 11, with its traits and inheritance removed. This is to prevent using this base controller directly and to use facades instead of the trait methods.

Shift detected your base controller did not have any public methods, so it was safe to mark as `abstract`. However, since you may be using trait methods within your controllers, Shift did not remove them. If you know you are not using any trait methods or want to refactor to facades, you may remove them manually.

8. :warning: Many first-party Laravel packages no longer load their migrations automatically. Instead, you may need to publish their migrations to your application if you have not already done so. Shift detected you are using Sanctum. You may run the following command to publish their migrations:

```sh
php artisan vendor:publish --tag=sanctum-migrations
```

9. :information_source: Laravel 11 now updates the timestamp when publishing vendor migrations. This may cause problems in existing applications when these migrations were previously published and ran with their default timestamp.

To preserve the original behavior, Shift disabled this feature in your `database.php` configuration file. If you do not have any vendor migrations or have squashed all of your existing migrations, you may re-enable the `update_date_on_publish` option. If this is the only customization within `database.php`, you may remove this configuration file.

10. :information_source: The following files previously included in a Laravel application appeared to be customized and were not removed. Shift encourages you to review your customizations to see if they are still needed or may be done elsewhere in a modern Laravel application. Removing these files will keep your application modern and make future maintenance easier.

- [ ] app/Http/Middleware/PreventRequestsDuringMaintenance.php
- [ ] app/Http/Middleware/TrimStrings.php
- [ ] app/Http/Middleware/TrustHosts.php
- [ ] app/Http/Middleware/TrustProxies.php
- [ ] app/Http/Middleware/ValidateSignature.php

11. :warning: Previously, Laravel would append a colon (`:`) to any cache key prefix for DynamoDB, Memcache, or Redis. Laravel 11 no longer appends a colon to your cache key prefix. If you are using one of these stores, you should append a colon to your prefix to avoid invalidating your cache.

12. :warning: Many of the default drivers changed in Laravel 11. For example, the default database driver is `sqlite` and the default cache store is `database`. If you experience errors setting up your environment, be sure you have properly set your `ENV` variables for these drivers. If you wish to adopt the new defaults, you may follow the documentation to set them up for your application.

13. :warning: Laravel 11 requires PHP 8.2 or higher. You should verify the PHP version in your environments to ensure it meets this new requirement.

14. :warning: Laravel 11 now includes a database driver for MariaDB. Previously the MySQL driver offered parity with MariaDB. However, with MariaDB 10.1, there are more database specific features available. If you are using MariaDB, you may want to evaluate this new `mariadb` driver after completing your upgrade to Laravel 11.

15. :tada: Congratulations, you're now running the latest version of Laravel!

Next, you may optionally run the following _Shifts_ to ensure your application is fully upgraded, adopts the latest Laravel conventions, and easier to maintain in the future:

- [Laravel Fixer](https://laravelshift.com/laravel-code-fixer) automatically updates your code to the latest Laravel conventions.
- [Tests Generator](https://laravelshift.com/laravel-test-generator) intelligently generates model factories, HTTP Tests, and configuration for your application.
- [CI Generator](https://laravelshift.com/ci-generator) intelligently generates CI jobs to lint PHP, check code style, and run tests, including Dusk.

You may also use the [Shift Workbench](https://laravelshift.com/workbench) to automate common tasks for maintaining your Laravel application.