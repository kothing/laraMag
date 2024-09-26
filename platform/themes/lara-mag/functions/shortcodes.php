<?php

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Gallery\Facades\Gallery;
use Botble\Shortcode\Compilers\Shortcode;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Supports\ThemeSupport;

app()->booted(function () {
    ThemeSupport::registerGoogleMapsShortcode();
    ThemeSupport::registerYoutubeShortcode();

    if (is_plugin_active('blog')) {
        add_shortcode('featured-posts', __('Featured posts'), __('Featured posts'), function (Shortcode $shortcode) {
            return Theme::partial('short-codes.featured-posts', compact('shortcode'));
        });

        shortcode()->setAdminConfig('featured-posts', function (array $attributes) {
            return Theme::partial('short-codes.featured-posts-admin-config', compact('attributes'));
        });

        add_shortcode('category-posts', __('Category posts'), __('Category posts'), function () {
            $categories = get_all_categories([
                'categories.status' => BaseStatusEnum::PUBLISHED,
                'categories.parent_id' => 0,
                'is_featured' => 1,
            ]);

            return Theme::partial('short-codes.category-posts', compact('categories'));
        });

        add_shortcode(
            'featured-posts-slider',
            __('Featured posts slider'),
            __('Featured posts slider'),
            function (Shortcode $shortcode) {
                $posts = get_featured_posts($shortcode->limit ? (int) $shortcode->limit : 5);

                $version = '1.0.1';
                $dist = asset('vendor/core/plugins/simple-slider');

                Theme::asset()
                    ->container('footer')
                    ->usePath(false)
                    ->add(
                        'simple-slider-owl-carousel-css',
                        $dist . '/libraries/owl-carousel/owl.carousel.css',
                        [],
                        [],
                        $version
                    )
                    ->add('simple-slider-css', $dist . '/css/simple-slider.css', [], [], $version)
                    ->add(
                        'simple-slider-owl-carousel-js',
                        $dist . '/libraries/owl-carousel/owl.carousel.js',
                        ['jquery'],
                        [],
                        $version
                    )
                    ->add('simple-slider-js', $dist . '/js/simple-slider.js', ['jquery'], [], $version);

                return Theme::partial('short-codes.featured-posts-slider', compact('posts'));
            }
        );

        shortcode()->setAdminConfig('featured-posts-slider', function (array $attributes) {
            return Theme::partial('short-codes.featured-posts-slider-admin-config', compact('attributes', 'content'));
        });
    }

    if (is_plugin_active('gallery')) {
        add_shortcode('all-galleries', __('All Galleries'), __('All Galleries'), function (Shortcode $shortcode) {
            Gallery::registerAssets();

            $galleries = get_galleries((int) $shortcode->limit ?: 8);

            return Theme::partial('short-codes.all-galleries', compact('galleries'));
        });

        shortcode()->setAdminConfig('all-galleries', function (array $attributes) {
            return Theme::partial('short-codes.all-galleries-admin-config', compact('attributes'));
        });
    }

    if (is_plugin_active('simple-slider')) {
        add_filter(SIMPLE_SLIDER_VIEW_TEMPLATE, function () {
            return Theme::getThemeNamespace() . '::partials.short-codes.sliders';
        }, 120);
    }
});
