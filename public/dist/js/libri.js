$(document).ready( function () {
	
    var table=$('#tbl_articoli').DataTable({
		dom: 'lBfrtip',
		
        buttons: [
			''
		],		
        pagingType: 'full_numbers',
		pageLength: 10,
		lengthMenu: [10, 15, 20, 50, 100, 200, 500],

        language: {
            lengthMenu: "Visualizza _MENU_ libri per pagina",
            zeroRecords: 'Nessun libro trovato',
            info: 'Pagina _PAGE_ di _PAGES_',
            infoEmpty: 'Non sono presenti libri',
            infoFiltered: '(Filtrati da _MAX_ libri totali)',
        },

		
    });	

    
   
	

	
} );



function elimina(id_libro) {
    if (!confirm("Sicuri di eliminare il libro?")) return false;
    
    const metaElements = document.querySelectorAll('meta[name="csrf-token"]');
    const csrf = metaElements.length > 0 ? metaElements[0].content : "";
    fetch("dele_book", {
        method: 'post',
        headers: {
          "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
          "X-CSRF-Token": csrf
        },
        body: "id_libro="+id_libro,
    })
    .then(response => {
        if (response.ok) {
           return response.json();
        }
    })
    .then(resp=>{
        if (resp.header=="OK")
            $("#tr"+id_libro).remove();
        else alert("Problema occorso durante la cancellazione")
        console.log(resp)

    })
    .catch(status, err => {
        return console.log(status, err);
    })       
}


