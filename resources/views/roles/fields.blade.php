<!-- R Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('r_name', 'R Name:') !!}
    {!! Form::text('r_name', null, ['class' => 'form-control']) !!}
</div>

<!-- R Creation Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('r_creation_date', 'R Creation Date:') !!}
    {!! Form::date('r_creation_date', null, ['class' => 'form-control','id'=>'r_creation_date']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#r_creation_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('roles.index') !!}" class="btn btn-default">Cancel</a>
</div>
