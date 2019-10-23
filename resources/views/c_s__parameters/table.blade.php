<div class="table-responsive">
    <table class="table" id="cSParameters-table">
        <thead>
            <tr>
                <th>Csp Name</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($cSParameters as $cSParameter)
            <tr>
                <td>{!! $cSParameter->csp_name !!}</td>
                <td>
                    {!! Form::open(['route' => ['cSParameters.destroy', $cSParameter->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('cSParameters.show', [$cSParameter->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('cSParameters.edit', [$cSParameter->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
