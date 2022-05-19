<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\PickSheet;
use App\Hr\Models\User;

interface PickSheetServiceInterface
{
    public function create(User $user, array $pickSheetData): PickSheet;
    public function update(PickSheet $pickSheet, User $user, array $pickSheetData): PickSheet;
}
