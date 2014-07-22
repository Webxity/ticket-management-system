@extends('layouts.master-child')

@section('page-wrapper')
<?php

//Collecting project names
foreach($data as $project): 
$names[$project->project] =  $project->project;     
endforeach; 

?>
<div class="row">
    <div class="col-lg-12">
        <h1>Ticket Management <small>  Create Ticket </small></h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('') }}"><i class="icon-dashboard"></i> Dashboard</a></li>
             <li><a href="#"><i class="icon-dashboard"></i> Ticket Management </a></li>
            <li class="active"><i class="icon-file-alt"></i> Create ticket </li>
        </ol>
    </div>
</div><!-- /.row -->



    <!-- Messages After Submit --> 

    @if( Session::pull('submit'))
      @if( $errors->count() > 0 )
       <div class="alert alert-dismissable alert-danger">
         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
         <p>The following errors have occurred:</p>
         <ul id="form-errors">
         {{ $errors->first('title', '<li>:message</li>') }}
         {{ $errors->first('project', '<li>:message</li>')}}
        </ul>

       </div>
       @else 
         <div class=" alert alert-dismissable alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
           {{ "Ticket Created Successfully " }} 
         </div>

       @endif
    @endif 
       <!-- Messages After Submit --> 

       <div class="breadcrumb user-management center-block">   
           
        {{ Form::open(array('url' => url('create-ticket'))  ) }}
        <div class="form-group">
            <label for="title"> Title </label>
           {{Form::text('title' , Input::old('title'),  array( 'class' => 'form-control', 'placeholder' => 'Title' )) }}

        </div>
        <div class="form-group">
            <label for="description"> Description </label>
             {{Form::textarea('description' ,  Input::old('description'),  
                                      array( 'placeholder' => 'Description Here..' ,  'class' => 'form-control')) }}

        </div>
        <div class="form-group">
            <label for="project"> Project Name </label>

           {{Form::select('project' ,  $names ,Input::old('project'), [  'class' => 'form-control'] ) }}

        </div>   
         <div class="form-group">
            <label for="project"> Priority </label>

           {{Form::select('priority' , 
                                   ['none'=> 'None' , 'low' => 'Low' , 'normal' => 'Normal' , 'high' => 'High' , 'urgent' => 'Urgent' ]
                                    , Input::old('priority'), [  'class' => 'form-control'] 
                                    ) }}

        </div>       
        <div class="form-group">
         <label for="url"> Url </label>
           <div class="form-group input-group"> 
        <span class="input-group-addon"> http:// </span>
        <input type="text" name="url" class="form-control" placeholder="Optional Url"  
                                           value="{{{Input::old('url')}}}" />
           </div>
        </div>
    <button type="submit" class="btn btn-default" name="submit">Create</button>
   {{ Form::close() }}
</div><!-- form end -->




@stop

