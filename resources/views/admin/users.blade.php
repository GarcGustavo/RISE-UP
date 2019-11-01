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
            <!-- Activities Table -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Activities</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Activity</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Creation date</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Activity</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Creation date</th>
                            </tr>
                            </tfoot>
                            <tbody>


                            @forelse($users as $user)
                            <tr>
                                <td> {{$user->first_name }} {{$user->last_name }} </td>
                                <td> xxx </td>
                                <td> {{$user->contact_email }} </td>
                                <td> {{$user->r_name }} </td>
                                <td> {{$user->u_creation_date }} </td>
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
        </div>
        <div class="tab-pane fade" id="nav-requests" role="tabpanel" aria-labelledby="nav-requests-tab">

            <!-- Requests Table -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>Requesting to Collaborate:</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Expiration date</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Expiration date</th>
                            </tr>
                            </tfoot>
                            <tbody>

                            <tr>
                                <td>Donna Snider</td>
                                <td>donna.snider@gmail.com</td>
                                <td>Viewer</td>
                                <td>2011/01/25</td>
                            </tr>

                            <tr>
                                <td>Tiger Nixon</td>
                                <td>tiger.nixon@gmail.com</td>
                                <td>Viewer</td>
                                <td>2011/04/25</td>
                            </tr>

                            <tr>
                                <td>Garrett Winters</td>
                                <td>garret.winters@gmail.com</td>
                                <td>Viewer</td>
                                <td>2011/07/25</td>
                            </tr>

                            <tr>
                                <td>Brielle Williamson</td>
                                <td>brielle.williamson@gmail.com</td>
                                <td>Viewer</td>
                                <td>2012/12/02</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
        </div>
    </div>
@endsection
