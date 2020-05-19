

const confirmareliminar = new Vue({
    el: '#confirmareliminar',

    data: {
        id:'',
        urleliminar:''
    },

    methods: {

        peticion_elimiar(id){
            this.id=id;
            this.urleliminar = document.getElementById('urlbase').innerHTML+'/'+id;
            $('#modal_eliminar').modal('show');
        }
    }

});
