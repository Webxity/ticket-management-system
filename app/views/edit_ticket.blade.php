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
        <h1>Ticket Management <small>  Edit Ticket </small></h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('') }}"><i class="icon-dashboard"></i> Dashboard</a></li>
             <li><a href="#"><i class="icon-dashboard"></i> Ticket Management </a></li>
            <li class="active"><i class="icon-file-alt"></i> Edit ticket </li>
        </ol>
    </div>
</div><!-- /.row -->


  
<!-- Messages After Submit --> 

    @if( Session::pull('submit'))
     @if(Input::old())
     <?php
                       $ticket->title = Input::old('title') ; 
                       $ticket->description = Input::old('description') ; 
                       $ticket->status = Input::old('status');
                       $ticket->priority = Input::old('priority');
                       $ticket->project = Input::old('project');
                       $ticket->url = Input::old('url');  
                      ?>
     @endif
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
           {{ "Ticket Edited Successfully " }} 
         </div>

       @endif
    @endif 
               
       
    <!-- form start -->
   <div class="breadcrumb ticket-management center-block">
    {{ Form::model($ticket, array('action' => 'Webxity\DashboardController@postEditTicket', $ticket->id))  }}
        <div class="form-group">
            <label for="title"> Title </label>
            {{Form::text('title' ,$ticket->title ,  array( 'class' => 'form-control')) }}
        </div>
        @if ( Auth::user()->role == 'admin') 
           <div class="form-group">
              <label for="status"> Status </label>
                 {{  Form::select('status', array('open' => 'Open','close' => 'Close'), 
                                                   $ticket->status  , 
                                               array('class' => 'form-control') )  ;  }}  
           </div>
        @endif
        <div class="form-group">
            <label for="ticketdescription"> Description </label>
           {{Form::textarea('description' , $ticket->description ,  array( 'class' => 'form-control')) }}
        </div>
        <div class="form-group">
            <label for="project"> Project Name </label>
           {{Form::select('project' ,  $names ,$ticket->project, [  'class' => 'form-control'] ) }}

        </div>
        <div class="form-group">
            <label for="project"> Priority </label>

             {{Form::select('priority' , 
                                   ['None'=> 'None' , 'Low' => 'Low' , 'Normal' => 'Normal' , 'High' => 'High' , 'Urgent' => 'Urgent' ]
                                    , $ticket->priority , [  'class' => 'form-control'] 
                                    ) }}
        </div>
      <div class="form-group">
         <label for="url"> Url </label>
           <div class="form-group input-group"> 
        <span class="input-group-addon"> http:// </span>
        <input type="text" name="url" class="form-control" placeholder="Optional Url"  
                                           value="{{{$ticket->url}}}" />
           </div>
       </div>
      <br/>

        <button type="submit" class="btn btn-default"  name="submit">Edit</button>
   {{Form::hidden('id' , $ticket->id )}}     
   {{ Form::close() }}


</div><!-- form end -->
@stop