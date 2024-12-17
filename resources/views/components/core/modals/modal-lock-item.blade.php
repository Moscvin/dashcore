@props([
    'prefix' => 'default',
    'entityColumn' => 0,
    'url',
])

<div class="modal" id="{{ $prefix }}LockModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-orange">
                <h3 class="modal-title">E' necessario confermare l'operazione</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>Sei sicuro di voler <b id="action"></b> <b id="entity"></b> ?</h4>
            </div>
            <div class="modal-footer" style="display: block">
                <button type="button" class="btn btn-warning pull-left" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>&nbsp;Annulla
                </button>
                <button type="button" class="btn btn-primary pull-right" id="lock-btn" data-bs-dismiss="modal"
                    onclick="{{ $prefix }}LockItemModalEvent(this)">
                    Procedi
                </button>
            </div>
        </div>
    </div>
</div>


@push('js')
    <script>
        ;
        (function() {
            const prefix = '{{ $prefix }}';
            const entityColumn = '{{ $entityColumn }}';
            const modalId = `${prefix}LockModal`;
            const baseUrl = `{{ $url }}`;

            window[`${prefix}LockModal`] = new bootstrap.Modal(document.getElementById(modalId), {});

            window[`${prefix}LockItem`] = function(context) {
                const modalElement = document.getElementById(modalId);
                modalElement.removeAttribute('aria-hidden');
                const oldContext = document.getElementById(`${modalId}Context`);
                if (oldContext) {
                    oldContext.removeAttribute('id');
                }
                context.setAttribute('id', `${modalId}Context`);

                const id = context.dataset.id;
                const current = +context.dataset.current;
                const entity = context.parentElement.parentElement.children['{{ $entityColumn }}'].innerText;

                document.querySelector(`#${modalId} .modal-body h4 #entity`).innerHTML = entity;

                if (current > 0) {
                    document.querySelector(`#${modalId} .modal-body h4 #action`).innerHTML = 'nascondere';
                    document.querySelector(`#${modalId} #lock-btn`).setAttribute('title', 'Nascondi');
                } else {
                    document.querySelector(`#${modalId} .modal-body h4 #action`).innerHTML = 'mostrare';
                    document.querySelector(`#${modalId} #lock-btn`).setAttribute('title', 'Mostra');
                }

                document.querySelector(`#${modalId} #lock-btn`).dataset.id = id;
                document.querySelector(`#${modalId} #lock-btn`).dataset.current = current;

                window[`${prefix}LockModal`].show();
            }

            window[`${prefix}LockItemModalEvent`] = function(modalButton) {
                const context = document.getElementById(`${modalId}Context`);
                const id = modalButton.dataset.id;
                const current = +modalButton.dataset.current;
                if (id) {
                    fetch(`/${baseUrl}/${id}/lock`, {
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'PATCH',
                        body: JSON.stringify({
                            lock: current
                        })
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.status);
                        }
                        if (context.classList.contains('btn-primary')) {
                            context.parentElement.parentElement.classList.remove('locked');

                        } else if ($(context).hasClass("btn-warning")) {
                            context.parentElement.parentElement.classList.add('locked');
                        }
                        if (current > 0) {
                            context.querySelector('i').className = 'fas fa-unlock';
                            context.classList.add('btn-primary');
                            context.classList.remove('btn-warning');
                            context.dataset.current = 0;
                            context.setAttribute('title', 'Mostra');
                        } else {
                            context.querySelector('i').className = 'fas fa-lock';
                            context.classList.remove('btn-primary');
                            context.classList.add('btn-warning');
                            context.dataset.current = 1;
                            context.setAttribute('title', 'Nascondi');
                        }
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
