@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            User  Groups
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($userGroups, ['route' => ['userGroups.update', $userGroups->id], 'method' => 'patch']) !!}

                        @include('user__groups.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection