<?php

namespace App\Repositories;

use App\Models\Contenu;
use App\Models\Keyword;
use App\Models\Voisin;
use App\Repositories\Interfaces\KnowledgeBaseRepositoryInterface;
use Log;

class KnowledgeBaseRepository implements KnowledgeBaseRepositoryInterface
{

    public function createContenu($text,$checkQuestion,$scenario,$isActive = true){
        $contenu = new Contenu(['text' => $text, 'check_question' => $checkQuestion,'scenario' => $scenario , 'active' => $isActive]);
        $contenu->save();
        return $contenu;
    }


    public function saveContenuKeywords($contenu,$newKeywords){
        if(!is_null($contenu)){
            foreach($newKeywords as $newKeyword){
                $keyword = $this->attachKeywordToContenu($contenu,$newKeyword->label,$newKeyword->weight,false,false);
                foreach($newKeyword->synonyms as $newSynonym ){
                    $synonym = $this->attachKeywordToContenu($contenu,$newSynonym->label,$newKeyword->weight,true,false);
                    $synonymsGlobal = $this->associateVoisinToKeywords($keyword,$synonym);
                    log_info($synonymsGlobal);
                    foreach ($synonymsGlobal as $synonymGlobal){
                        log_info('synonym global : ' . $synonymGlobal->id);
                        $this->attachKeywordToContenu($contenu,$synonymGlobal->label,$newKeyword->weight,true,true);
                    }
                }
                log_info($keyword->voisin()->first()->keywords()->get()->toArray());
            }
            return 'success';
        }else{
            return [];
        }

    }

    private function createKeywordIfNotExist($label){
        $label = strtolower(trim($label));
        $keyword = Keyword::with(['voisin','voisin.keywords'])->where('label',$label)->first();
        if(is_null($keyword)){
            $keyword = new Keyword(['label' => $label]);
            $keyword->save();
        }

        return $keyword;
    }

    private function createVoisinIfNotExist(Keyword $keyword){
        if(is_null($keyword->voisin)){
            $voisin = Voisin::create();
            $keyword->voisin()->associate($voisin);
            $keyword->save();
        }else{
            $voisin = $keyword->voisin;
        }
        return $voisin;
    }

    private function attachKeywordToContenu($contenu,$label,$weight,$isSynonym,$isSynonymGlobal){
        $keyword = $this->createKeywordIfNotExist($label);
        $keywordsIds = $contenu->keywords()->pluck('keyword_id')->toArray();
        log_info('keyword id : ' . $keyword->id);
        log_info($keywordsIds);
        if(!in_array($keyword->id,$keywordsIds)){
            $contenu->keywords()->save($keyword,['weight' => $weight,'is_synonym' => $isSynonym, 'is_synonym_global' => $isSynonymGlobal]);
        }
        return $keyword;
    }

    private function associateVoisinToSynonym(Keyword $keyword,Voisin $voisin){
        $keyword->voisin()->associate($voisin);
        $keyword->save();
    }

    private function associateVoisinToKeywords(Keyword $keyword,Keyword $synonym){
        $voisin = $this->createVoisinIfNotExist($keyword);
        $this->associateVoisinToSynonym($synonym,$voisin);
        $allSynonymsGlobal = [];
        if(!is_null($synonym->voisin->keywords)){
            $synonymsGlobal = $synonym->voisin->keywords;
            foreach($synonymsGlobal as $synonymGlobal){
                array_push($allSynonymsGlobal,$synonymGlobal);
                $this->associateVoisinToSynonym($synonymGlobal,$voisin);
            }
        }

        return $allSynonymsGlobal;
    }

}
