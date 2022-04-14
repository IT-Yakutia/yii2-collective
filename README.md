Collective service for yii2
=====================
Collective server for yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```sh
php composer.phar require --prefer-dist it-yakutia/yii2-collective "*"
```

or add

```json
"it-yakutia/yii2-collective": "*"
```

to the require section of your `composer.json` file.

Add migration path in your console config file:

```php
'controllerMap' => [
    ...
    'migration' => [
        ...
        'migrationPath' => [
            ...
            '@vendor/it-yakutia/collective/src/migrations',
            ...
        ],
    ]
]
```

Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= Url::toRoute(['/collective/back/index']); ?>
```

Add RBAC roles:

```
collective
```

Custom view file:

```php
'custom_view_for_modules' => [
    'collective_front' => [
        'index' => '@frontend/views/front_page/index',
        '_item' => '@frontend/views/front_page/_item',
        'view' => '@frontend/views/front_page/view',
    ],
],
```

```php
<?= Url::toRoute(['/collective/front/index']); ?>
```