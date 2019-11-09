@extends('admin.admin')

@section('adminMainContent')
            <!-- User Actions Table -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>User Groups:</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr class="text-center">
                                <th>Group Name</th>
                                <th>Group Owner</th>
                                <th>Group Creation</th>
                                <th>Latest Group action</th>
                                <th>More Group actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr class="text-center">
                                <th>Group Name</th>
                                <th>Group Owner</th>
                                <th>Group Creation</th>
                                <th>Latest Group Action</th>
                                <th>More Group actions</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            @forelse($groups as $group)
                                <tr>
                                    <td> {{$group->g_name }} </td>
                                    <td> {{$group->first_name }} {{$group->last_name }}</td>
                                    <td> {{ \Carbon\Carbon::parse($group->g_creation_date)->format('d F Y')}} </td>
                                    <td> xxxx  </td>
                                    <td class="font-weight-bold"> <a href="/admin/groups-actions/{{$group->gid }}">View</a> </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>Nadie</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
@endsection
