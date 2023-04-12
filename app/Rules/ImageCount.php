<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageCount implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $total;
    public function __construct($total)
    {
        $this->total = $total;
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
        if($this->total<3){
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please upload 3 image.';
    }
}
