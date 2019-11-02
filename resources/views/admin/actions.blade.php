@extends('admin.admin')

@section('adminMainContent')
            <!-- Filters -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    {{$usersName[0]->first_name }} {{$usersName[0]->last_name }} Actions
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr class="text-center">
                                <th>Action</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr class="text-center">
                                <th>Action</th>
                                <th>Date</th>
                            </tr>
                            </tfoot>
                            <tbody>
                                @forelse($actions as $action)
                                    <tr>
                                        <td> {{$action->act_name }} </td>
                                        <td> {{ \Carbon\Carbon::parse($action->a_date)->format('d F Y')}} </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>No Actions</td>
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
