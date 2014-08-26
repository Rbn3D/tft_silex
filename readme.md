TFT Silex site
=========

Pre-requisites:
---

* php5_curl
* php5_mysql

Project setup:
---
   
tft_silex folder should be a subfolder of your root www folder (otherwise, you will have to manually modify the .htaccess files)

Composer

> ```sh
composer.phar update
```

settings.yml file

> You will have to copy _settings.dist.yml_ to _seetings.yml_ and set the correct values for your configuration

After that, the site should be up.

Disqus configuration
---

You will needed to create a Disqus Application (if you don't have one alerady) and set the values in settings.yml as explained abobe.

It's also important to configure the application callbacks in your Disqus Application configuration page:

* Callback URL should point to ``` www.yourdomain.example/tft_silex/web/disqus/as_callback ```
* Terms of Service URL should point to ``` www.yourdomain.example/tft_silex/web/disqus/as_callback/tos ```

Command line interface
---

Create databse schema
> ```sh
php app/console schema create
```

Truncate data in schema
> ```sh
php app/console schema truncate
```

Drop schema (without actually deleting the databse or other tables)
> ```sh
php app/console schema drop
```