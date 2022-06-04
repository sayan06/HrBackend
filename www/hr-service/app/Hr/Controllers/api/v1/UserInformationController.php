<?php

namespace App\Hr\Controllers\api\v1;

use App\Hr\Controllers\api\ApiController;
use App\Hr\Models\User;
use App\Hr\Models\UserInformation;
use App\Hr\Repositories\Contracts\UserRepositoryInterface;
use App\Hr\Services\Contracts\UserServiceInterface;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

final class UserInformationController extends ApiController
{
    private $userService;
    private $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserServiceInterface $userService,
    ) {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function onboardUserDetails(User $user, Request $request)
    {
        $request->validate([
            'country' => 'string|max:255',
            'city' => 'string|max:255',
            'dob' => 'required|date_format:Y-m-d',
            'height_feet' => 'required|numeric',
            'height_inch' => 'required|numeric',
            'about' => 'string|max:255',
            'job_title' => 'required|string|max:255',
            'company_name' => 'string|max:255|required_with:job_title',
            'college_name' => 'string|max:255',
            'high_school_name' => 'required|string|max:255',
            'degree' => 'required|int|min:1|max:9999999999|exists:degrees, id',
            'ethnicity' => 'required|int|min:1|max:9999999999|exists:ethnicities, id',
            'eye_color'  => 'required|int|min:1|max:9999999999|exists:eye_colors, id',
            'personality_type' => 'array',
            'personality_type.*.*' => 'int|min:1|max:9999999999|exists:personality_types, id',
            'alcohol_consumption_type' => 'required|int|min:1|max:9999999999|exists:alcohol_consumption_types, id',
            'religion' => 'required|int|min:1|max:9999999999|exists:religions, id',
            'astrological_sign' => 'required|int|min:1|max:9999999999|exists:astrological_signs, id',
            'body_style' => 'required|int|min:1|max:9999999999|exists:body_styles, id',
            'martial_status' => 'required|int|min:1|max:9999999999|exists:statuses, id',
            'smoker' => 'required|boolean',
            'ideal_match' => 'array',
            'ideal_match.*.*' => 'int|min:1|max:9999999999|exists:ideal_matches, id',
            'interests' => 'array',
            'interests.*.*' => 'int|min:1|max:9999999999|exists:interests, id',
            'gender' =>  [
                'required',
                Rule::in([
                    UserInformation::GENDER_FEMALE,
                    UserInformation::GENDER_MALE,
                ]),
            ],
            'hair_colour' => 'int|min:1|max:9999999999|exists:hair_colours,id',
            'languages' => 'array',
            'languages.*.*' => 'int|min:1|max:9999999999|exists:languages,id',
            'questions_answers' => 'array',
            'questions_answers.*.question_id' => 'int|min:1|max:9999999999|exists:questions_answers, id',
            'questions_answers.*.response' => 'string|max:255',

        ]);

        return $this->respondCreated(
            'User information saved successfully!',
            ($this->userService->createUserDetails($user, $request->all()))
        );
    }
}
