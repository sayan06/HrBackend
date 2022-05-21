<?php

namespace App\Hr\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class BaseModel extends Model
{
    public const FILTERABLES = [];

    protected $rules = [];
    protected $errors;
    protected $additionalRules;

    public function validate($data)
    {
        $validator = Validator::make($data, $this->rules);
        $additionalRulesPassed = true;

        foreach ($this->additionalRules as $key => $value) {
            if ($additionalRulesPassed) {
                $additionalRulesPassed = call_user_func_array([$this, $value], [$validator, $data]);
            }
            call_user_func_array([$this, $value], [$validator, $data]);
        }

        if (!$additionalRulesPassed) {
            $this->errors = $validator->errors();

            return false;
        }

        if ($validator->fails()) {
            $this->errors = $validator->errors();

            return false;
        }

        return true;
    }

    public function errors()
    {
        return $this->errors;
    }

    /**
     * Wrapper for Eloquent firstOrCreate with logic to ignore duplicate key
     * DB errors resulting from race conditions.
     *
     * @param  array  $attributes The attributes to search on and insert.
     * @param  array  $values The additional attributes to insert only.
     * @return Model
     */
    public static function firstOrInsert(array $attributes, array $values = null)
    {
        try {
            return is_null($values)
                ? parent::firstOrCreate($attributes)
                : parent::firstOrCreate($attributes, $values);
        } catch (QueryException $ex) {
            if (self::causedByDuplicateKey($ex)) {
                return parent::where($attributes)->first();
            }
            throw $ex;
        }
    }
}
