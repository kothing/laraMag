<?php

namespace Botble\Note\Listeners;

use Botble\Base\Events\DeletedContentEvent;
use Botble\Note\Facades\Note;
use Exception;

class DeletedContentListener
{
    public function handle(DeletedContentEvent $event): void
    {
        try {
            Note::deleteNote($event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
