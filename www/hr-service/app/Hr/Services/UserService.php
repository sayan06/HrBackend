<?php

namespace App\Hr\Services;

use App\Hr\Models\Likability;
use App\Hr\Models\Role;
use App\Hr\Models\User;
use App\Hr\Models\UserFlavour;
use App\Hr\Models\UserIdealMatch;
use App\Hr\Models\UserInformation;
use App\Hr\Models\UserInterest;
use App\Hr\Models\UserLanguage;
use App\Hr\Models\UserPersonality;
use App\Hr\Models\UserQuestionAnswer;
use App\Hr\Repositories\Contracts\UserRepositoryInterface;
use App\Hr\Services\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Throwable;

final class UserService implements UserServiceInterface
{
    private $userRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
    ) {
        $this->userRepo = $userRepo;
    }

    public function createUser(array $attributes): User
    {
        try {
            DB::beginTransaction();

            $user = $this->userRepo->createOne($attributes);
            $roleId = data_get($attributes, 'role_id');

            if (empty($roleId)) {
                $roleId = Role::where('name', Role::ROLE_NAME_GUEST)->pluck('id')->first();
            }

            $this->assignRole($user, Role::find($roleId));

            DB::commit();

            return $user;
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function assignRole(User $user, Role $role): User
    {
        $user->syncRoles($role->name);

        return $user;
    }

    public function createAuthToken(User $user): string
    {
        return $user->createToken('roles', $user->roles->pluck('name')->toArray())->plainTextToken;
    }

    public function refreshAuthToken(User $user): string
    {
        $user->tokens()->delete();

        return $this->createAuthToken($user);
    }

    public function createUserDetails(User $user, array $attributes = [])
    {
        $personalityTypes = data_get($attributes, 'personality_types');
        $idealMatches = data_get($attributes, 'ideal_matches');
        $interests = data_get($attributes, 'interests');
        $languages = data_get($attributes, 'languages');
        $questions = data_get($attributes, 'questions_answers');
        $flavours = data_get($attributes, 'flavours');

        $userInformation = [
            'country' => data_get($attributes, 'country'),
            'city' => data_get($attributes, 'city'),
            'dob' => data_get($attributes, 'dob'),
            'height_feet' => data_get($attributes, 'height_feet'),
            'height_inch' => data_get($attributes, 'height_inch'),
            'about' => data_get($attributes, 'about'),
            'job_title' => data_get($attributes, 'job_title'),
            'company_name' => data_get($attributes, 'company_name'),
            'college_name' => data_get($attributes, 'college_name'),
            'high_school_name' => data_get($attributes, 'high_school_name'),
            'degree_id' => data_get($attributes, 'degree_id'),
            'ethnicity_id' => data_get($attributes, 'ethnicity_id'),
            'eye_color_id'  => data_get($attributes, 'eye_color_id'),
            'alcohol_consumption_type_id' => data_get($attributes, 'alcohol_consumption_type_id'),
            'religion_id' => data_get($attributes, 'religion_id'),
            'astrological_sign_id' => data_get($attributes, 'astrological_sign_id'),
            'body_style_id' => data_get($attributes, 'body_style_id'),
            'marital_status_id' => data_get($attributes, 'marital_status_id'),
            'smoker' => data_get($attributes, 'smoker'),
            'kids' =>data_get($attributes, 'kids'),
            'kids_requirement_type_id' => data_get($attributes, 'kids_requirement_type_id'),
            'gender' => data_get($attributes, 'gender'),
            'hair_color' => data_get($attributes, 'hair_color'),
            'is_hidden' => data_get($attributes, 'is_hidden'),
            'steps' => data_get($attributes, 'steps'),
            'user_id' => $user->id,
        ];

        if (!empty($idealMatches)) {
            $idealMatchData = [];
            foreach ($idealMatches as $idealMatch) {
                $idealMatchData [] = [
                    'ideal_match_id' => $idealMatch,
                    'user_id' => $user->id,
                ];
            }
        }

        if (!empty($personalityTypes)) {
            $personalityTypeData = [];
            foreach ($personalityTypes as $personalityType) {
                $personalityTypeData [] = [
                    'personality_type_id' => $personalityType,
                    'user_id' => $user->id,
                ];
            }
        }

        if (!empty($interests)) {
            $interestData = [];
            foreach ($interests as $interest) {
                $interestData [] = [
                    'interest_id' => $interest,
                    'user_id' => $user->id,
                ];
            }
        }

        if (!empty($languages)) {
            $languageData = [];
            foreach ($languages as $language) {
                $languageData [] = [
                    'language_id' => $language,
                    'user_id' => $user->id,
                ];
            }
        }

        if (!empty($questions)) {
            $questionsData = [];
            foreach ($questions as $question) {
                $questionsData [] = [
                    'question_id' => $question->id,
                    'response' => $question->response,
                    'user_id' => $user->id,
                ];
            }
        }

        if (!empty($flavours)) {
            $flavourData = [];
            foreach ($flavours as $flavour) {
                $flavourData [] = [
                    'flavour_id' => $flavour,
                    'user_id' => $user->id,
                ];
            }
        }

        try {
            DB::beginTransaction();

            UserInformation::create($userInformation);

            if(!empty($flavourData)) {
                UserFlavour::where('user_id', $user->id)->delete();
                UserFlavour::insert($flavourData);
            }


            if(!empty($questionsData)) {
                UserQuestionAnswer::where('user_id', $user->id)->delete();
                UserQuestionAnswer::insert($questionsData);
            }

            if(!empty($languageData)) {
                UserLanguage::where('user_id', $user->id)->delete();
                UserLanguage::insert($languageData);
            }

            if(!empty($interestData)) {
                UserInterest::where('user_id', $user->id)->delete();
                UserInterest::insert($interestData);
            }


            if(!empty($personalityTypeData)) {
                UserPersonality::where('user_id', $user->id)->delete();
                UserPersonality::insert($personalityTypeData);
            }

            if(!empty($idealMatchData)) {
                UserIdealMatch::where('user_id', $user->id)->delete();
                UserIdealMatch::insert($idealMatchData);
            }

            DB::commit();

            return $user->load('userInfo');
        } catch (Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }

    public function getLikability(User $user, array $attributes = [])
    {
        $likabilityData = [
            'user_id' => data_get($attributes, 'user_id'),
            'likability' => data_get($attributes, 'likability'),
            'liked_by_id' => $user->id,
        ];

        if ($likabilityData['user_id'] === $likabilityData['liked_by_id']) {
            throw new BadRequestException('User can only like or dislike other active users');
        }

        $alreadyLiked = Likability::where('user_id', $likabilityData['user_id'])->where('liked_by_id', $likabilityData['liked_by_id'])->count();

        if ($alreadyLiked >= 1) {
            Likability::where('user_id', $likabilityData['user_id'])->where('liked_by_id', $likabilityData['liked_by_id'])->delete();
        }

        try {
            DB::beginTransaction();

            Likability::create($likabilityData);

            DB::commit();

            return $user->load('likability');
        } catch (Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }
}
