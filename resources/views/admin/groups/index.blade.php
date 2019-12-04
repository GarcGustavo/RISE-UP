@extends('admin.admin')

@section('adminMainContent')
            <!-- User Actions Table -->
            <div class="card mb-3">
                <div class="card-header font-weight-bold">
                    <i class="fas fa-table"></i>Groups:
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr class="text-center">
                                <th>Group Name</th>
                                <th>Group Owner</th>
                                <th>Group Creation</th>
                                <th>Recent Group Action</th>
                                <th>Date</th>
                                <th>More Group Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr class="text-center">
                                <th>Group Name</th>
                                <th>Group Owner</th>
                                <th>Group Creation</th>
                                <th>Recent Group Action</th>
                                <th>Date</th>
                                <th>More Group Actions</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            @forelse($groups as $group)
								@if(empty($group->act_name) || empty($group->recent_action_date))
									<tr>
										<td class="font-weight-bold"> {{$group->g_name }} </td>
										<td> {{$group->first_name }} {{$group->last_name }}</td>
										<td> {{ \Carbon\Carbon::parse($group->g_creation_date)->format('d F Y')}} </td>
										<td class="font-weight-bold text-danger"> No action </td>
										<td>  </td>
										<td class="font-weight-bold text-danger"> No actions </td>
									</tr>
								@else
									<tr>
										<td class="font-weight-bold"> {{$group->g_name }} </td>
										<td> {{$group->first_name }} {{$group->last_name }}</td>
										<td> {{ \Carbon\Carbon::parse($group->g_creation_date)->format('d F Y')}} </td>
										<td> {{$group->act_name}} </td>
										<td> {{ \Carbon\Carbon::parse($group->recent_action_date)->format('d F Y')}}</td>
										<td class="font-weight-bold"> <a href="/admin/groups-actions?id={{$group->gid }}">View</a> </td>
									</tr>							
								@endif
                            @empty
                                <tr>
                                    <td>No groups.</td>
                                    <td></td>
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
