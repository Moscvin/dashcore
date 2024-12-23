@props([
    'prefix' => 'default',
    'entityColumn' => 0,
    'url',
    'doctors',
    'specializations',
    'reservationSlots'
])

<div class="modal" id="{{ $prefix }}EditModal" tabindex="-1" role="dialog"
    aria-labelledby="{{ $prefix }}EditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-orange">
                <h3 class="modal-title" id="{{ $prefix }}EditModalLabel">Editare Rezervare</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="{{ $prefix }}EditForm">
                    <div class="form-group">
                        <label>Specializare</label>
                        <select id="specialization" name="specialization_id" class="form-control select2" required>
                            <option value="">Selectați o specializare</option>
                            @foreach ($specializations as $specialization)
                                <option value="{{ $specialization->id }}">{{ $specialization->specialization_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Doctor</label>
                        <select id="doctor" name="doctor_id" class="form-control select2" required>
                            <option value="">Selectați un doctor</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select id="status" name="status" class="form-control select2" required>
                            <option value="0">Inactiv</option>
                            <option value="1">Activ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Intervale de timp</label>
                        <select id="slot_times" name="slot_times" class="form-control select2" required>
                            @foreach ($reservationSlots as $slot)
                                <option value="{{ $slot->time }}">{{ \Carbon\Carbon::parse($slot->time)->format('Y-m-d H:i') }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="display: block">
                <button type="button" class="btn btn-warning pull-left" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>&nbsp;Anulare
                </button>
                <button type="button" class="btn btn-primary pull-right" id="edit-btn" data-bs-dismiss="modal"
                    onclick="{{ $prefix }}EditItemModalEvent(this)">
                    Salvare
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
            const modalId = `${prefix}EditModal`;
            const baseUrl = `{{ $url }}`;

            const modalElement = document.getElementById(modalId);
            const modalInstance = new bootstrap.Modal(modalElement);

            window[`${prefix}EditItem`] = function(context) {
                const oldContext = document.getElementById(`${modalId}Context`);
                if (oldContext) {
                    oldContext.removeAttribute('id');
                }
                context.setAttribute('id', `${modalId}Context`);

                const id = context.dataset.id;
                const reservation = JSON.parse(context.dataset.reservation);

                document.querySelector(`#${modalId} #specialization`).value = reservation.specialization_id;
                document.querySelector(`#${modalId} #doctor`).value = reservation.doctor_id;
                document.querySelector(`#${modalId} #status`).value = reservation.status;
                document.querySelector(`#${modalId} #slot_times`).value = reservation.slot_times;

                document.querySelector(`#${modalId} #edit-btn`).dataset.id = id;

                modalElement.removeAttribute('aria-hidden');
                modalInstance.show();
            };

            window[`${prefix}EditItemModalEvent`] = function(modalButton) {
                const context = document.getElementById(`${modalId}Context`);
                const id = modalButton.dataset.id;

                if (id) {
                    const formData = new FormData(document.getElementById(`${prefix}EditForm`));
                    const data = {};
                    formData.forEach((value, key) => {
                        data[key] = value;
                    });

                    fetch(`/${baseUrl}/${id}`, {
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            method: 'PATCH',
                            body: JSON.stringify(data)
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(() => {
                            // Update the table row with new data
                            context.closest('tr').children[entityColumn].innerText = data.specialization_id;
                            context.closest('tr').children[entityColumn + 1].innerText = data.doctor_id;
                            context.closest('tr').children[entityColumn + 2].innerText = data.status;
                            context.closest('tr').children[entityColumn + 3].innerText = data.slot_times;
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