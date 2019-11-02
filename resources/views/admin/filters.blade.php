@extends('admin.admin')

@section('adminMainContent')
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-damages-tab" data-toggle="tab" href="#nav-damages" role="tab" aria-controls="nav-damages" aria-selected="true">Damage Type</a>
            <a class="nav-item nav-link" id="nav-location-tab" data-toggle="tab" href="#nav-location" role="tab" aria-controls="nav-location" aria-selected="false">Location</a>
            <a class="nav-item nav-link" id="nav-incident-tab" data-toggle="tab" href="#nav-incident" role="tab" aria-controls="nav-incident" aria-selected="false">Incident Type</a>
            <a class="nav-item nav-link" id="nav-infrastructure-tab" data-toggle="tab" href="#nav-infrastructure" role="tab" aria-controls="nav-infrastructure" aria-selected="false">Infrastructure</a>
        </div>
    </nav>


    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-damages" role="tabpanel" aria-labelledby="nav-damages-tab">

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Damage Type
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer small text-muted">
                    Updated yesterday at 11:59 PM
                </div>
            </div>

        </div> <!-- id nav damages -->


        <div class="tab-pane fade" id="nav-location" role="tabpanel" aria-labelledby="nav-location-tab">

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Location
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer small text-muted">
                    Updated yesterday at 11:59 PM
                </div>
            </div>

        </div> <!-- id nav location -->


        <div class="tab-pane fade" id="nav-incident" role="tabpanel" aria-labelledby="nav-incident-tab">

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Incident Type
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer small text-muted">
                    Updated yesterday at 11:59 PM
                </div>
            </div>

        </div> <!-- id nav incident -->


        <div class="tab-pane fade" id="nav-infrastructure" role="tabpanel" aria-labelledby="nav-infrastructure-tab">

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Infrastructure
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer small text-muted">
                    Updated yesterday at 11:59 PM
                </div>
            </div>

        </div> <!-- id nav infrastructure -->


    </div>  <!-- nav-tabContent  -->
@endsection
