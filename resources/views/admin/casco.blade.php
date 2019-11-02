@extends('admin.admin')

@section('adminMainContent')

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-damages-tab" data-toggle="tab" href="#nav-damages" role="tab" aria-controls="nav-damages" aria-selected="true">Users</a>
            <a class="nav-item nav-link" id="nav-location-tab" data-toggle="tab" href="#nav-location" role="tab" aria-controls="nav-location" aria-selected="false">Requests</a>
            <a class="nav-item nav-link" id="nav-date-tab" data-toggle="tab" href="#nav-date" role="tab" aria-controls="nav-date" aria-selected="false">Requests</a>
        </div>
    </nav>


    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-damages" role="tabpanel" aria-labelledby="nav-damages-tab">
        </div> <!-- id nav damages -->


        <div class="tab-pane fade" id="nav-location" role="tabpanel" aria-labelledby="nav-location-tab">
        </div> <!-- id nav location -->

        <div class="tab-pane fade" id="nav-date" role="tabpanel" aria-labelledby="nav-date-tab">
        </div> <!-- id nav date -->
    </div>  <!-- nav-tabContent  -->

@endsection



<!-- esto va dentro de cada tab-pane -->
<div class="card mb-3">
    <div class="card-header">
        <i class="fas fa-table"></i>
        casco
    </div>
    <div class="card-body">

    </div>
    <div class="card-footer small text-muted">
        Updated yesterday at 11:59 PM
    </div>
</div>
