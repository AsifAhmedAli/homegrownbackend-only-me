<?php

namespace App\Rules;

use App\Category;
use Illuminate\Contracts\Validation\Rule;

class CategoryUniqueRule implements Rule
{
    protected $id;
  
  /**
   * Create a new rule instance.
   *
   * @param null $id
   */
    public function __construct($id = null)
    {
      $this->id = $id;
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
        $id = $this->id;
        return !Category::when(request('category_id'), function($q) {
          $q->whereCategoryId(request('category_id'));
        })->whereTitle($value)->when($id, function($q) use($id) {
          $q->where('id', '!=', $id);
        })->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The Title has already been taken.';
    }
}
