

const apiautocompletar = new Vue({
    el: '#apiautocompletar',

    data: {
        palabra_abuscar: '', //para diferenciar de palabraabuscar en el metodo de api/autocompletarcontroller
        resultados: []
    },

    methods: {
        autoCompletar() {

            this.resultados=[];

            if( this.palabra_abuscar.length >2 ){
                axios.get('/api/autocompletar/',
                        {params:{ palabraabuscar:this.palabra_abuscar }}).then(response => {
                    this.resultados = response.data;
                    console.log(response.data);
                });
            }
        }
    },

    mounted(){

        console.log('cargando datos');

    }

});
