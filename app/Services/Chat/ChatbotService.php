<?php
namespace App\Services\Chat;

use stdClass;
use App\Models\Category;
use App\Services\Chat\Models\Contenu;
use App\Services\Chat\Models\Keyword;
use App\Repositories\KnowledgeBaseRepository;
use App\Services\Chat\Models\Synonym;
use App\Services\Chat\Models\SynonymGlobal;

class ChatbotService{

    protected $testAll = false;
    protected $knowledgeBaseRepo;
    protected $contenusByKeyword;
    protected $contenusBySynonym;
    protected $contenusBySynonymGlobal;

    public function __construct($testAll=false){
        $this->testAll = $testAll;
        $this->knowledgeBaseRepo = new KnowledgeBaseRepository();
    }

    public function getContenusKeyByKeyword($category_id){
        $contenusByKeywords = $this->knowledgeBaseRepo->getContenusKeyByAllKeyword($category_id,$this->testAll);
        $contenusTmp = [];
        foreach ($contenusByKeywords as $keyword => $contenus){
            foreach ($contenus['contenus'] as $contenu){

                if($contenu['pivot']['is_synonym']==1){
                    $keywordObj = new Synonym( $keyword,$contenus['pivot']['weight']);
                }else if($contenu['pivot']['is_synonym_global']==1){
                    $keywordObj = new SynonymGlobal( $keyword,$contenu['pivot']['weight']);
                }else{
                    $keywordObj = new Keyword( $keyword,$contenu['pivot']['weight']);
                }
                $contenuTmp = new Contenu($contenu['text'],$contenu['check_question'],$contenu['scenario'],$contenu['active']);
                $keywordObj->addContenu($contenuTmp);
            }
            $contenusTmp[$keyword] = $keywordObj;
        }

        return $contenusTmp;
    }


    public function getContenusKeyBySynonym($category_id){
        return $this->knowledgeBaseRepo->getContenusKeyByKeyword($category_id,$this->testAll);
    }

    public function getContenusKeyBySynonymGlobal($category_id){
        return $this->knowledgeBaseRepo->getContenusKeyBySynonymGlobal($category_id,$this->testAll);
    }

    private function getKeywordsByCategory($category_id){
        $result = $this->getContenusKeyByKeyword($category_id);
        array_merge($result,$this->getContenusKeyBySynonym($category_id));
        array_merge($result,$this->getContenusKeyBySynonymGlobal($category_id));
        return $result;
    }

    public function getAllKeywords(){
        $categories = Category::all();
        $keywords = [];
        foreach($categories as $category){
            $keywords[$category->label] = $this->getKeywordsByCategory($category->id);
        }
        return $keywords;
    }

    public function getContenus($category){
        $this->contenusByKeyword[$category->label] = $this->getContenusKeyByKeyword($category->id);
        $this->contenusBySynonym[$category->label] = $this->getContenusKeyBySynonym($category->id);
        $this->contenusBySynonymGlobal[$category->label] = $this->getContenusKeyBySynonymGlobal($category->id);
    }

}
