<!-- Modal -->
  <div class="modal fade" id="modal_eliminar" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">¿Deseas eliminar este registro?</h5>
          <button type="button" class="close" data-dismiss="" aria-label="Close">
            <span aria-hidden="true"></span>
          </button>
        </div>
        <div class="modal-body">
          Se eliminará el registro: @{{ id }}
        </div>
        <div class="modal-footer">

          <form :action="urleliminar" method="post">
                @csrf
                @method('DELETE')
            <button type="submit" class="btn btn-secondary">Confirmar</button>
          </form>

          <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>

        </div>
      </div>
    </div>
  </div>
