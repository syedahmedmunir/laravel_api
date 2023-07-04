<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FileSizeLimit implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    
    protected $limit;

    public function __construct()
    {
        $this->limit = config('filesystems.uploads.size_limit');
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
        return $value->getSize() <= $this->limit * 1024;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute exceeds the  $this->limit KB file size limit.";
    }
}
