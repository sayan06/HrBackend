<?php

namespace App\Hr\Repositories\Contracts;

use App\Hr\DataTransferObjects\SortableDto;
use App\Hr\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    public function getMany(SortableDto $sortableDto, int $pageLimit = 15): LengthAwarePaginator;

    public function createOne(array $attributes): User;

    public function updateOne(User $user, array $attributes): User;
}
