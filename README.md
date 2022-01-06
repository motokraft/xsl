## Генерация шаблонов XSLT для XML документа

![Package version](https://img.shields.io/github/v/release/motokraft/xsl)
![Total Downloads](https://img.shields.io/packagist/dt/motokraft/xsl)
![PHP Version](https://img.shields.io/packagist/php-v/motokraft/xsl)
![Repository Size](https://img.shields.io/github/repo-size/motokraft/xsl)
![License](https://img.shields.io/packagist/l/motokraft/xsl)

## Установка

Библиотека устанавливается с помощью пакетного менеджера [**Composer**](https://getcomposer.org/)

Добавьте библиотеку в файл `composer.json` вашего проекта:

```json
{
    "require": {
        "motokraft/xsl": "^1.0.0"
    }
}
```

или выполните команду в терминале

```
$ php composer require motokraft/xsl
```

Включите автозагрузчик Composer в код проекта:

```php
require __DIR__ . '/vendor/autoload.php';
```

## Примеры инициализации

```php
use \Motokraft\Xsl\Xsl;

$xsl = new Xsl('demo', '2.0');

// или
$xsl = Xsl::getInstance('demo-1');
```

## Лицензия

Эта библиотека находится под лицензией MIT License.