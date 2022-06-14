<?php

namespace App\Hr\Repositories;

use App\Hr\Models\IdealMatch;
use App\Hr\Repositories\BaseRepository;
use App\Hr\Repositories\Contracts\IdealMatchRepositoryInterface;

final class IdealmatchRepository extends BaseRepository implements IdealMatchRepositoryInterface
{
    public function __construct(IdealMatch $model)
    {
        $this->model = $model;
    }

    public function createMany(User $user, array $matchData): bool
    {
        $poItems = [];

        foreach ($matchData as $matchDatum) {
            $idealMatches[] = [
                'item_variant_id' => $matchDatum,
                'user_id' => $user->id,
            ];
        }

        return PoItem::insert($poItems);
    }
}
