@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Action  Type
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($actionType, ['route' => ['actionTypes.update', $actionType->id], 'method' => 'patch']) !!}

                        @include('action__types.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection