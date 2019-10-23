<!-- G Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('g_name', 'G Name:') !!}
    {!! Form::text('g_name', null, ['class' => 'form-control']) !!}
</div>

<!-- G Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('g_status', 'G Status:') !!}
    {!! Form::text('g_status', null, ['class' => 'form-control']) !!}
</div>

<!-- G Creation Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('g_creation_date', 'G Creation Date:') !!}
    {!! Form::date('g_creation_date', null, ['class' => 'form-control','id'=>'g_creation_date']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#g_creation_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- G Owner Field -->
<div class="form-group col-sm-6">
    {!! Form::label('g_owner', 'G Owner:') !!}
    {!! Form::number('g_owner', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('groups.index') !!}" class="btn btn-default">Cancel</a>
</div>
