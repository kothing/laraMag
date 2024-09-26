<?php

namespace Botble\Note\Listeners;

use Botble\Base\Events\UpdatedContentEvent;
use Botble\Note\Facades\Note;
use Exception;

class UpdatedContentListener
{
    public function handle(UpdatedContentEvent $event): void
    {
        try {
            Note::saveNote($event->request, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
