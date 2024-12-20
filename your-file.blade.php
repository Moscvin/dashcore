<div class="form-group">
    <label class="required">Specializare</label>
    <input type="text" class="form-control" value="{{ $coreReservation->specialization->specialization_name }}"
        readonly>
</div>
<div class="form-group">
    <label>Doctori</label>
    <select id="doctors" name="doctor_id" class="form-control select2" required>
        <option value="">Selectați un doctor</option>
        @foreach ($doctors->where('specialization_id', $coreReservation->specialization_id) as $doctor)
            <option value="{{ $doctor->id }}" {{ $doctor->id == $coreReservation->doctor_id ? 'selected' : '' }}>
                {{ $doctor->name }}
            </option>
        @endforeach
    </select>
</div>
