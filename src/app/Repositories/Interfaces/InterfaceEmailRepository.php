<?php

namespace App\Repositories\Interfaces;

use App\Models\Email;

interface InterfaceEmailRepository
{
    public function save(Email $email): bool;

    public function findById(int $id): Email;
}
