<?php

namespace App\Http\Controllers\Contenu;

use stdClass;
use App\Models\Contenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ContenuRepositoryInterface;

class ContenuController extends Controller
{

    protected $contenuRepository;
    public function __construct(ContenuRepositoryInterface $contenuRepository)
    {
        $this->contenuRepository = $contenuRepository;
    }

    private function checkForMissingInput(Request $request)
    {
        $missingInput = [];
        if (!$request->has('text')) {
            array_push($missingInput, 'text');
        }

        if (!$request->has('check_question')) {
            array_push($missingInput, 'check_question');
        }

        if (!$request->has('scenario')) {
            array_push($missingInput, 'scenario');
        }

        /* if(!$request->has('category_id')){
            array_push($missingInput,'category_id');
        }*/

        if (count($missingInput) > 0) {
            return 'One/More input(is) is/are Missing : ' . implode(',', $missingInput);
        } else {
            return '';
        }
    }
    public function saveContenuAndKeywords(Request $request)
    {
        \DB::connection()->enableQueryLog();
        $validated = $this->checkForMissingInput($request);

        if (!empty($validated)) {
            return response()->json($validated, 400);
        } else {
            $text = 'test 10';

            $check_question = 'test 10 check question';

            $scenario = 'test 10 scenario';

            $categoriesId = [1, 3];

            $contenu = $this->contenuRepository->createContenu($text, $check_question, $scenario, $categoriesId);

            $synonyms =  [$this->getKeyword('test 10 synonym 1'), $this->getKeyword('test 10 synonym 2')];

            $keyword = $this->getKeyword('test 10 synonym 1');

            $keyword->weight = '10';
            $keyword->synonyms =  $synonyms;

            $result = $this->contenuRepository->saveContenuKeywords($contenu, [$keyword]);


            //$contenu = $this->contenuRepository->createContenu($request->text,$request->check_question,$request->scenario);
            $queries = \DB::getQueryLog();
            log_info($queries);
            return response()->json($result);
        }
    }

    public function getKeyword($label)
    {
        $obj = new stdClass;

        $obj->label  = $label;
        return $obj;
    }

    public function createContenu(Request $request)
    {
        $contenu = Contenu::where('text', $request->text)->first();
        if (is_null($contenu)) {
            $contenu = $this->contenuRepository->createContenu($request->text, $request->controleQuestion, $request->scenario, $request->selectedCategories);
            if (!is_null($contenu)) {
                return response()->json("success");
            }
        } else {
            return response()->json("DUPLICATE_CONTENU");
        }
    }

    public function getContenu(Request $request)
    {
        $contenu = Contenu::with(['categories'])
                    ->select('id','text','check_question as controleQuestion','scenario')
                    ->find($request->contenu_id);
        $contenu->selectedCategories = $contenu->selectedCategories();
        unset($contenu->categories);
        return response()->json($contenu);
    }
}
