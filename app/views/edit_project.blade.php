@extends('layouts.master-child')

@section('page-wrapper')

        <div class="row">
            <div class="col-lg-12">
                <h1>Project Management <small>  Edit Project </small></h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('') }}"><i class="icon-dashboard"></i> Dashboard</a></li>
                     <li><a href="#"><i class="icon-dashboard"></i> Project Management </a></li>
                    <li class="active"><i class="icon-file-alt"></i> Edit Project </li>
                </ol>
            </div>
        </div><!-- /.row -->

      
          
        <!-- Messages After Submit -->
           <?php $msg = Session::pull('messages'); ?>
             @if(isset($msg))
             
               
                   @if($msg == "Record Successfully Updated")
                     <div class=" alert alert-dismissable alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ $msg }}
                     </div>
                   @else
                       <div class="alert alert-dismissable alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ $msg  }}
                       </div>
                   @endif

             @endif   
            <!-- Messages After Submit --> 
            
            
            
          @if($project) 
          <!-- form start -->  
          <div class="breadcrumb project-management center-block">
            {{ Form::model($project , array('action' => 'Webxity\DashboardController@postEditProject', $project->id))  }}
                <div class="form-group">
                    <label for="title"> Project Name </label>
                    {{Form::text('project' ,$project->project,  array( 'class' => 'form-control')) }}
                </div>
              
                <div class="form-group">
                    <label for="description"> Description </label>
                   {{Form::textarea('description' , $project->description,  array( 'class' => 'form-control')) }}
                </div>
              
                {{Form::hidden('id' , $project->id)}}    
           
              <br/>

                <button type="submit" class="btn btn-default" name="submit">Edit</button>
           {{ Form::close() }}
           
       @endif    
        </div><!-- form end -->
@stop