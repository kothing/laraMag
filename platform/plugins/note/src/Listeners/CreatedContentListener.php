<?php

namespace Botble\Note\Listeners;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Note\Facades\Note;
use Exception;

class CreatedContentListener
{
    public function handle(CreatedContentEvent $event): void
    {
        try {
            Note::saveNote($event->request, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
