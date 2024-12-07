<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        

        <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">


        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')
            <header class="bg-white shadow">
                  @if ($isadmin==0)    
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                      <b>Elenco libri</b>
                    </div>
                  @else  
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                      <b>Area riservata</b>
                    </div>
                  @endif  

            </header>
            <!-- Page Content -->
            <section>

            <form method='post' action="{{ route('elenco_libri') }}" id='frm_libri' name='frm_libri' autocomplete="off">
              
              <input type='hidden' name='solo_pref' id='solo_pref' value='{{$solo_pref}}'>

              @if ($isadmin==0)      
              <div class="container mt-3">
                  <div id="div_table">
                    <?php 
                      $cl="far fa-star fa-lg";
                      if ($solo_pref!="0") $cl="fa-solid fa-star"; 
                    ?>
                    <?php if (strlen($id_user)>0) {
                      $val_pref=0;
                      if ($solo_pref=="0") $val_pref=1;
                      ?>
                      <div class='mb-3'>
                        <a href='javascript:void(0)' onclick="$('#solo_pref').val('{{$val_pref}}');$('#frm_libri').submit();">
                          <i class="{{$cl}}" style="color: #0471ca;"></i> Solo preferiti
                        </a>
                      </div>
                    <?php }?>

                    <table id='tbl_articoli' class="display">
                      <thead>
                        <tr>
                        <th>Nome</th>
                        <th style='width:100px'>Foto</th>
                        <th>Scopri di più</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach($elenco_libri as $libro)
                            <tr id='tr{{$libro->id}}'>
                                <td>{{$libro->nome_libro}}
                                  <span id='id_ref{{$libro->id}}' 
                                      data-url_foto='{{$libro->url_foto}}'
                                      data-nome_libro='{{$libro->nome_libro}}'
                                      data-descrizione_libro='{{$libro->descrizione_libro}}'
                                      data-prefer='{{$libro->id_libro}}'
                                      data-prezzo='<?php echo number_format($libro->prezzo,2)."€"; ?>'
                                  >
                               
                                </td>
                                <td style='width:100px'>
                                    @if ($libro->url_foto!=null && strlen($libro->url_foto)!=0)
                                       <a href='javascript:void(0)'>
                                        <img class="rounded float-left img-fluid img-thumbnail" src='{{$libro->url_foto}}'>
                                      </a>
                                    @endif
                                </td>
                                <td>
                                  <button type="button" class="btn btn-outline-primary" onclick="view_libro({{$libro->id}})">
                                      Scopri di più
                                  </button>
                                </td>
                            </tr>  
                        @endforeach
                      </tbody>
                      <tfoot>

                      </tfoot>					
                    </table>
                  </div>  

                  <div id='div_view_book' style='display:none'>
                      <button type="button" class="btn btn-secondary" onclick="$('#div_view_book').hide();$('#div_table').show(150)">Torna all'elenco</button>
                      <div class="jumbotron mt-3">
                        <?php if (strlen($id_user)>0) {?>
                          <p class="lead" id='star'>
                          </p><hr> 
                        <?php } ?>                         

                        <h1 class="display-4"><span id='nome_libro'></span></h1>
                        <p class="small">Prezzo</p>
                        <p class="lead"><span id='prezzo'></p>
                        <p class="small">Descrizione del libro</p>
                        <p class="lead"><span id='descrizione_libro'></p>
                        <p class="mt-2"><span id='url_foto'></p>
                        <hr class="my-4">
                        <p><span id='stato_libro'></p>
                      </div>
                 </div>

                    <input type='hidden' id='info_user' value='{{$id_user}}'>
                    
                        

                 

              @endif 
              
              @if($isadmin==1) 
                  <div class="container jumbotron mt-4">
                    <h1 class="display-4">Admin Panel</h1>
                    <p class="lead">Definizione libri ed utenti</p>
                    <hr class="my-4">
                    <p>Sezione riservata ad un utenza Administrator. Operazioni disponibili</p>
                    <p class="lead mt-2">
                      <a class="btn btn-primary btn-xs" href="{{ route('elenco_utenti') }}" role="button">Gestione utenti</a>
                      <a class="btn btn-success btn-xs" href="{{ route('libri') }}" role="button">Gestione Libri</a>
                      
                    </p>
                  </div>
              @endif
                
            
           </div>
          </form>  
        </section>  
      </div>
        <!-- jQuery -->
        <script src="{{ URL::asset('/') }}plugins/jquery/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

      <!-- dipendenze DataTables !-->
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.css"/>
        
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js"></script>
      <!-- fine DataTables !-->
      
      
    
       <script src="{{ URL::asset('/') }}dist/js/elenco_libri.js?ver=1.110"</script>
        

        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        
    </body>
</html>
