<?php

/**
 * Part of starter project.
 *
 * @copyright  Copyright (C) 2021 __ORGANIZATION__.
 * @license    MIT
 */

declare(strict_types=1);

namespace Lyrasoft\Portfolio\Module\Front\Portfolio;

use Lyrasoft\Portfolio\Entity\Portfolio;
use Lyrasoft\Portfolio\Repository\PortfolioRepository;
use Lyrasoft\Luna\Entity\Category;
use Lyrasoft\Luna\Repository\CategoryRepository;
use Unicorn\Enum\BasicState;
use Windwalker\Core\Application\AppContext;
use Windwalker\Core\Attributes\ViewMetadata;
use Windwalker\Core\Attributes\ViewModel;
use Windwalker\Core\Html\HtmlFrame;
use Windwalker\Core\Router\Exception\RouteNotFoundException;
use Windwalker\Core\Router\Navigator;
use Windwalker\Core\View\View;
use Windwalker\Core\View\ViewModelInterface;
use Windwalker\DI\Attributes\Autowire;

use function Windwalker\collect;
use function Windwalker\str;

/**
 * The PortfolioItemView class.
 */
#[ViewModel(
    layout: 'portfolio-item',
    js: 'portfolio-item.js'
)]
class PortfolioItemView implements ViewModelInterface
{
    /**
     * Constructor.
     */
    public function __construct(
        #[Autowire]
        protected PortfolioRepository $repository,
        #[Autowire]
        protected CategoryRepository $categoryRepository,
        protected Navigator $nav
    ) {
        //
    }

    /**
     * Prepare View.
     *
     * @param  AppContext  $app   The web app context.
     * @param  View        $view  The view object.
     *
     * @return  mixed
     */
    public function prepare(AppContext $app, View $view): mixed
    {
        $id = $app->input('id');
        $alias = $app->input('alias');

        /** @var Portfolio $item */
        $item = $this->repository->getItem($id);

        if (!$item || $item->state === BasicState::UNPUBLISHED) {
            throw new RouteNotFoundException('Item not found.');
        }

        $view[$item::class] = $item;

        /** @var Category $category */
        $category = $this->categoryRepository->mustGetItem($item->categoryId);

        if ($category->state === BasicState::UNPUBLISHED) {
            throw new RouteNotFoundException('Category not published.');
        }

        // Keep URL unique
        if ($item->alias !== $alias) {
            return $this->nav->self()->alias($item->alias);
        }

        return compact(
            'item',
            'category'
        );
    }

    #[ViewMetadata]
    public function prepareMetadata(HtmlFrame $htmlFrame, Portfolio $item): void
    {
        $meta = $item->meta;

        $htmlFrame->setTitle($meta->title ?: $item->title);

        $htmlFrame->setCoverImagesIfNotEmpty($meta->cover);
        $htmlFrame->setCoverImagesIfNotEmpty($item->cover);

        $htmlFrame->setDescriptionIfNotEmpty($item->description, 200);
        $htmlFrame->setDescriptionIfNotEmpty($meta->description);

        if ($meta->keywords) {
            $htmlFrame->addMetadata('keywords', (string) $meta->keywords);
        }
    }
}
