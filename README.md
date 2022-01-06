## ��������� �������� XSLT ��� XML ���������

![Package version](https://img.shields.io/github/v/release/motokraft/xsl)
![Total Downloads](https://img.shields.io/packagist/dt/motokraft/xsl)
![PHP Version](https://img.shields.io/packagist/php-v/motokraft/xsl)
![Repository Size](https://img.shields.io/github/repo-size/motokraft/xsl)
![License](https://img.shields.io/packagist/l/motokraft/xsl)

## ���������

���������� ��������������� � ������� ��������� ��������� [**Composer**](https://getcomposer.org/)

�������� ���������� � ���� `composer.json` ������ �������:

```json
{
    "require": {
        "motokraft/xsl": "^1.0.0"
    }
}
```

��� ��������� ������� � ���������

```
$ php composer require motokraft/xsl
```

�������� ������������� Composer � ��� �������:

```php
require __DIR__ . '/vendor/autoload.php';
```

## ������� �������������

```php
use \Motokraft\Xsl\Xsl;

$xsl = new Xsl('demo', '2.0');

// ���
$xsl = Xsl::getInstance('demo-1');
```

## ��������

��� ���������� ��������� ��� ��������� MIT License.