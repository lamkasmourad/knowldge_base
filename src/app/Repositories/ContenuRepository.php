<?php

namespace App\Repositories;

use App\Models\Contenu;
use App\Models\Keyword;
use App\Models\Voisin;
use App\Repositories\Interfaces\ContenuRepositoryInterface;
use App\Repositories\BaseRepository;

class ContenuRepository implements ContenuRepositoryInterface
{

    public function createContenu($text, $checkQuestion, $scenario,$categoriesId, $isActive = true)
    {
        $contenu = Contenu::where('text',$text)->first();
        $contenu = new Contenu(['text' => $text, 'check_question' => $checkQuestion, 'scenario' => $scenario, 'active' => $isActive]);
        $contenu->save();
        $contenu->categories()->attach($categoriesId);

        return $contenu;
    }

    public function saveContenuKeywords($contenu, $newKeywords)
    {
        if (!is_null($contenu)) {
            foreach ($newKeywords as $nKeyword) {
                $weight = $nKeyword->weight;
                $keyword = $this->createKeywordIfNotExist($nKeyword->label);
                $voisin = $this->createVoisin();
                $keyword->voisins()->save($voisin,['is_keyword' => true]);
                $this->attachKeywordToContenu($contenu,$weight, false, false, $keyword);
                $synonymsGlobalOfKeyword = $keyword->getSynonyms();

                $synonymsGlobalOfSynonym =collect();
                foreach ($nKeyword->synonyms as $newSynonym) {
                    $synonym = $this->createKeywordIfNotExist($newSynonym->label);
                    $synonym->voisins()->save($voisin);
                    $this->attachKeywordToContenu($contenu,$weight, true, false, $synonym);
                    $synonymsGlobalOfSynonym = $synonym->getSynonyms( $synonymsGlobalOfKeyword->pluck('id')->toArray());
                }

                $globalSynonyms = $synonymsGlobalOfKeyword->merge($synonymsGlobalOfSynonym);
                $this->handleGlobalSynonyms($contenu,$globalSynonyms,$weight,$voisin);
            }
            return 'success';
        } else {
            return [];
        }
    }

    private function attachKeywordToContenu($contenu, $weight, $isSynonym, $isSynonymGlobal, $keyword): void
    {
        $keywordsIds = $contenu->keywords()->pluck('keyword_id')->toArray();
        if (!in_array($keyword->id, $keywordsIds)) {
            $contenu->keywords()->save($keyword, ['weight' => $weight, 'is_synonym' => $isSynonym, 'is_synonym_global' => $isSynonymGlobal]);
        }
    }

    private function createKeywordIfNotExist($label){
        $keyword = $this->getKeywordByLabel($label);
        if(is_null($keyword)){
            $keyword = $this->createKeyword($label);
        }
        return $keyword;
    }

    private function getKeywordByLabel($label){
        $label = strtolower(trim($label));
        $keyword = Keyword::with(['voisins', 'voisins.keywords'])->where('label', $label)->first();
        return $keyword;
    }

    private function createKeyword($label)
    {
        $label = strtolower(trim($label));
        $keyword = new Keyword(['label' => $label]);
        $keyword->save();
        return $keyword;
    }

    private function createVoisin(){
        $voisin = Voisin::create();
        return $voisin;
    }

    private function handleGlobalSynonyms($contenu,$globalSynonyms,$weight,$voisin){
        foreach($globalSynonyms as $globalSynonym){
            $this->attachKeywordToContenu($contenu, $weight, false, true, $globalSynonym);
        }
    }

}
