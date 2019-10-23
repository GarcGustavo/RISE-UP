<!-- First Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('first_name', 'First Name:') !!}
    {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Last Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('last_name', 'Last Name:') !!}
    {!! Form::text('last_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Contact Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contact_email', 'Contact Email:') !!}
    {!! Form::text('contact_email', null, ['class' => 'form-control']) !!}
</div>

<!-- U Creation Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('u_creation_date', 'U Creation Date:') !!}
    {!! Form::date('u_creation_date', null, ['class' => 'form-control','id'=>'u_creation_date']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#u_creation_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- U Ban Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('u_ban_status', 'U Ban Status:') !!}
    {!! Form::text('u_ban_status', null, ['class' => 'form-control']) !!}
</div>

<!-- Current Edit Cid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('current_edit_cid', 'Current Edit Cid:') !!}
    {!! Form::number('current_edit_cid', null, ['class' => 'form-control']) !!}
</div>

<!-- U Role Field -->
<div class="form-group col-sm-6">
    {!! Form::label('u_role', 'U Role:') !!}
    {!! Form::number('u_role', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-default">Cancel</a>
</div>
