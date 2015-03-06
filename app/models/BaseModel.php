<?php namespace EA\models;

use Illuminate\Database\Eloquent\Model as LaravelModel;

abstract class BaseModel extends LaravelModel
{
    /**
     * Indicates which fields should be returned as booleans.
     *
     * @var array
     */
    public $booleans = array();

    /**
     * Get a plain attribute (not a relationship).
     *
     * @param  string  $key
     * @return mixed
     */
    protected function getAttributeValue($key)
    {
        $value = parent::getAttributeValue($key);

        if (in_array($key, $this->booleans)) {
            $value = (bool) $value;
        }

        return $value;
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->booleans)) {
            $value = (int) $value;
        }

        parent::setAttribute($key, $value);
    }

    /**
     * Convert the model's attributes to an array.
     *
     * @return array
     */
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        foreach ($this->booleans as $key) {
            if (!isset($attributes[$key])) {
                continue;
            }

            $attributes[$key] = (bool) $attributes[$key];
        }

        return $attributes;
    }
}
