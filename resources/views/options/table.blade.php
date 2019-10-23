<div class="table-responsive">
    <table class="table" id="options-table">
        <thead>
            <tr>
                <th>O Content</th>
        <th>O Parameter</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($options as $option)
            <tr>
                <td>{!! $option->o_content !!}</td>
            <td>{!! $option->o_parameter !!}</td>
                <td>
                    {!! Form::open(['route' => ['options.destroy', $option->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('options.show', [$option->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('options.edit', [$option->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
