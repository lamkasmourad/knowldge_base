<?php

namespace App\Services\Chat\Models;

use App\Enums\TypeExpressionEnum;

class Synonym extends Keyword
{



    public function getType(){
        return TypeExpressionEnum::SYNONYM;
    }

}
