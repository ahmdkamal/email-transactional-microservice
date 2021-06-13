<?php

namespace App\Repositories;

use App\Models\Email;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EmailRepository implements EmailRepositoryInterface
{
    /**
     * EmailRepository constructor.
     * @param Email $emailModel
     */
    public function __construct(protected Email $emailModel)
    {
    }

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function index($perPage = 15): LengthAwarePaginator
    {
        return $this->emailModel->query()->paginate($perPage);
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
        return $this->emailModel->query()->findOrFail($id);
    }
}
