<?php

namespace App\Hr\Services\Contracts;

use App\Hr\Models\Party;
use Illuminate\Support\Collection;

interface PartyServiceInterface
{
    public function deletePartyItems(Party $party, Collection $itemVariants): Party;

    public function addPartyItems(Party $party, array $itemVariantPrices): Party;

    public function deleteParty(Party $party);

    public function validatePartyItems(Party $party, array $attributes);

    public function validateAssociatedPartyItems(Party $party, Collection $itemVariants);
}
