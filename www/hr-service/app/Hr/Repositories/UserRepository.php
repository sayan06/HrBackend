<?php

namespace App\Hr\Repositories;

use App\Hr\DataTransferObjects\SortableDto;
use App\Hr\Models\User;
use App\Hr\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getMany(SortableDto $sortableDto, int $pageLimit = 15): LengthAwarePaginator
    {
        return User::orderBy($sortableDto->getColumn(), $sortableDto->getOrder())->paginate($pageLimit);
    }

    public function updateOne(User $user, array $attributes): User
    {
        $user->name = !empty($attributes['name']) ? $attributes['name'] : $user->name;
        $user->phone = !empty($attributes['phone']) ? $attributes['phone'] : $user->phone;
        $user->title = !empty($attributes['title']) ? $attributes['title'] : $user->title;
        $user->email = !empty($attributes['email']) ? $attributes['email'] : $user->email;
        $user->disabled_at = !empty($attributes['disabled']) ? time() : null;
        $user->password = !empty($attributes['password']) ? bcrypt($attributes['password']) : $user->password;

        $user->save();

        return $user;
    }

    public function createOne(array $attributes): User
    {
        $user = new User;
        $user->name = data_get($attributes, 'name');
        $user->email = data_get($attributes, 'email');
        $user->password = bcrypt(data_get($attributes, 'password'));
        $user->title = data_get($attributes, 'title');
        $user->phone = data_get($attributes, 'phone');

        $user->save();

        return $user;
    }
}
