@props([
    'prefix' => 'default',
    'entityColumn' => 0,
    'url',
])

<div class="modal" id="{{ $prefix }}LockModal" tabindex="-1" role="dialog"
    aria-labelledby="{{ $prefix }}LockModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-orange">
                <h3 class="modal-title" id="{{ $prefix }}LockModalLabel">E' necessario confermare l'operazione
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4><span id="action"></span> <b id="entity"></b>?</h4>
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
        (function() {
            const prefix = '{{ $prefix }}';
            const entityColumn = '{{ $entityColumn }}';
            const modalId = `${prefix}LockModal`;
            const baseUrl = `{{ $url }}`;

            const modalElement = document.getElementById(modalId);
            const modalInstance = new bootstrap.Modal(modalElement);

            window[`${prefix}LockItem`] = function(context) {
                const oldContext = document.getElementById(`${modalId}Context`);
                if (oldContext) {
                    oldContext.removeAttribute('id');
                }
                context.setAttribute('id', `${modalId}Context`);

                const id = context.dataset.id;
                const current = +context.dataset.current;
                const entity = context.closest('tr').children[entityColumn].innerText;

                document.querySelector(`#${modalId} .modal-body #entity`).innerText = entity;
                document.querySelector(`#${modalId} .modal-body #action`).innerText = current > 0 ? 'nascondere' :
                    'mostrare';
                document.querySelector(`#${modalId} #lock-btn`).dataset.id = id;
                document.querySelector(`#${modalId} #lock-btn`).dataset.current = current;

                modalElement.removeAttribute('aria-hidden');
                modalInstance.show();
            };

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
                                "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            method: 'PATCH',
                            body: JSON.stringify({
                                lock: current
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(() => {
                            if (context.classList.contains('btn-primary')) {
                                context.closest('tr').classList.remove('locked');
                            } else if (context.classList.contains('btn-warning')) {
                                context.closest('tr').classList.add('locked');
                            }

                            const icon = context.querySelector('i');
                            if (current > 0) {
                                icon.className = 'fas fa-unlock';
                                context.classList.add('btn-primary');
                                context.classList.remove('btn-warning');
                                context.dataset.current = 0;
                                context.setAttribute('title', 'Mostra');
                            } else {
                                icon.className = 'fas fa-lock';
                                context.classList.remove('btn-primary');
                                context.classList.add('btn-warning');
                                context.dataset.current = 1;
                                context.setAttribute('title', 'Nascondi');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while processing your request.');
                        });
                }
            };
        })();
    </script>
@endpush
