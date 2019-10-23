<!-- Uid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('uid', 'Uid:') !!}
    {!! Form::number('uid', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('userGroups.index') !!}" class="btn btn-default">Cancel</a>
</div>
