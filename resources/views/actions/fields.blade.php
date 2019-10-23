<!-- A Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('a_date', 'A Date:') !!}
    {!! Form::date('a_date', null, ['class' => 'form-control','id'=>'a_date']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#a_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- A User Field -->
<div class="form-group col-sm-6">
    {!! Form::label('a_user', 'A User:') !!}
    {!! Form::number('a_user', null, ['class' => 'form-control']) !!}
</div>

<!-- A Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('a_type', 'A Type:') !!}
    {!! Form::number('a_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('actions.index') !!}" class="btn btn-default">Cancel</a>
</div>
