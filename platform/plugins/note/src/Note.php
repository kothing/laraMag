<?php

namespace Botble\Note;

use Botble\Base\Models\BaseModel;
use Botble\Note\Repositories\Interfaces\NoteInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Note
{
    public function __construct(protected NoteInterface $noteRepository)
    {
    }

    public function registerModule(array|string $model): self
    {
        if (! is_array($model)) {
            $model = [$model];
        }

        config([
            'plugins.note.general.supported' => array_merge(config('plugins.note.general.supported', []), $model),
        ]);

        return $this;
    }

    public function saveNote(Request $request, Model|null|bool $object): void
    {
        if (in_array(get_class($object), config('plugins.note.general.supported', [])) && $request->input('note')) {
            $note = $this->noteRepository->getModel();
            $note->note = $request->input('note');
            $note->user_id = Auth::id();
            $note->created_by = Auth::id();
            $note->reference_type = get_class($object);
            $note->reference_id = $object->id;
            $this->noteRepository->createOrUpdate($note);
        }
    }

    public function deleteNote(Model|null|false $data): bool
    {
        if ($data instanceof BaseModel) {
            $this->noteRepository->deleteBy([
                'reference_id' => $data->id,
                'reference_type' => get_class($data),
            ]);

            return true;
        }

        return false;
    }
}
