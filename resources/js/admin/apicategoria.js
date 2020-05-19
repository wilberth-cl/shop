

const apicategoria = new Vue({
    el: '#apicategoria',

    data: {
        nombre:'',
        slug:'',
        div_mensajeslug:'Slug Existe',
        div_class_slug:'badge badge-danger',
        div_aparecer:false,
        btn_deshabilitado:1
    },

    computed: {
        generarSlug: function(){

            this.slug = this.nombre.trim().replace(/ /g,'-').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "")
            return  this.slug
        }
    },

    methods: {
        getCategory() {

            if(this.slug){

                let url = '/api/categoria/'+this.slug;
                axios.get(url).then(response=>{
                    this.div_mensajeslug=response.data;
                    if(this.div_mensajeslug==="Slug disponible"){
                        this.div_class_slug='badge badge-success';
                        this.btn_deshabilitado=0;
                    }else{
                        this.div_class_slug='badge badge-danger';
                        this.btn_deshabilitado=1;
                    }

                    this.div_aparecer=true;

                    if(document.getElementById('editar')){

                        if(document.getElementById('nombretemp').innerHTML===this.nombre){
                            this.btn_deshabilitado=0;
                            this.div_mensajeslug='';
                            this.div_class_slug='';
                            this.div_aparecer=false;

                        }
                    }
                })

            }else{
                    this.div_class_slug='badge badge-danger';
                    this.div_mensajeslug="Ingrese Categoria";
                    this.btn_deshabilitado=1;
                    this.div_aparecer=true;
            }

        }
    },

    mounted(){
        if(document.getElementById('editar')){
            this.nombre = document.getElementById('nombretemp').innerHTML;
            this.btn_deshabilitado=0;
        }
    }

});
