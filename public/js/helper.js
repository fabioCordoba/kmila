document.addEventListener('livewire:init', () => {
    /**
     * Evento para abrir modal
     */
    Livewire.on('openModal', event => {
        $(`#modal-${event.modal}`).modal('show');
    });

    /**
     * Evento para cerrar modal
     */
    Livewire.on('closeModal', event => {
        $(`#modal-${event.modal}`).modal('hide');
    });

    /**
     * Evento para Notificar que el usuario se Actualizo con exito
     */
    Livewire.on('UserUpdate', event => {
        MsgDetallado('alert-success', 'Usuario Actualizado con exito...');
    });

    /**
     * Evento para Notificar que el usuario se Actualizo con exito
     */
    Livewire.on('UserCreate', event => {
        MsgDetallado('alert-success', 'Usuario Creado con exito...');
    });

    /**
     * Evento para Notificar que el Registro se  Actualizo con exito
     */
    Livewire.on('update', event => {
        MsgDetallado('alert-success', 'Registro Actualizado con exito...');
    });

    /**
     * Evento para Notificar que el Registro se creo con exito
     */
    Livewire.on('success', event => {
        MsgDetallado('alert-success', 'Registro Creado con exito...');
    });

    /**
     * Evento para Notificar que se agrego prd al carrito
     */
    Livewire.on('success-car', event => {
        MsgDetallado('alert-success', 'Producto agregado al carrito...');
    });

    /**
     * Evento para Notificar que el Registro se Elimino con exito
     */
    Livewire.on('Delete', event => {
        MsgDetallado('alert-success', 'Registro Eliminado con exito...');
    });


    /**
     * Evento para validar la eliminar Registro
     */
    Livewire.on('eliminar', event => {

        $('#toast-container').remove();

        var mensaje="¿Desea eliminar el registro?";
        var tipo="error";

        toastr[tipo]("<br /><button type='button' id='okBtn' class='btn mr-1 btn-primary'>Si</button><button type='button' id='cancelBtn' class='btn ml-1 '>No</button>",mensaje,
       {
           closeButton: false,
           allowHtml: true,
           tapToDismiss :  false,
           timeOut: 0,
           onShown: function (toast) {
               $("#okBtn").click(function(){
                //    window.livewire.emit('say-delete',event.id);
                    Livewire.dispatch('say-delete', { id: event.id })
                   $('#cancelBtn').click();
               });
               $("#cancelBtn").click(function(){
                   toastr.remove();
               });
            }
       });

    });

 });


/**
 * Funcion para lanzar un mensaje toast detallado
 */
function MsgDetallado(tipo, Msg, idContent = "MsgForm"){
    console.log('msg_detallado');
    if(tipo == 'alert-success'){
        tipo='success';
    }else if(tipo == 'alert-danger'){
        tipo='error';
    }else if(tipo == 'alert-warning'){
        tipo='warning';
    }
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
    toastr[tipo]('<div>'+Msg+'</div>');
}

/**
 * Funcion para lanzar un mensaje toast simple
 */
function Msg(texto){
toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "2000",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
    }
    toastr['warning']('<div>'+texto+'</div>');
}

/**
 * Funcion para lanzar un mensaje toast de error
 */
function MsgError(texto){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "2000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr['error']('<div>'+texto+'</div>');
}

/**
 * Funcion para lanzar un mensaje toast de confirmacion de eliminado
 */
function MsgEliminar(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "2000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr['success']('<div> Registro eliminado con éxito </div>');
}

/**
 * Funcion para capturar formdata
 */
function formData(id){
    console.log(id);
    return new FormData($('#'+id)[0]);
}

/**
 * Funcion para capturar token
 */
function token(){
    return $('input[name="_token"]').val();
}

/**
 * Funcion para limpiar Form
 */
function cleanForm(idformulario) {
    $('#'+idformulario)[0].reset();
}

