<?php

namespace PasswordRule;

use Illuminate\Contracts\Validation\Rule;

class PasswordRule implements Rule
{
    private $minLength;
    private $camelCase;
    private $numbers;
    private $specialChars;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($minLength = null, $camelCase = null, $numbers = null, $specialChars = null)
    {
        $this->minLength = $minLength ?? config('passwordrule.min_length');
        $this->camelCase = $camelCase ?? config('passwordrule.camel_case');
        $this->numbers = $numbers ?? config('passwordrule.numbers');
        $this->specialChars = $specialChars ?? config('passwordrule.special_chars');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (mb_strlen($value) < $this->minLength) {
            return false;
        }
        if ($this->camelCase && (preg_match("/[a-z]/", $value) !== 1 || preg_match("/[A-Z]/", $value) !== 1)) {
            return false;
        }
        if ($this->numbers && preg_match("/[0-9]/", $value) !== 1) {
            return false;
        }
        if (!empty($this->specialChars)) {
            $quoted = preg_quote($this->specialChars, '/');
            if (preg_match("/[{$quoted}]/", $value) !== 1) {
                return false;
            }
        }

        return true;
    }

    public function getMessageArray()
    {
        $msg = [trans('passwordrule::validation.basic', ['min' => $this->minLength])];
        if ($this->camelCase) {
            $msg[] = trans('passwordrule::validation.camel_case');
        }
        if ($this->numbers) {
            $msg[] = trans('passwordrule::validation.numbers');
        }
        if (!empty($this->specialChars)) {
            $msg[] = trans('passwordrule::validation.special_chars', ['chars' => $this->specialChars]);
        }
        return $msg;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $msg = $this->getMessageArray();
        if (count($msg) == 1) {
            return $msg[0];
        }
        $last = array_splice($msg, -1)[0];
        return implode(trans('passwordrule::validation.join_comma'), $msg).trans('passwordrule::validation.join_and').$last;
    }
}
