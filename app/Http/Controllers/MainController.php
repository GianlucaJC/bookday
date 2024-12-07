<?php
namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Libri;
use App\Models\preferiti;
use Illuminate\Support\Facades\Auth;

use DB;

class mainController extends Controller
{
    public function __construct(){
    }

    public function elenco_libri(Request $request) {
      $solo_pref=$request->input('solo_pref');
      if (strlen($solo_pref)==0) $solo_pref=0;
      $id_user = Auth::id();
      
      $inf=DB::table('users')->select('isadmin')->where('id','=',$id_user)->first();
      $isadmin=0;
      if($inf) $isadmin=$inf->isadmin;

      $elenco_libri=DB::table('libri as l')
        ->when(($solo_pref)=="0", function ($elenco_libri) use ($id_user) {
          return $elenco_libri->leftjoin('preferiti as p','l.id','p.id_libro');
        })
        ->when(($solo_pref)=="1", function ($elenco_libri) use ($id_user) {
          return $elenco_libri->join('preferiti as p','l.id','p.id_libro');
        })
          ->select('l.id','l.nome_libro','l.descrizione_libro','l.url_foto','l.prezzo','p.id_libro')
          ->get();        
      return view('elenco_libri',compact('elenco_libri','isadmin','id_user','solo_pref'));
    }	

    public function change_prefer(Request $request) {
      $stato_prefer=$request->input('stato_prefer');
      $id_libro=$request->input('id_libro');
      $id_utente=$request->input('id_utente');

      if ($stato_prefer=="1") {
        //dele prefer
        $dele=preferiti::where('id_libro','=',$id_libro)   
        ->where('id_utente','=',$id_utente)   
        ->delete(); 
      } else {
        //dele prefer
        $dele=preferiti::where('id_libro','=',$id_libro)   
        ->where('id_utente','=',$id_utente)   
        ->delete(); 

        $pref= new preferiti;
        $pref->id_libro=$id_libro;
        $pref->id_utente=$id_utente;
        $pref->save();          
      }


      $resp=array();
      $resp['header']="OK";
      echo json_encode($resp);
    }
}	
	