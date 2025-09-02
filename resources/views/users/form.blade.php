<div>
    <form id="userForm">
        <div class="px-5 pt-2 pb-0">
            <div class="notification-container"></div>

            <input type="hidden" name="record_id" id="record_id" >
            
            <div class="mb-3">
                <label for="user_type_id" class="label">Role</label>
                <select name="user_type" id="user_type" class="form-control select2" required>
                </select>
            </div>

            <div class="mb-3">
                <label for="Username" class="label">Employee Code</label>
                <input type="text" name="username" id="username" class="form-control" required >

            </div>
        
            <div class="mb-3">
                <label for="password" class="label">Password</label>
                <small class="text-muted">(leave blank to keep current)</small>
                <input type="password" name="password" id="password" class="form-control">

                @if ($errors->has('password'))
                    <span class="error-span text-danger">
                        {{ $errors->first('password') }}
                    </span>
                @elseif (strlen(old('password')) > 0 && strlen(old('password')) < 8)
                    <span class="error-span text-danger">
                        Password must be at least 8 characters long.
                    </span>
                @endif
            </div>

        
            <div class="pt-2 pb-3 ">
                <button type="submit" class="btn btn-primary modal-button-user" id="btn_submit">Submit</button>
            </div>
    </form>
</div>