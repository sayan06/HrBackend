<?php

namespace App\Hr\Controllers\api\v1;

use App\Hr\Controllers\api\ApiController;
use App\Hr\Models\Likability;
use App\Hr\Models\User;
use App\Hr\Models\UserInformation;
use App\Hr\Resources\UserResource;
use App\Hr\Services\Contracts\UserServiceInterface;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

final class UserInformationController extends ApiController
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function onBoardUserDetails(Request $request)
    {
        $request->validate([
            'country' => 'string|max:255',
            'city' => 'string|max:255',
            'dob' => 'int|min:1|max:9999999999',
            'height_feet' => 'numeric',
            'height_inch' => 'numeric',
            'about' => 'string|max:255',
            'job_title' => 'string|max:255',
            'company_name' => 'string|max:255|required_with:job_title',
            'college_name' => 'string|max:255',
            'high_school_name' => 'string|max:255',
            'degree_id' => 'int|min:1|max:9999999999|exists:degrees,id',
            'ethnicity_id' => 'int|min:1|max:9999999999|exists:ethnicities,id',
            'eye_color_id'  => 'int|min:1|max:9999999999|exists:eye_colors,id',
            'personality_types' => 'array',
            'personality_types.*.*' => 'int|min:1|max:9999999999|exists:personality_types,id',
            'alcohol_consumption_type_id' => 'int|min:1|max:9999999999|exists:alcohol_consumptions,id',
            'religion_id' => 'int|min:1|max:9999999999|exists:religions,id',
            'astrological_sign_id' => 'int|min:1|max:9999999999|exists:astrological_signs,id',
            'body_style_id' => 'int|min:1|max:9999999999|exists:body_styles,id',
            'marital_status_id' => 'int|min:1|max:9999999999|exists:marital_statuses,id',
            'smoker' => 'boolean',
            'kids' => 'boolean',
            'kids_requirement_type_id' => 'int|min:1|max:9999999999|exists:kids_requirement_types,id',
            'ideal_matches' => 'array',
            'ideal_matches.*.*' => 'int|min:1|max:9999999999|exists:ideal_matches,id',
            'interests' => 'array',
            'interests.*.*' => 'int|min:1|max:9999999999|exists:interests,id',
            'gender' =>  [
                Rule::in([
                    UserInformation::GENDER_FEMALE,
                    UserInformation::GENDER_MALE,
                ]),
            ],
            'hair_color_id' => 'int|min:1|max:9999999999|exists:hair_colors,id',
            'languages' => 'array',
            'languages.*.*' => 'int|min:1|max:9999999999|exists:languages,id',
            'questions_answers' => 'array',
            'questions_answers.*.question_id' => 'int|min:1|max:9999999999|exists:questions_answers,id',
            'questions_answers.*.response' => 'string|max:255',
            'flavours' => 'array',
            'flavours.*.*' => 'int|min:1|max:9999999999|exists:flavours,id',
            'is_hidden' => 'bool',
            'steps' => 'int',
        ]);

        $user = $request->user();

        return $this->respondCreated(
            'User information saved successfully!',
            ($this->userService->createUserDetails($user, $request->all()))
        );
    }

    public function update(UserInformation $userInfo, Request $request)
    {
        $request->validate([
            'country' => 'string|max:255',
            'city' => 'string|max:255',
            'dob' => 'int|min:1|max:9999999999',
            'height_feet' => 'numeric',
            'height_inches' => 'numeric',
            'about' => 'string|max:255',
            'job_title' => 'string|max:255',
            'company_name' => 'string|max:255|required_with:job_title',
            'college_name' => 'string|max:255',
            'high_school_name' => 'string|max:255',
            'degree_id' => 'int|min:1|max:9999999999|exists:degrees,id',
            'ethnicity_id' => 'int|min:1|max:9999999999|exists:ethnicities,id',
            'eye_color_id'  => 'int|min:1|max:9999999999|exists:eye_colors,id',
            'alcohol_consumption_type_id' => 'int|min:1|max:9999999999|exists:alcohol_consumptions,id',
            'religion_id' => 'int|min:1|max:9999999999|exists:religions,id',
            'astrological_sign_id' => 'int|min:1|max:9999999999|exists:astrological_signs,id',
            'body_style_id' => 'int|min:1|max:9999999999|exists:body_styles,id',
            'marital_status_id' => 'int|min:1|max:9999999999|exists:marital_statuses,id',
            'smoker' => 'boolean',
            'kids' => 'boolean',
            'kids_requirement_type_id' => 'int|min:1|max:9999999999|exists:kids_requirement_types,id',
            'gender' =>  [
                Rule::in([
                    UserInformation::GENDER_FEMALE,
                    UserInformation::GENDER_MALE,
                ]),
            ],
            'hair_color_id' => 'int|min:1|max:9999999999|exists:hair_colors,id',
            'is_hidden' => 'bool',
            'steps' => 'int',
        ]);

        $attributes = $request->all();
        data_set($attributes, 'user_id', $request()->user()->id);

        return $this->respondCreated(
            'User information updated successfully!',
            ($this->userService->updateUserDetails($userInfo, $attributes))
        );
    }

    public function getUserInfo(User $user)
    {
        $user->load('userInfo');

        return $this->respond($user);
    }

    public function likeOrDisLikeUser(Request $request)
    {
        $request->validate([
            'likability' => 'required|bool',
            'user_id' => 'required|int|min:1|max:9999999999|exists:users,id'
        ]);

        return $this->respondSuccess(
            'Likability updated successfully',
            $this->userService->getLikability($request->user(), $request->all())
        );
    }

    public function getLikedDislikedUsers(User $user)
    {
        $likeCount = Likability::where('user_id', $user->id)->where('likability', 1)->count();
        $disLikeCount = Likability::where('user_id', $user->id)->where('likability', 0)->count();

        return $this->respond([
            'user_id' => $user->id,
            'likes' => $likeCount,
            'dislikes' => $disLikeCount,
        ]);
    }

    public function getLikedUsers(User $user)
    {
        $likedUserList = Likability::where('user_id', $user->id)->where('likability', 1)->pluck('liked_by_id');
        $users = User::whereIn('id', $likedUserList)->get();

        return $this->respondSuccess('Liked Users', UserResource::collection($users));
    }

    public function getDisLikedUsers(User $user)
    {
        $likedUserList = Likability::where('user_id', $user->id)->where('likability', 0)->pluck('liked_by_id');

        $users = User::whereIn('id', $likedUserList)->get();

        return $this->respondSuccess('Disliked Users', UserResource::collection($users));
    }
}
