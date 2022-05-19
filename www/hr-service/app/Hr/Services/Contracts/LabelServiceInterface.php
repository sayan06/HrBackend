<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\Label;

interface LabelServiceInterface
{
    public function readLabel(array $entity = []);

    public function deleteLabel(Label $label): Label;

    public function outputLabel(array $details = []);
}
