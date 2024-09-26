<?php

namespace Botble\Note\Providers;

use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Blog\Models\Post;
use Botble\Note\Facades\Note as NoteFacade;
use Botble\Note\Models\Note;
use Botble\Note\Repositories\Caches\NoteCacheDecorator;
use Botble\Note\Repositories\Eloquent\NoteRepository;
use Botble\Note\Repositories\Interfaces\NoteInterface;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

/**
 * @since 07/02/2016 09:50 AM
 */
class NoteServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(NoteInterface::class, function () {
            return new NoteCacheDecorator(new NoteRepository(new Note()));
        });

        AliasLoader::getInstance()->alias('Note', NoteFacade::class);
    }

    public function boot(): void
    {
        $this->setNamespace('plugins/note')
            ->loadHelpers()
            ->loadAndPublishViews()
            ->loadAndPublishConfigurations(['general'])
            ->loadMigrations();

        $this->app->register(EventServiceProvider::class);

        $this->app->booted(function () {
            if (is_plugin_active('blog')) {
                NoteFacade::registerModule(Post::class);
            }

            $this->app->register(HookServiceProvider::class);
        });
    }
}
