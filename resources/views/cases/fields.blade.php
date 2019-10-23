<!-- C Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('c_title', 'C Title:') !!}
    {!! Form::text('c_title', null, ['class' => 'form-control']) !!}
</div>

<!-- C Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('c_description', 'C Description:') !!}
    {!! Form::text('c_description', null, ['class' => 'form-control']) !!}
</div>

<!-- C Thumbnail Field -->
<div class="form-group col-sm-6">
    {!! Form::label('c_thumbnail', 'C Thumbnail:') !!}
    {!! Form::text('c_thumbnail', null, ['class' => 'form-control']) !!}
</div>

<!-- C Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('c_status', 'C Status:') !!}
    {!! Form::text('c_status', null, ['class' => 'form-control']) !!}
</div>

<!-- C Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('c_date', 'C Date:') !!}
    {!! Form::date('c_date', null, ['class' => 'form-control','id'=>'c_date']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#c_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- C Owner Field -->
<div class="form-group col-sm-6">
    {!! Form::label('c_owner', 'C Owner:') !!}
    {!! Form::number('c_owner', null, ['class' => 'form-control']) !!}
</div>

<!-- C Group Field -->
<div class="form-group col-sm-6">
    {!! Form::label('c_group', 'C Group:') !!}
    {!! Form::number('c_group', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('cases.index') !!}" class="btn btn-default">Cancel</a>
</div>
