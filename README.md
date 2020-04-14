Yii 2 Advanced Project Template
===============================

Install Yii
-------------------

Download composer.phar to the root of project

```
php init

php composer.phar global require "fxp/composer-asset-plugin" --no-plugins

php composer.phar update
```


File /common/config/main-local.php

* set DB configuration
* set site domain

```
    'aliases' => [
        '@base' => 'http://my-domain.com',
    ],
```

Run migrations
```
php yii migrate
```

Create of admin User from console
```
php yii user/add "email" "password" "Full Name"
```

Parse i18n messages
```
php yii message/extract backend/messages/config.php 

```