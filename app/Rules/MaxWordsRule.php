<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxWordsRule implements Rule
{
    public $maxLength;
    public $attributeMessage;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($maxLength, $attributeMessage)
    {
        $this->maxLength = $maxLength;
        $this->attributeMessage = $attributeMessage;
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
        return str_word_count($value) <= $this->maxLength;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The '. $this->attributeMessage .' description cannot be longer than '.$this->maxLength.' words.';
    }
}
