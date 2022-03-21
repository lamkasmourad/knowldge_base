<?php

namespace App\Services\Chat\Models;

use App\Enums\TypeExpressionEnum;

class SynonymGlobal extends Keyword
{
    public function getType(){
        return TypeExpressionEnum::SYNONYM_GLOBAL;
    }
}
