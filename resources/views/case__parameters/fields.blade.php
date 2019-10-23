<!-- Opt Selected Field -->
<div class="form-group col-sm-6">
    {!! Form::label('opt_selected', 'Opt Selected:') !!}
    {!! Form::text('opt_selected', null, ['class' => 'form-control']) !!}
</div>

<!-- Csp Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('csp_id', 'Csp Id:') !!}
    {!! Form::number('csp_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('caseParameters.index') !!}" class="btn btn-default">Cancel</a>
</div>
