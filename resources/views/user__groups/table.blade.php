<div class="table-responsive">
    <table class="table" id="userGroups-table">
        <thead>
            <tr>
                <th>Uid</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($userGroups as $userGroups)
            <tr>
                <td>{!! $userGroups->uid !!}</td>
                <td>
                    {!! Form::open(['route' => ['userGroups.destroy', $userGroups->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('userGroups.show', [$userGroups->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('userGroups.edit', [$userGroups->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
