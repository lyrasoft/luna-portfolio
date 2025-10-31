# LYRASOFT Portfolio Package

![p-001-2021-11-23-03-08-34](https://user-images.githubusercontent.com/1639206/142921320-b0f9f2b5-9460-4b95-8fd0-df9762a13b82.jpg)

## Installation

Install from composer

```shell
composer require lyrasoft/portfolio
```

Then copy files to project

```shell
php windwalker pkg:install lyrasoft/portfolio -t routes -t migrations -t seeders
```

Seeders

- Add `portfolio.seeder.php` to `resources/seeders/main.seeder.php`
- Package will auto add categories to seeders
- If you want to modify categories, edit `seeders/categories/portfolio.categories.php`

### Languages

Add this line to admin & front middleware:

```php
$this->lang->loadAllFromVendor(\Lyrasoft\Portfolio\PortfolioPackage::class, 'ini');
```

If you want to copy language files, Run this command:

```shell
php windwalker pkg:install lyrasoft/portfolio -t lang
```

## Register Admin Menu

Edit `resources/menu/admin/sidemenu.menu.php`

```php
// Category
$menu->link('作品分類')
    ->to($nav->to('category_list', ['type' => 'portfolio']))
    ->icon('fal fa-sitemap');

// Portfolio
$menu->link('作品管理')
    ->to($nav->to('portfolio_list'))
    ->icon('fal fa-images');
```
