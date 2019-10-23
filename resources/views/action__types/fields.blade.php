<!-- Act Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('act_name', 'Act Name:') !!}
    {!! Form::text('act_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('actionTypes.index') !!}" class="btn btn-default">Cancel</a>
</div>
