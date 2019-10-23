@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            C S  Parameter
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($cSParameter, ['route' => ['cSParameters.update', $cSParameter->id], 'method' => 'patch']) !!}

                        @include('c_s__parameters.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection