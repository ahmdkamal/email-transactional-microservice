<?php

namespace App\Repositories\Interfaces;

use App\Models\Email;

interface InterfaceEmailRepository
{
    /**
     * @param Email $email
     * @return bool
     */
    public function save(Email $email): bool;

    /**
     * @param int $id
     * @return Email
     */
    public function findById(int $id): Email;
}
