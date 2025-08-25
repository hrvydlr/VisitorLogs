<div>
    <form id="registeredIDForm">

        <div class="px-5 pt-2 pb-0">
            <div class="notification-container"></div>

            <input type="hidden" name="record_id" id="record_id" value="{{ $registeredId->id ?? '' }}">

            <div class="form-group">
                <select name="visitor_type" id="visitor_type" class="form-control mt-3" required>
                    <option value="" disabled selected>
                        Select Visitor Type
                    </option>
                
                    @foreach ($visitorTypes as $type)
                        <option value="{{ $type->id}}">{{ $type->type_name }}</option>
                    @endforeach
                </select>
                
                
                <span class="error-span error-type_name text-danger"></span>
            </div>

            <div class="form-group">
                <input type="text" class="form-control form-control-lg mt-3 mb-1" id="id_number" name="id_number" maxlength="4" placeholder="Enter ID Number"
                    autocomplete="off" value="{{ old('id_number', $registeredId->id_number ?? '') }}" required>
                <span class="error-span error-id_number text-danger"></span>
            </div>
        </div>

        <hr>

        <div class="pt-0 pb-3 px-5 d-flex justify-content-end">
            <button type="submit" class="btn btn-sm btn-primary modal-button" id="btn_submit">Add User ID</button>
        </div>
    </form>
</div>
