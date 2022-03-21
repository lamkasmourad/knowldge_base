<?php

namespace App\Repositories;

use App\Models\Keyword;
use App\Repositories\Interfaces\KnowledgeBaseRepositoryInterface;

class KnowledgeBaseRepository implements KnowledgeBaseRepositoryInterface
{

    public function getContenusKeyByAllKeyword($category_id,$testAll){
        $constraint = $this->getConstraint($category_id,false,false,$testAll,true);
        $keywords = Keyword::with(['contenus' => $constraint])->whereHas('contenus', $constraint)->get()->keyBy('label')->toArray();
        return $keywords;
    }

    public function getContenusKeyByKeyword($category_id,$testAll){
        $constraint = $this->getConstraint($category_id,false,false,$testAll);
        $keywords = Keyword::with(['contenus' => $constraint])->whereHas('contenus', $constraint)->get()->keyBy('label')->toArray();
        return $keywords;
    }

    public function getContenusKeyBySynonym($category_id,$testAll){
        $constraint = $this->getConstraint($category_id,true,false,$testAll);
        $keywords = Keyword::with(['contenus' => $constraint ])->whereHas('contenus', $constraint)->get()->keyBy('label')->toArray();
        return $keywords;
    }

    public function getContenusKeyBySynonymGlobal($category_id,$testAll){
        $constraint = $this->getConstraint($category_id,false,true,$testAll);
        $keywords = Keyword::with(['contenus' => $constraint ])->whereHas('contenus', $constraint)->get()->keyBy('label')->toArray();
        return $keywords;
    }

    private function getConstraint($category_id,$isSynonym,$isSynonymGlobal,$testAll,$allKeywords=false){
        return function($q) use ($category_id,$isSynonym,$isSynonymGlobal,$testAll,$allKeywords ){
            $q->when($allKeywords,function($q) use ($isSynonym,$isSynonymGlobal){
                $q->where('is_synonym',$isSynonym)
                ->where('is_synonym_global',$isSynonymGlobal);
            })
            ->when(!$testAll,function($q){
                $q->where('active',true);
            })
            ->whereHas('categories', function($q) use($category_id) {
                $q->where('category_id', $category_id);
            });
        };
    }


}
