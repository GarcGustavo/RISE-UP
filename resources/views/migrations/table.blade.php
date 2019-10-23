<div class="table-responsive">
    <table class="table" id="migrations-table">
        <thead>
            <tr>
                <th>Migration</th>
        <th>Batch</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($migrations as $migrations)
            <tr>
                <td>{!! $migrations->migration !!}</td>
            <td>{!! $migrations->batch !!}</td>
                <td>
                    {!! Form::open(['route' => ['migrations.destroy', $migrations->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('migrations.show', [$migrations->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('migrations.edit', [$migrations->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
