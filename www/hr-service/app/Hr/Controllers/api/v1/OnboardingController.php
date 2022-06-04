<?php

namespace App\Hr\Controllers\api\v1;

use App\Hr\Controllers\api\ApiController;
use App\Hr\Models\Astrological;
use App\Hr\Models\BodyStyle;
use App\Hr\Models\ConsumptionType;
use App\Hr\Models\Degree;
use App\Hr\Models\Ethnicity;
use App\Hr\Models\EyeColor;
use App\Hr\Models\HairColor;
use App\Hr\Models\MaritalStatus;
use App\Hr\Models\Religion;

final class OnboardingController extends ApiController
{
    public function indexBodyStyle()
    {
        return $this->respond(BodyStyle::all());
    }

    public function indexDegree()
    {
        return $this->respond(Degree::all());
    }

    public function indexAstrologicalSign()
    {
        return $this->respond(Astrological::all());
    }

    public function indexEyeColor()
    {
        return $this->respond(EyeColor::all());
    }

    public function indexHairColor()
    {
        return $this->respond(HairColor::all());
    }

    public function indexReligion()
    {
        return $this->respond(Religion::all());
    }

    public function indexEthnicity()
    {
        return $this->respond(Ethnicity::all());
    }

    public function indexMaritalStatus()
    {
        return $this->respond(MaritalStatus::all());
    }

    public function indexConsumptionType()
    {
        return $this->respond(ConsumptionType::all());
    }
}
