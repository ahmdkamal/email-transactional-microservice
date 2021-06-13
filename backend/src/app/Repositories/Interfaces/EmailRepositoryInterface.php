<?php

namespace App\Repositories\Interfaces;

use App\Models\Email;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface EmailRepositoryInterface
{
    public function index($perPage = 15): LengthAwarePaginator;

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
