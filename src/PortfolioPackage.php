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
        // Admin + Front + Model
        $installer->installMVCModules(Portfolio::class);
        // Admin + Front, no model
        $installer->installMVCModules(Portfolio::class, model: false);
        // Only Admin + Model
        $installer->installMVCModules(Portfolio::class, ['Admin'], true);
    }
}
