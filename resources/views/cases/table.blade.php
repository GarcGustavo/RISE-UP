<div class="table-responsive">
    <table class="table" id="cases-table">
        <thead>
            <tr>
                <th>C Title</th>
        <th>C Description</th>
        <th>C Thumbnail</th>
        <th>C Status</th>
        <th>C Date</th>
        <th>C Owner</th>
        <th>C Group</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($cases as $case)
            <tr>
                <td>{!! $case->c_title !!}</td>
            <td>{!! $case->c_description !!}</td>
            <td>{!! $case->c_thumbnail !!}</td>
            <td>{!! $case->c_status !!}</td>
            <td>{!! $case->c_date !!}</td>
            <td>{!! $case->c_owner !!}</td>
            <td>{!! $case->c_group !!}</td>
                <td>
                    {!! Form::open(['route' => ['cases.destroy', $case->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('cases.show', [$case->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('cases.edit', [$case->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
