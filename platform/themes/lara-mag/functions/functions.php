<?php

use Botble\Ads\Facades\AdsManager;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\TextField;
use Botble\Blog\Forms\PostForm;
use Botble\Blog\Supports\PostFormat;
use Botble\Media\Facades\RvMedia;
use Botble\Menu\Facades\Menu;
use Botble\Theme\Supports\ThemeSupport;

app()->booted(function () {
    ThemeSupport::registerToastNotification();
    ThemeSupport::registerPreloader();
    ThemeSupport::registerSocialSharing();

    register_page_template([
        'homepage' => __('Homepage'),
    ]);

    register_sidebar([
        'id' => 'footer_sidebar',
        'name' => __('Footer sidebar'),
        'description' => __('Area for footer widgets'),
    ]);

    Menu::addMenuLocation('second-menu', __('Second menu'))
        ->addMenuLocation('header-menu', __('Header Navigation'));

    RvMedia::addSize('featured', 560, 380)
        ->addSize('medium', 540, 360);

    if (is_plugin_active('blog')) {
        PostFormat::registerPostFormat([
            'video' => [
                'key' => 'video',
                'icon' => 'fa fa-camera',
                'name' => __('Video'),
            ],
        ]);

        PostForm::extend(function (PostForm $form) {
            return $form
                ->addAfter(
                    'content',
                    'video_link',
                    TextField::class,
                    TextFieldOption::make()
                        ->label(__('YouTube Video URL'))
                        ->placeholder('Ex: https://www.youtube.com/watch?v=FN7ALfpGxiI')
                        ->metadata()
                        ->toArray()
                );
        });
    }

    if (is_plugin_active('ads')) {
        AdsManager::registerLocation('header', 'Header')
            ->registerLocation('top-sidebar', 'Top sidebar')
            ->registerLocation('bottom-sidebar', 'Bottom sidebar')
            ->registerLocation('top-single-page', 'Top single page')
            ->registerLocation('bottom-single-page', 'Bottom single page')
            ->registerLocation('before-featured-posts', 'Before featured posts')
            ->registerLocation('after-featured-posts', 'After featured posts')
            ->registerLocation('before-category-posts', 'Before category posts')
            ->registerLocation('after-category-posts', 'After category posts')
            ->registerLocation('before-galleries', 'Before galleries')
            ->registerLocation('after-galleries', 'After galleries');
    }
});
