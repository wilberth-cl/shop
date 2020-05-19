

const apiproducto = new Vue({
    el: '#apiproducto',

    data: {
        nombre:'',
        slug:'',
        div_mensajeslug:'Slug Existe',
        div_class_slug:'badge badge-danger',
        div_aparecer:false,
        btn_deshabilitado:1,

        //variables de Precio

        precio_anterior:0,
        precioactual:0,
        descuento:0,
        porcentajededescuento:0,
        mensajedescuento:'0'


    },

    computed: {
        generarSlug: function(){

            this.slug = this.nombre.trim().replace(/ /g,'-').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "")
            return  this.slug
        },


        generardescuento : function(){
            if(this.porcentajededescuento>100){

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'El Descuento no puede ser mayor a 100%',
                    footer: 'Verifique su información'
                });

                this.porcentajededescuento = 100;

                this.descuento = (this.precio_anterior*this.porcentajededescuento)/100;
                this.precioactual=this.precio_anterior-this.descuento;

                this.mensajedescuento='¡Wou! Producto ¡Gratis 2! '+this.descuento;

                return this.mensajedescuento;

            } else

            if(this.porcentajededescuento<0){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'El Descuento no puede ser menor a 0%',
                    footer: 'Verifique su información'
                });

                this.porcentajededescuento = 0;

                this.descuento = (this.precio_anterior*this.porcentajededescuento)/100;
                this.precioactual=this.precio_anterior-this.descuento;

                 this.mensajedescuento='Sin descuento';

                return this.mensajedescuento;

            }else

            if(this.porcentajededescuento>0){
                this.descuento = (this.precio_anterior*this.porcentajededescuento)/100;
                this.precioactual=this.precio_anterior-this.descuento;

                if(this.porcentajededescuento==100){

                    this.mensajedescuento='¡Wou! Producto ¡Gratis! '+this.descuento;

                }else{

                    this.mensajedescuento='Hay descuento de $ '+this.descuento+' pesos';

                }

                return  this.mensajedescuento;

            }else{
                this.descuento ='';
                this.precioactual=this.precio_anterior;

                this.mensajedescuento='Sin descuento';

                return  this.mensajedescuento;
            }

        }


    },

    methods: {
        eliminarImagen(imagen) {
            console.log(imagen);

            Swal.fire({
                title:'¿Seguro que quieres eliminar esta imagen?',
                text: "La imagen "+imagen.id+" sera borrada",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Si, Confirmar!',
                cancelButtonText: 'Cancelar',
                allowOutsideClick: false
              }).then((result) => {
                if (result.value) {

                    //eliminar difinitivamente por medio de Axios
                    let url = '/api/eliminarimagen/'+imagen.id;
                    axios.delete(url).then(response=>{
                        console.log(response.data);
                    });

                //eliminar el elemento de la ventana
                var elemento = document.getElementById('idimagen-'+imagen.id);
                //console.log(elemento);

                elemento.parentNode.removeChild(elemento); // desaparece la imagen de la pantalla

                  Swal.fire(
                    '¡Eliminado!',
                    'El archivo ha sido eliminado.',
                    'success',

                  )
                }
              });
        },

        getProducto() {

            if(this.slug){

                let url = '/api/producto/'+this.slug;
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

                    if(data.datos.nombre){

                        if(data.datos.nombre===this.nombre){
                            this.btn_deshabilitado=0;
                            this.div_mensajeslug='';
                            this.div_class_slug='';
                            this.div_aparecer=false;

                        }

                    }

                })

            }else{
                this.div_class_slug='badge badge-danger';
                this.div_mensajeslug="Ingrese Producto";
                this.btn_deshabilitado=1;
                this.div_aparecer=true;
            }

        }
    },

    mounted(){
        if(data.editar=='Si'){
            //nombres Definidis en esta Api
            // =
            //nombres que se reciven de Window.data que ya se han ligado a sus nombres en base de datos
            this.nombre = data.datos.nombre;
            this.precio_anterior = data.datos.precio_anterior;
            this.porcentajededescuento = data.datos.porcentajededescuento;
            this.btn_deshabilitado=0;
        }


        console.log(data);
    }

});
