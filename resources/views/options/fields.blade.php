<!-- O Content Field -->
<div class="form-group col-sm-6">
    {!! Form::label('o_content', 'O Content:') !!}
    {!! Form::text('o_content', null, ['class' => 'form-control']) !!}
</div>

<!-- O Parameter Field -->
<div class="form-group col-sm-6">
    {!! Form::label('o_parameter', 'O Parameter:') !!}
    {!! Form::number('o_parameter', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('options.index') !!}" class="btn btn-default">Cancel</a>
</div>
