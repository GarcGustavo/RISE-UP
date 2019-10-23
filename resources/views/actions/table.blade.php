<div class="table-responsive">
    <table class="table" id="actions-table">
        <thead>
            <tr>
                <th>A Date</th>
        <th>A User</th>
        <th>A Type</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($actions as $action)
            <tr>
                <td>{!! $action->a_date !!}</td>
            <td>{!! $action->a_user !!}</td>
            <td>{!! $action->a_type !!}</td>
                <td>
                    {!! Form::open(['route' => ['actions.destroy', $action->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('actions.show', [$action->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('actions.edit', [$action->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
