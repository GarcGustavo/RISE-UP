<div class="table-responsive">
    <table class="table" id="caseParameters-table">
        <thead>
            <tr>
                <th>Opt Selected</th>
        <th>Csp Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($caseParameters as $caseParameters)
            <tr>
                <td>{!! $caseParameters->opt_selected !!}</td>
            <td>{!! $caseParameters->csp_id !!}</td>
                <td>
                    {!! Form::open(['route' => ['caseParameters.destroy', $caseParameters->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('caseParameters.show', [$caseParameters->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('caseParameters.edit', [$caseParameters->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
