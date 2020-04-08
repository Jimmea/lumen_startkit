<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 8/4/19
 * Time: 17:39
 */

namespace App\Transformers;

use App\Models\Data;

class DataTransformer
{
    public function transform($data)
    {
        if ($data instanceof Data) {
            $data = $data->toArray();
        }
        return $data;
    }
}