
var app = Vue.component('App',{
	template:
		`
        <form autocomplete="off">
		 <div class='container mt-5' v-if="edit_new!=null">
            <span class='mb-4'>Definizione dati libro</span>
            <p v-if="resp==null">
                Caricamento dati utente in corso <i class="fas fa-spinner fa-spin"></i>
            </p>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Nome libro*</span>
                </div>
                <input type="text" required class="form-control" placeholder="Nome libro" aria-label="Nome del libro" aria-describedby="Nome libro" v-model="nome_libro">
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Descrizione libro*</span>
                </div>
                <textarea required placeholder='Descrizione' class="form-control" aria-label="Descrizione del libro" v-model='descrizione_libro' aria-describedby="Descrizione del libro" rows="3"></textarea>

            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Url foto libro*</span>
                </div>
                <input type="text" required class="form-control" placeholder="Url Foto es: https://books.google.it/books?vid=OCLC17546826&printsec=titlepage&redir_esc=y#v=onepage&q&f=false" aria-label="Url del libro" aria-describedby="URL foto" v-model="url_foto">
            </div>


            <div class="input-group mb-3" style='width:250px'>
                <div class="input-group-prepend">
                    <span class="input-group-text">Prezzo*</span>
                </div>
                <input type="number"  required placeholder='Prezzo' class="form-control" v-model='prezzo' aria-describedby="Prezzo del libro" aria-label="Prezzo del libro">
            </div>


            <div>
                <small>I dai contrassegnati con * sono obbligatori</small>
            </div>

            <div class='mt-3'>
                <p v-if='savewait==true'>
                    <i class="fas fa-spinner fa-spin"></i>
                </p>
                <button type="button" v-if="isnew==false" class="btn btn-success" @click="save_book()">Salva</button>

                <button type="button" class="ml-2 btn btn-secondary" @click='close_edit()'>Torna all'elenco</button>
            </div>
 

		</div>
        </form>	
			
	`,
	data() {
        let flagsave=0;
        let isnew=false;
        let savewait=false
        let id_libro=0;
        let edit_new=null;
        let resp=null
		let nome_libro=""
		let descrizione_libro="";
        let prezzo="";
        let url_foto=""


        
        let ref_ente="";

		return {
            flagsave,
            isnew,
            savewait,
            id_libro,
            edit_new,
            resp,
			nome_libro,
			descrizione_libro,
            prezzo,
            url_foto,

			ref_ente,

		};
	},
	watch:{        
		ref_ente(newval,oldval) {
			this.ref_event=""
			if (newval!=oldval) {
				this.ref_percorso=null
				this.check_response=null
				this.check_response_noiscr=null
				this.is_vis=false
				this.percorsi=null
			}	
		}	

	 },
    mounted: function () {
        
        window.books=this;
        
		//this.events(this.periodo_ref)
    },	
	methods: {
        reset_form() {
            this.nome_libro=""
            this.descrizione_libro="";
            this.prezzo="";
            this.url_foto="";
        },
        close_edit(){
            if (this.flagsave==0) {
                this.edit_new=null;            
                $("#div_table").show(150)
            } else {
                window.location.href = 'libri';
            }

        },
        active(from) {
            $("#div_table").hide()
            this.edit_new=1
            setTimeout(function() {	
                books.resp=1
			}, 600);
        },
		check_ins() {
			let nome_libro=this.nome_libro
			let descrizione_libro=this.descrizione_libro
            let prezzo=this.prezzo
            let url_foto=this.url_foto
            if (nome_libro.length==0 || descrizione_libro.length==0 || prezzo.length==0 || url_foto.length==0) return false
		},  

          
		save_book() {
            
            check=this.check_ins()
            if (check==false) {
                alert("Attenzione! Compilare tutti i campi contrassegnati con * e la correttezza dei dati")
                return false
            }
			var self = this;

            this.savewait=true    

			setTimeout(function() {
				//<meta name="csrf-token" content="{{{ csrf_token() }}}"> //da inserire in html
				const metaElements = document.querySelectorAll('meta[name="csrf-token"]');
				const csrf = metaElements.length > 0 ? metaElements[0].content : "";			
				fetch("save_book", {
					method: 'post',
					headers: {
						"Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
						"X-CSRF-Token": csrf
					},
					body: "id_libro="+self.id_libro+"&nome_libro="+self.nome_libro+"&descrizione_libro="+self.descrizione_libro+"&prezzo="+self.prezzo+"&url_foto="+self.url_foto
				})
				.then(response => {
					if (response.ok) {
						return response.json();
					}
				})
				.then(response=>{
                    self.savewait=false
					esito=response.header
                    if (esito=="OK") {
                        self.flagsave=1
                        if (self.id_libro==0) self.isnew=true 
                        else self.isnew=false
                        alert("Dati salvati con successo!")

                    } 
                    else alert("Attenzione! Problema occorso durante il salvataggio");
				})
				.catch(status, err => {
					return console.log(status, err);
				})		
			}, 600);					

		},


		load_info(id_libro) {
            $("#div_table").hide()
            this.edit_new=1
			var self = this;
			this.check_response="wait";
			this.check_response_noiscr=null;

			setTimeout(function() {
				//<meta name="csrf-token" content="{{{ csrf_token() }}}"> //da inserire in html
				const metaElements = document.querySelectorAll('meta[name="csrf-token"]');
				const csrf = metaElements.length > 0 ? metaElements[0].content : "";			
				fetch("load_book", {
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
				.then(info_book=>{
                    self.resp=1
                    self.nome_libro=info_book.info[0].nome_libro
                    self.descrizione_libro=info_book.info[0].descrizione_libro
                    self.prezzo=info_book.info[0].prezzo
                    self.url_foto=info_book.info[0].url_foto
				})
				.catch(status, err => {
					return console.log(status, err);
				})		
			}, 600);		
						
			
		},
	
		percs(id_evento){
			this.percorsi=null
			var self = this;
			setTimeout(function() {
				
				//<meta name="csrf-token" content="{{{ csrf_token() }}}"> //da inserire in html
				const metaElements = document.querySelectorAll('meta[name="csrf-token"]');
				const csrf = metaElements.length > 0 ? metaElements[0].content : "";			
				fetch("verifica.php", {
					method: 'post',
					headers: {
					  "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
					  "X-CSRF-Token": csrf
					},
					body: "operazione=percorsi&id_evento="+id_evento,
				})
				.then(response => {
					if (response.ok) {
					   return response.json();
					}
				})
				.then(percorsi=>{
					self.percorsi=percorsi
				})
				.catch(status, err => {
					return console.log(status, err);
				})			
			}, 100);			
			
		},
	}	
});


ev=new Vue ({
	el:"#app"
});	

function view(from) {
    books.flagsave=0
    books.isnew=false
    books.resp=null
    books.reset_form();
    if (from && from!=="0") {
        books.load_info(from)
        books.id_libro=from
    } else {
    	//window.books.active(from); 
    }    
}


function add_book() {
    books.flagsave=0
    books.isnew=false
    books.resp=null
    books.reset_form();
    books.id_libro=0
    window.books.active(0); 
}