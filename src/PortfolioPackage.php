<?php

/**
 * Part of eva project.
 *
 * @copyright  Copyright (C) 2021 __ORGANIZATION__.
 * @license    MIT
 */

declare(strict_types=1);

namespace Lyrasoft\Portfolio;

use Windwalker\Core\Package\AbstractPackage;
use Windwalker\Core\Package\PackageInstaller;

/**
 * The PortfolioPackage class.
 */
class PortfolioPackage extends AbstractPackage
{
    public function install(PackageInstaller $installer): void
    {
        $installer->installConfig(static::path('etc/*.php'), 'config');
        $installer->installLanguages(static::path('resources/languages/**/*.ini'), 'lang');
        $installer->installMigrations(static::path('resources/migrations/**/*'), 'migrations');
        $installer->installSeeders(static::path('resources/seeders/**/*'), 'seeders');
        $installer->installRoutes(static::path('routes/**/*.php'), 'routes');

        // Modules
        $installer->installModules(
            [
                static::path("src/Module/Admin/Portfolio/**/*") => "@source/Module/Admin/Portfolio",
            ],
            ['Lyrasoft\\Portfolio\\Module\\Admin' => 'App\\Module\\Admin'],
            ['modules', 'portfolio_admin'],
        );

        $installer->installModules(
            [
                static::path("src/Module/Front/Portfolio/**/*") => "@source/Module/Front/Portfolio",
            ],
            ['Lyrasoft\\Portfolio\\Module\\Front' => 'App\\Module\\Front'],
            ['modules', 'portfolio_front'],
        );

        $installer->installModules(
            [
                static::path("src/Entity/Portfolio.php") => '@source/Entity',
                static::path("src/Repository/PortfolioRepository.php") => '@source/Repository',
            ],
            [
                'Lyrasoft\\Portfolio\\Entity' => 'App\\Entity',
                'Lyrasoft\\Portfolio\\Repository' => 'App\\Repository',
            ],
            ['modules', 'portfolio_model']
        );
    }
}
