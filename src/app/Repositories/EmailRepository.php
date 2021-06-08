<?php

namespace App\Repositories;

use App\Models\Email;
use App\Repositories\Interfaces\InterfaceEmailRepository;

class EmailRepository implements InterfaceEmailRepository
{
    public function save(Email $email): bool
    {
        return $email->save();
    }

    public function findById(int $id): Email
    {
        return Email::query()->findOrFail($id);
    }
}
