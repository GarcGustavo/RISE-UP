@extends('admin.admin')

@section('adminMainContent')
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-users-tab" data-toggle="tab" href="#nav-users" role="tab" aria-controls="nav-users" aria-selected="true">Users</a>
            <a class="nav-item nav-link" id="nav-requests-tab" data-toggle="tab" href="#nav-requests" role="tab" aria-controls="nav-requests" aria-selected="false">Requests</a>
        </div>
    </nav>



    <div class="tab-content" id="nav-tabContent">


        <div class="tab-pane fade show active" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab">
            <!-- Users Table -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Since</th>
                                <th>Until</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Since</th>
                                <th>Until</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            @forelse($users as $user)
                            <tr>
                                <td> {{$user->first_name }} {{$user->last_name }} </td>
                                <td> {{$user->contact_email }} </td>
                                <td> {{$user->r_name }} </td>
                                <td> {{ \Carbon\Carbon::parse($user->u_creation_date)->format('d F Y')}} </td>
                                <td> {{ \Carbon\Carbon::parse($user->u_expiration_date)->format('d F Y')}} </td>
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
                <div class="card-footer small text-muted">
                    Updated yesterday at 11:59 PM
                </div>
            </div>
        </div> <!-- id nav user -->


        <div class="tab-pane fade" id="nav-requests" role="tabpanel" aria-labelledby="nav-requests-tab">
            <!-- Requests Table -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>Requesting to Collaborate:</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th></th>
                            </tr>
                            </tfoot>
                            <tbody>

                            @forelse($requests as $request)
                                <tr>
                                    <td> {{$request->first_name }} {{$request->last_name }} </td>
                                    <td> {{$request->contact_email }} </td>
                                    <td> {{$request->r_name }} </td>
                                    <td>

                                        <button type="submit" class="btn btn-primary">Approve</button>

                                    </td>
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
                <div class="card-footer small text-muted">
                    Updated yesterday at 11:59 PM
                </div>
            </div>
        </div> <!-- id nav requests -->


    </div>  <!-- nav-tabContent  -->
@endsection
