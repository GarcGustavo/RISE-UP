<!-- Migration Field -->
<div class="form-group col-sm-6">
    {!! Form::label('migration', 'Migration:') !!}
    {!! Form::text('migration', null, ['class' => 'form-control']) !!}
</div>

<!-- Batch Field -->
<div class="form-group col-sm-6">
    {!! Form::label('batch', 'Batch:') !!}
    {!! Form::number('batch', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('migrations.index') !!}" class="btn btn-default">Cancel</a>
</div>
