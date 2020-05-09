<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ObjectifRepository;

class ObjectifController extends Controller
{
    protected $objectifRepository;

    public function __construct(ObjectifRepository $objectifRepository)
    {

        $this->objectifRepository = $objectifRepository;
    }

    public function getAll()
    {
        $objectifs = $this->objectifRepository->getAll();

        $reponse = array('objectifs' => $objectifs);
        return response()->json($reponse, 200);
    }
}
