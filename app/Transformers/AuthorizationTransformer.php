<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 7/31/19
 * Time: 18:04
 */

namespace App\Transformers;
use App\Models\Authorization;

use League\Fractal\TransformerAbstract;
class AuthorizationTransformer extends TransformerAbstract
{
    public function transform(Authorization $authorization)
    {
        return $authorization->toArray();
    }
}