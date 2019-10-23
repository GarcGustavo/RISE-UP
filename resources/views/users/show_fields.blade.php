<!-- First Name Field -->
<div class="form-group">
    {!! Form::label('first_name', 'First Name:') !!}
    <p>{!! $user->first_name !!}</p>
</div>

<!-- Last Name Field -->
<div class="form-group">
    {!! Form::label('last_name', 'Last Name:') !!}
    <p>{!! $user->last_name !!}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{!! $user->email !!}</p>
</div>

<!-- Contact Email Field -->
<div class="form-group">
    {!! Form::label('contact_email', 'Contact Email:') !!}
    <p>{!! $user->contact_email !!}</p>
</div>

<!-- U Creation Date Field -->
<div class="form-group">
    {!! Form::label('u_creation_date', 'U Creation Date:') !!}
    <p>{!! $user->u_creation_date !!}</p>
</div>

<!-- U Ban Status Field -->
<div class="form-group">
    {!! Form::label('u_ban_status', 'U Ban Status:') !!}
    <p>{!! $user->u_ban_status !!}</p>
</div>

<!-- Current Edit Cid Field -->
<div class="form-group">
    {!! Form::label('current_edit_cid', 'Current Edit Cid:') !!}
    <p>{!! $user->current_edit_cid !!}</p>
</div>

<!-- U Role Field -->
<div class="form-group">
    {!! Form::label('u_role', 'U Role:') !!}
    <p>{!! $user->u_role !!}</p>
</div>

