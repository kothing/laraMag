<?php

namespace Botble\Note\Repositories\Caches;

use Botble\Note\Repositories\Interfaces\NoteInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class NoteCacheDecorator extends CacheAbstractDecorator implements NoteInterface
{
}
