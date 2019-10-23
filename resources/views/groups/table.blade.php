<div class="table-responsive">
    <table class="table" id="groups-table">
        <thead>
            <tr>
                <th>G Name</th>
        <th>G Status</th>
        <th>G Creation Date</th>
        <th>G Owner</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($groups as $group)
            <tr>
                <td>{!! $group->g_name !!}</td>
            <td>{!! $group->g_status !!}</td>
            <td>{!! $group->g_creation_date !!}</td>
            <td>{!! $group->g_owner !!}</td>
                <td>
                    {!! Form::open(['route' => ['groups.destroy', $group->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('groups.show', [$group->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('groups.edit', [$group->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
