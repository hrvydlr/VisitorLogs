<div>
    <form id="usertypeForm">

        <div class="px-5 pt-2 pb-0">
            <div class="notification-container"></div>

            <input type="hidden" name="record_id" id="record_id">

            <div class="form-group">
                <input type="text" class="form-control form-control-lg mt-1 mb-1" id="name" aria-label="name" name="name" placeholder="Enter user type name"
                    autocomplete="off" required>
                <span class="error-span error-name text-danger"></span>
            </div>
        </div>
        

        <hr>

        <div class="pt-0 pb-3 px-5 d-flex justify-content-end">
            <button type="submit" class="btn btn-sm btn-primary modal-button" id="btn_submit">Add User Type</button>
        </div>
    </form>
</div>