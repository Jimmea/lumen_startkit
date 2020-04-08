<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 8/4/19
 * Time: 17:35
 */

namespace App\Models;

/**
 * Data.
 *
 * you can use this model like this instead of response->array()
 *
 * $data = new Data(['foo' => 'bar']);
 * return $this->response->item($data, new DataTransformer());
 */

class Data
{
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function toArray()
    {
        return (array) $this->data;
    }
}