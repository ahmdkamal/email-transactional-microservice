<?php

namespace App\Repositories;

use App\Models\Email;
use App\Repositories\Interfaces\InterfaceEmailRepository;

class EmailRepository implements InterfaceEmailRepository
{
    /**
     * @param Email $email
     * @return bool
     */
    public function save(Email $email): bool
    {
        return $email->save();
    }

    /**
     * @param int $id
     * @return Email
     */
    public function findById(int $id): Email
    {
        return Email::query()->findOrFail($id);
    }
}
