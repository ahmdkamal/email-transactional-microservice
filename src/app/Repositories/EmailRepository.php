<?php

namespace App\Repositories;

use App\Models\Email;
use App\Repositories\Interfaces\InterfaceEmailRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EmailRepository implements InterfaceEmailRepository
{
    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function index($perPage = 15): LengthAwarePaginator
    {
        return Email::query()->paginate($perPage);
    }

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
