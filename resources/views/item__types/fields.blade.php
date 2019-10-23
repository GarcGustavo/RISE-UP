<!-- Itt Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('itt_name', 'Itt Name:') !!}
    {!! Form::text('itt_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('itemTypes.index') !!}" class="btn btn-default">Cancel</a>
</div>
