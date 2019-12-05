@extends('admin.admin')

@section('adminMainContent')

    @forelse($users as $user)

    <h1 class="text-center">
        {{$user->first_name }} {{$user->last_name }}
    </h1>
    <h3 class="text-center">Editing</h3>
    <form action="/admin/user/edit?urtd={{$user->uid}}&uid={{$uid}}" method="post">
        @method('PUT')
        @csrf
        <input type="hidden" id="u_role_upgrade" name="u_role_upgrade_request" value="0">

        <div class="container">
            <div class="form-group mt-5">
                <label for="role" class="font-weight-bold">Role</label>
                <small id="roleHelp" class="form-text text-muted">Update this user's account role.</small>
                <div class="form-check">
                    <label class="form-check-label" for="viewerId">
                        <input type="radio" class="form-check-input" id="viewerId" name="u_role" value=2 @if ($user->u_role ==2) checked="checked" @endif >Viewer
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label" for="collaboratorId">
                        <input type="radio" class="form-check-input" id="collaboratorId" name="u_role" value=3 @if ($user->u_role ==3) checked="checked" @endif >Collaborator
                    </label>
                </div>
				<!--
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" disabled>Admin
                    </label>
                </div>
				-->
                @if($errors->has('u_role'))
                    <span class="alert alert-danger">{{ $errors->first('u_role') }}</span>
                @endif
            </div>

            <div class="form-group mt-5">
                <div class="form-group">
                    <label for="exp_date" class="font-weight-bold">Expiration Date</label>
                    <small id="exp_dateHelp" class="form-text text-muted">Update this user's account expiration date.</small>
                    <input type="date" id="exp_date" name="u_expiration_date" value="{{$user->u_expiration_date}}">
                </div>
                @if($errors->has('u_expiration_date'))
                    <span class="alert alert-danger">{{ $errors->first('u_expiration_date') }}</span>
                @endif
            </div>

            <div class="form-group mt-5">
                <label for="acc_status" class="font-weight-bold">User Account Status</label>
                <small id="acc_statusHelp" class="form-text text-muted">Update this user's account status.</small>
                <div class="form-check">
                    <label class="form-check-label" for="banId">
                        <input type="radio" class="form-check-input" id="banId" name="u_ban_status" value=1 @if ($user->u_ban_status ==1) checked="checked" @endif >Ban User
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label" for="unbanId">
                        <input type="radio" class="form-check-input" id="unbanId" name="u_ban_status" value=0 @if ($user->u_ban_status ==0) checked="checked" @endif >Unban User
                    </label>
                </div>
                @if($errors->has('u_ban_status'))
                    <span class="alert alert-danger">{{ $errors->first('u_ban_status') }}</span>
                @endif
            </div>

            <div class="row mt-5">
                <button type="submit" class="btn btn-dark">Save</button>
            </div>
        </div>
    </form>

    @empty
        No such User.
        <br><br>
        Made @ UPRM for Capstone 2019.
    @endforelse

@endsection
