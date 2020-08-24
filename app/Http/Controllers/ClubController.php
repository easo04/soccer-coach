<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ClubRepository;

class ClubController extends Controller
{
    
    public function __construct(ClubRepository $clubRepository){
        $this->clubRepository = $clubRepository;
    }


    public function updateClub(Request $request){
        $reponse = array('message' => 'USAGER NON CONNECTÉ');
        $reponseNo = 500;
        if(auth()->check()){
            $club = $this->clubRepository->update($request->all());
            $reponse = ['club' => $club, 'succes' => 'OK'];
            $reponseNo = 200;
        }
        return response()->json($reponse, $reponseNo);
    }
}
