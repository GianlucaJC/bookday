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
            <!-- Page Heading -->
           
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                      <b>Gestione libri</b>
                    </div>
                </header>    

         <!-- Page Content -->
        <main>
              

              @if ($isadmin==1)     

                <div class="container mt-3">
                <!-- handle from Vue !-->
                <div id="app">
                  <App></App>
                </div>    

                <form method='post' action="{{ route('elenco_utenti') }}" id='frm_utenti' name='frm_utenti' autocomplete="off">
              

                    <div id="div_table">
                      <table id='tbl_articoli' class="display">
                        <thead>
                          <tr>
                          <th>Nome Libro</th>
                          <th>Descrizione</th>
                          <th style='width:100px'>Foto</th>
                          <th style='min-width:100px'>Prezzo</th>
                          <th style='min-width:200px'>Operazioni</th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach($elenco_libri as $libro)
                              <tr id='tr{{$libro->id}}'>
                                  <td>{{$libro->nome_libro}}
                                    <span id='id_ref{{$libro->id}}' 
                                        data-name='{{$libro->nome_libro}}'
                                    >
                                  </td>
                                  <td>
                                      <?php echo $libro->descrizione_libro; ?>
                                  </td>
                                  <td style='width:100px'>
                                    @if ($libro->url_foto!=null && strlen($libro->url_foto)!=0)
                                       <a href='javascript:void(0)'>
                                        <img class="rounded float-left img-fluid img-thumbnail" src='{{$libro->url_foto}}'>
                                      </a>
                                    @endif
                                </td>

                                  <td style='min-width:100px'>
                                    <?php echo number_format($libro->prezzo,2)."€"; ?>
                                  </td>

                                  <td style='min-width:200px'>
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="view({{$libro->id}})">
                                      <i class="fa-solid fa-pen-to-square"></i> Modifica
                                    </button>
                                    <button type="button" class="ml-2 btn btn-outline-danger btn-sm" onclick="elimina({{$libro->id}})">
                                      <i class="fa-solid fa-trash-can"></i> Elimina
                                    </button>
                                  </td>
                              </tr>  
                          @endforeach
                        </tbody>
                        <tfoot>

                        </tfoot>					
                      </table>
                      <button type="button" class="btn btn-primary" onclick='add_book()'>Aggiungi Libro</button>                      
                    </div>  
                </form>    

              @endif 
              
              @if($isadmin==0) 
                  <div class="jumbotron mt-3">
                    <h1 class="display-4">Attenzione</h1>
                    <p class="lead">Non hai accesso a questa pagina con il tuo livello di utenza</p>
                    <hr class="my-4">
                    <p class="lead mt-2">
                      <a class="btn btn-primary btn-lg" href="{{ route('elenco_libri') }}" role="button">Home page</a>
                    </p>
                  </div>
              @endif
          </div>
       

        <!-- Modal for libri preferiti-->
         
        <div class="modal fade" id="modal_prefer" tabindex="-1" role="dialog" aria-labelledby="Libri preferiti" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Libri preferiti dall'utente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="cont_prefer">
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
              </div>
            </div>
          </div>
        </div>          
        </main> 



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
      
      <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
      
    
       <script src="{{ URL::asset('/') }}dist/js/libri.js?ver=<?= time() ?>"></script>
       <script src="{{ URL::asset('/') }}dist/js/libri_vue.js?ver=<?= time() ?>"></script>
        

        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        
    </body>
</html>
