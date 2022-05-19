<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\Bom;

interface BomItemServiceInterface
{
    public function deleteBom(Bom $bom): Bom;
}
