<!-- I Content Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('i_content', 'I Content:') !!}
    {!! Form::textarea('i_content', null, ['class' => 'form-control']) !!}
</div>

<!-- I Case Field -->
<div class="form-group col-sm-6">
    {!! Form::label('i_case', 'I Case:') !!}
    {!! Form::number('i_case', null, ['class' => 'form-control']) !!}
</div>

<!-- I Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('i_type', 'I Type:') !!}
    {!! Form::number('i_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('items.index') !!}" class="btn btn-default">Cancel</a>
</div>
