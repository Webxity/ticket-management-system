@extends('layouts.master-child')

@section('page-wrapper')

        <div class="row">
            <div class="col-lg-12">
                <h1>Project<small style="margin-left:10px;">Add Member</small></h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('') }}"><i class="icon-dashboard"></i> Dashboard</a></li>
                    <li><a href="#"><i class="icon-dashboard"></i> Project </a></li>
                    <li class="active"><i class="icon-file-alt"></i> Add Member </li>
                </ol>
            </div>
        </div><!-- /.row -->

              @if( Session::pull('submit'))
                  @if(empty(Session::has('message')))
                      @if( $errors->count() > 0 )
                       <div class="alert alert-dismissable alert-danger">
                         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                         <p>The following errors have occurred:</p>
                         <ul id="form-errors">
                         {{ $errors->first('email', '<li>:message</li>')}}                 
                         </ul>
                        
                       </div>
                       @else 
                         <div class=" alert alert-dismissable alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ "Developer Added Successfully" }} 
                         </div>
                       @endif
                   @else    
                   <div class="alert alert-dismissable alert-danger">
                         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                         <p>The following errors have occurred:</p>
                         <ul id="form-errors">
                         <li>{{ Session::get('message') }}</li>                 
                         </ul>
                        
                   </div>
                   @endif
            @endif

               <!-- Messages After Submit --> 
               
                 <div class="breadcrumb user-management center-block">
               
               {{ Form::open(array('action' => 'Webxity\DashboardController@postAddMember' , $project_id) ) }}
                <div class="form-group">
                    <label for="username">Developer Email</label>
                   {{Form::email('email' , Input::old('email'),  array( 'class' => 'form-control', 'placeholder' => 'email')) }}
                </div>
               
               {{  Form::hidden('project_id' , $project_id )  }}
               
               <button type="submit" class="btn btn-default" name="submit"> Add Member </button>
           {{ Form::close() }}
        </div><!-- form end -->

@stop

