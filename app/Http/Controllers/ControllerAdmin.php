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

class ControllerAdmin extends Controller
{
    public function __construct(){
    }

    public function libri(Request $request) {
      $id_user = Auth::id();
      
      $inf=DB::table('users')->select('isadmin')->where('id','=',$id_user)->first();
      $isadmin=0;
      if($inf) $isadmin=$inf->isadmin;

      $elenco_libri=DB::table('libri as l')
      ->select('l.id','l.nome_libro','l.descrizione_libro','l.url_foto','l.prezzo')
      ->get();   

      return view('libri',compact('elenco_libri','isadmin','id_user'));
    }

    public function elenco_utenti(Request $request) {
      $solo_pref=$request->input('solo_pref');
      if (strlen($solo_pref)==0) $solo_pref=0;
      $id_user = Auth::id();
      
      $inf=DB::table('users')->select('isadmin')->where('id','=',$id_user)->first();
      $isadmin=0;
      if($inf) $isadmin=$inf->isadmin;

        
        $elenco_utenti=DB::table('users as u')->select('u.id','u.name','u.email','u.isadmin')->get();

      return view('elenco_utenti',compact('elenco_utenti','isadmin','id_user','solo_pref'));
    }	


    public function dele_user(Request $request)  {
      $id_utente=$request->input('id_utente');
      $dele=User::where("id","=",$id_utente)->delete();
      $resp=array();
      $resp['header']="OK";
      echo json_encode($resp);      
    }

    public function save_user(Request $request)  {
      $id_user=$request->input('id_user');
      $name=$request->input('name');
      $email=$request->input('email');
      $password=$request->input('password');$pw_orig=$password;
      $password= bcrypt($password);
      $isadmin=$request->input('isadmin');

      $data=array();
      $data['name']=$name;
      $data['email']=$email;
      if (strlen($pw_orig)>0) $data['password']=$password;
      $data['isadmin']=$isadmin;
      if (strlen($id_user)!=0 && $id_user!="0")
        $up=User::where('id','=',$id_user)->update($data);
      else {
        $up=User::where('id','=',$id_user)->update($data);
        $up= new User;
        $up->name=$name;
        $up->email=$email;
        if (strlen($pw_orig)>0) $up->password=$password;
        $up->isadmin=$isadmin;
          
        $up->save();        
      }
  
      $resp=array();
      $resp['header']="OK";
      $resp['esito_up']=$up;
      echo json_encode($resp);      
    }

    public function load_info(Request $request) {
      $id_utente=$request->input('id_utente');
      $info=User::select('name','email','isadmin')->where("id","=",$id_utente)->get();
      $resp['header']="OK";
      $resp['info']=$info;
      echo json_encode($resp);
    }

    public function load_prefer(Request $request) {
      $id_utente=$request->input('id_utente');
      $info=DB::table('preferiti as p')
      ->join('libri as l','p.id_libro','l.id')
      ->select('l.nome_libro','l.descrizione_libro','l.url_foto')
      ->where('p.id_utente','=',$id_utente)
      ->get();
      $resp['header']="OK";
      $resp['info']=$info;
      echo json_encode($resp);
            
    }

    public function load_book(Request $request) {
      $id_libro=$request->input('id_libro');
      $info=Libri::select('nome_libro','descrizione_libro','url_foto','prezzo')->where("id","=",$id_libro)->get();
      $resp['header']="OK";
      $resp['info']=$info;
      echo json_encode($resp);
    }

    public function dele_book(Request $request)  {
      $id_libro=$request->input('id_libro');
      $dele=Libri::where("id","=",$id_libro)->delete();
      $resp=array();
      $resp['header']="OK";
      echo json_encode($resp);      
    }

    public function save_book(Request $request)  {
      $id_libro=$request->input('id_libro');
      $nome_libro=$request->input('nome_libro');
      $descrizione_libro=$request->input('descrizione_libro');
      $prezzo=$request->input('prezzo');
      $url_foto=$request->input('url_foto');

      $data=array();
      $data['nome_libro']=$nome_libro;
      $data['descrizione_libro']=$descrizione_libro;
      $data['prezzo']=$prezzo;
      $data['url_foto']=$url_foto;

      if (strlen($id_libro)!=0 && $id_libro!="0")
        $up=Libri::where('id','=',$id_libro)->update($data);
      else {
        $up= new Libri;
        $up->nome_libro=$nome_libro;
        $up->url_foto=$url_foto;
        $up->descrizione_libro=$descrizione_libro;
        $up->prezzo=$prezzo;
        $up->save();        
      }
      $resp=array();
      $resp['header']="OK";
      $resp['esito_up']=$up;
      echo json_encode($resp);  

    }
 
}	
	