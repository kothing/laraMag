<?php

namespace Botble\Note\Facades;

use Botble\Note\Note as BaseNote;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Botble\Note\Note registerModule(array|string $model)
 * @method static void saveNote(\Illuminate\Http\Request $request, \Illuminate\Database\Eloquent\Model|bool|null $object)
 * @method static bool deleteNote(\Illuminate\Database\Eloquent\Model|false|null $data)
 *
 * @see \Botble\Note\Note
 */
class Note extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return BaseNote::class;
    }
}
