<?php

namespace Botble\Note\Providers;

use Botble\Note\Repositories\Interfaces\NoteInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_filter(BASE_FILTER_REGISTER_CONTENT_TABS, [$this, 'addNoteTab'], 50, 2);
        add_filter(BASE_FILTER_REGISTER_CONTENT_TAB_INSIDE, [$this, 'addNoteContent'], 50, 3);
    }

    public function addNoteTab(?string $tabs, ?Model $data): ?string
    {
        if ($this->isSupported($data)) {
            return $tabs . view('plugins/note::tab')->render();
        }

        return $tabs;
    }

    protected function isSupported(?Model $model): bool
    {
        if (! $model) {
            return false;
        }

        return in_array(get_class($model), config('plugins.note.general.supported', []));
    }

    public function addNoteContent(?string $tabs, ?Model $data = null): ?string
    {
        if ($this->isSupported($data)) {
            $notes = [];
            if (! empty($data)) {
                $notes = $this->app->make(NoteInterface::class)->allBy([
                    'reference_id' => $data->getKey(),
                    'reference_type' => get_class($data),
                ]);
            }

            return $tabs . view('plugins/note::content', compact('notes'))->render();
        }

        return $tabs;
    }
}
