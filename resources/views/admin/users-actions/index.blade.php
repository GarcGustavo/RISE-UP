@extends('admin.admin')

@section('adminMainContent')
            <!-- User Actions Table -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>View User Actions:</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Latest Action</th>
                                <th>Date</th>
                                <th>More actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Latest Action</th>
                                <th>Date</th>
                                <th>More Actions</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            @forelse($users as $user)
                                <tr>
                                    <td> {{$user->first_name }} {{$user->last_name}} </td>
                                    <td> {{$user->act_name }} </td>
                                    <td> {{ \Carbon\Carbon::parse($user->latest_action_date)->format('d F Y')}}  </td>
                                    <td class="font-weight-bold"> <a href="/admin/users-actions/{{$user->uid }}">View</a> </td>
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
