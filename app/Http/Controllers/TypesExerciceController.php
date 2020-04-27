<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TypesExerciceRequest;
use App\Repositories\TypesExerciceRepository;

use Str;

class TypesExerciceController extends Controller
{

    protected $typesExerciceRepository;
    protected $nbPerPege = 5;

    public function __construct(TypesExerciceRepository $typesExerciceRepository)
    {
		$this->typesExerciceRepository = $typesExerciceRepository;
    }

   
    public function index()
    {
        $typesExercice = $this->typesExerciceRepository->getPaginate($this->nbPerPege);
        $links = $typesExercice->render();

        return view('types-exercice', compact('typesExercice', 'links'));
    }

    public function getAll()
    {
        $typesExercice = $this->typesExerciceRepository->getAll();
        foreach ($typesExercice as $key => $type) {
            $type->nom = $this->getTypeNameFormated($type->nom);
        }
        $reponse = array('types' => $typesExercice);
        return response()->json($reponse, 200);
    }

    private function getTypeNameFormated($name){
        $retval = '';
        $collect = Str::of($name)->explode(' ');
        foreach ($collect as $str) {
            $str = Str::plural($str);
            $retval = $retval . $str . ' ' ;
        }
        return $retval;
    }
 
    public function create()
    {
        return view('create-types-exercice');
    }

   
    public function store(TypesExerciceRequest $request)
    {
        $requestArray = $request->all();
        $exercice = $this->typesExerciceRepository->store($requestArray);

        return redirect('types-exercice')->withOk("Le type d'exercice a été créé");
    }

    public function show($id)
    {
        $typeExercice = $this->typesExerciceRepository->getById($id);
        return view('type-exercice-detail',  compact('typeExercice'));
    }

    public function edit($id)
    {
        $typeExercice = $this->typesExerciceRepository->getById($id);
        return view('update-type-exercice',  compact('typeExercice'));
    }

    public function update(ExerciceRequest $request, $id)
    {
        $this->typesExerciceRepository->update($id, $request->all());
        return redirect('types-exercice')->withOk("L'exercice a été modifié");
    }

    public function destroy($id)
    {
        $this->typesExerciceRepository->destroy($id);

        return back();
    }
}
