@props([
    'prefix' => 'default',
    'entityColumn' => 0,
    'action',
    'url',
    'tableId'
])

<div class="modal" id="{{ $prefix }}DeleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <h3 class="modal-title">E' necessario confermare l'operazione</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Sei sicuro di voler {{ $action }} <b id="entity"></b> ?</h4>
            </div>
            <div class="modal-footer" style="display: block">
                <button type="button" class="btn btn-warning pull-left" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>&nbsp;Annulla
                </button>
                <button type="button" class="btn btn-primary pull-right" id="delete-btn" data-bs-dismiss="modal"
                        onclick="{{ $prefix }}DeleteItemModalEvent(this)">
                    Elimina
                </button>
            </div>
        </div>
    </div>
</div>


@push('js')
<script>
    ;(function() {
        const prefix = '{{ $prefix }}';
        const entityColumn = '{{ $entityColumn }}';
        const modalId = `${prefix}DeleteModal`;
        const baseUrl = `{{ $url }}`;
        const tableid = `{{ $tableId }}`;

        window[`${prefix}DeleteModal`] = new bootstrap.Modal(document.getElementById(modalId), {});
        
        window[`${prefix}DeleteItem`] = function(context) {
            const oldContext = document.getElementById(`${modalId}Context`);
            if(oldContext) {
                oldContext.removeAttribute('id');
            }
            context.setAttribute('id', `${modalId}Context`);

            const id = context.dataset.id;
            const entity = context.parentElement.parentElement.children[entityColumn].innerText;

            document.querySelector(`#${modalId} .modal-body h4 #entity`).innerHTML = entity;

            document.querySelector(`#${modalId} #delete-btn`).dataset.id = id;

            window[`${prefix}DeleteModal`].show();
        }
            
        window[`${prefix}DeleteItemModalEvent`] = function(modalButton) {
            const context = document.getElementById(`${modalId}Context`);
            const id = modalButton.dataset.id;
            if (id) {
                fetch(`/${baseUrl}/${id}`, {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'DELETE'
                }).then(response => {
                    if(!response.ok) {
                        throw new Error(response.status);
                    }
                    $(`#${tableid}`).DataTable().row($(context).parents('tr')).remove().draw();
                }).catch(error => {
                    console.error(error);
                    alert('Error');
                });
                return true;
            }
        };
    })();
</script>
@endpush