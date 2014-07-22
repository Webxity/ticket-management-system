@extends('layouts.master-child')

@section('page-wrapper')

        <div class="row">
            <div class="col-lg-12">
                <h1>Project Management <small>Add Project</small></h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('') }}"><i class="icon-dashboard"></i> Dashboard</a></li>
                     <li><a href="#"><i class="icon-dashboard"></i> Project Management </a></li>
                    <li class="active"><i class="icon-file-alt"></i> Add Project </li>
                </ol>
            </div>
        </div><!-- /.row -->
  
    
            
            <!-- Messages After Submit --> 
            
            @if( Session::pull('submit'))
              @if( $errors->count() > 0 )
               <div class="alert alert-dismissable alert-danger">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <p>The following errors have occurred:</p>
                {{ $errors->first('project', '<p>:message</p>') }}
             </div>
               @else 
                 <div class=" alert alert-dismissable alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ "Project Created Successfully" }} 
                 </div>

               @endif
            @endif 
               <!-- Messages After Submit --> 
               
        <div class="breadcrumb user-management center-block">
               
               {{ Form::open(array('action' => 'Webxity\DashboardController@postAddProject') ) }}
                <div class="form-group">
                    <label for="project"> Project Name</label>
                   {{Form::text('project' , Input::old('project'),  array( 'class' => 'form-control', 'placeholder' => 'Project Name')) }}
                </div>
                <div class="form-group">
                    <label for="description"> Description </label>
                   {{ Form::textarea('description' , Input::old('description'),  array( 'class' => 'form-control', 'placeholder' => 'Description')) }}
                </div>
               
               <button type="submit" class="btn btn-default" name="submit"> Create </button>
           {{ Form::close() }}
        </div><!-- form end -->

@stop

