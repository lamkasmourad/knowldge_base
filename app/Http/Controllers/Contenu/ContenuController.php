<?php

namespace App\Http\Controllers\Contenu;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\KnowledgeBaseRepositoryInterface;

use Illuminate\Http\Request;
use stdClass;

class ContenuController extends Controller
{

    protected $knowledgeBaseRepo;
    public function __construct(KnowledgeBaseRepositoryInterface $knowledgeBaseRepo)
    {
        $this->knowledgeBaseRepo = $knowledgeBaseRepo;
    }
    private function checkForMissingInput(Request $request){
        $missingInput = [];
        if(!$request->has('text')){
            array_push($missingInput,'text');
        }

        if(!$request->has('check_question')){
            array_push($missingInput,'check_question');
        }

        if(!$request->has('scenario')){
            array_push($missingInput,'scenario');
        }

        if(count($missingInput)>0){
            return 'One/More input is Missing : ' . implode(',', $missingInput);
        }else{
            return '';
        }
    }
    public function saveContenuAndKeywords(Request $request){
      $validated = $this->checkForMissingInput($request);

      if(!empty($validated)){
        return response()->json($validated,400 );
      }else{
        $text = 'test 3';

        $check_question = 'test 3 check question';

        $scenario = 'test 3 scenario';

        $contenu = $this->knowledgeBaseRepo->createContenu($text,$check_question,$scenario);


        $synonyms =[]; //[$this->getKeyword('test 1 synonym 1'), $this->getKeyword('test 1 synonym 2')];

        $keyword = $this->getKeyword('test 1 keyword');
        $keyword->weight = '10';
        $keyword->synonyms =  $synonyms;

        $result = $this->knowledgeBaseRepo->saveContenuKeywords($contenu,[$keyword]);

        //$contenu = $this->knowledgeBaseRepo->createContenu($request->text,$request->check_question,$request->scenario);

        return response()->json($result);
      }


    }

    public function getKeyword($label){

        $obj = new stdClass;

        $obj->label  = $label;
        return $obj;
    }


}
