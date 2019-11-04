@extends('admin.admin')

@section('adminMainContent')
    <div class="container">
    <h1 class="text-center">{{$user->first_name }} {{$user->last_name }}</h1>
    <h3 class="text-center">Editing</h3>
    <form>
        <div class="form-group">
            <label for="role">Role</label>
            <small id="roleHelp" class="form-text text-muted">Update this user's account role.</small>
            <div class="form-check">
                <label class="form-check-label" for="viewerId">
                    <input type="radio" class="form-check-input" id="viewerId" name="roleRadio" value="viewer">Viewer
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label" for="collaboratorId">
                    <input type="radio" class="form-check-input" id="collaboratorId" name="roleRadio" value="collaborator">Collaborator
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" disabled>Admin
                </label>
            </div>
        </div>
        <br><br>
        <div class="form-group">
            <label for="exp_date">Expiration Date</label>
            <small id="exp_dateHelp" class="form-text text-muted">Update this user's account expiration date.</small>
            <input type="date" id="exp_date">
        </div>
        <br><br>
        <div class="form-group">
            <label for="acc_status">User Account Status</label>
            <small id="acc_statusHelp" class="form-text text-muted">Update this user's account status.</small>
            <div class="form-check">
                <label class="form-check-label" for="banId">
                    <input type="radio" class="form-check-input" id="banId" name="statusRadio" value="ban">Ban User
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label" for="unbanId">
                    <input type="radio" class="form-check-input" id="unbanId" name="statusRadio" value="unban">Unban User
                </label>
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>

@endsection
