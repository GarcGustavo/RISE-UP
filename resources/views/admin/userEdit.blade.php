@extends('admin.admin')

@section('adminMainContent')

    <h1 class="text-center">{{$user->first_name }} {{$user->last_name }}</h1>
    <h3 class="text-center">Editing</h3>
    <form action="/admin/user/{{$user->uid}}" method="post">
        <div class="container">
            <div class="form-group mt-5">
                <label for="role" class="font-weight-bold">Role</label>
                <small id="roleHelp" class="form-text text-muted">Update this user's account role.</small>
                <div class="form-check">
                    <label class="form-check-label" for="viewerId">
                        <input type="radio" class="form-check-input" id="viewerId" name="roleRadio" value="viewer" @if ($user->u_role ==1) checked="checked" @endif >Viewer
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label" for="collaboratorId">
                        <input type="radio" class="form-check-input" id="collaboratorId" name="roleRadio" value="collaborator" @if ($user->u_role ==2) checked="checked" @endif >Collaborator
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" disabled>Admin
                    </label>
                </div>
            </div>

            <div class="form-group mt-5">
                <label for="exp_date" class="font-weight-bold">Expiration Date</label>
                <small id="exp_dateHelp" class="form-text text-muted">Update this user's account expiration date.</small>
                <input type="date" id="exp_date" value="{{$user->u_expiration_date}}">
            </div>

            <div class="form-group mt-5">
                <label for="acc_status" class="font-weight-bold">User Account Status</label>
                <small id="acc_statusHelp" class="form-text text-muted">Update this user's account status.</small>
                <div class="form-check">
                    <label class="form-check-label" for="banId">
                        <input type="radio" class="form-check-input" id="banId" name="statusRadio" value="ban" @if ($user->u_ban_status ==1) checked="checked" @endif >Ban User
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label" for="unbanId">
                        <input type="radio" class="form-check-input" id="unbanId" name="statusRadio" value="unban" @if ($user->u_ban_status ==0) checked="checked" @endif >Unban User
                    </label>
                </div>
            </div>

            <div class="row mt-5">
                <button type="submit" class="btn btn-dark">Edit</button>
            </div>
        </div>
    </form>


@endsection
