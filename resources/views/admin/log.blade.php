@extends('admin.admin')

@section('adminMainContent')
            <!-- User Actions Table -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>User Actions:</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Action</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Since</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Action</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Since</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            @forelse($userActions as $userAction)
                                <tr>
                                    <td> {{$userAction->first_name }} {{$userAction->last_name }} </td>
                                    <td> <a href="/admin/log/actions/{{$userAction->uid }}">View</a> </td>
                                    <td> {{$userAction->contact_email }} </td>
                                    <td> {{$userAction->r_name }} </td>
                                    <td> {{ \Carbon\Carbon::parse($userAction->u_creation_date)->format('d F Y')}} </td>
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
