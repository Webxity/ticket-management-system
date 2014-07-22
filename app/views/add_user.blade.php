@extends('layouts.master-child')

@section('page-wrapper')

        <div class="row">
            <div class="col-lg-12">
                <h1>User Management <small>Add User</small></h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('') }}"><i class="icon-dashboard"></i> Dashboard</a></li>
                     <li><a href="#"><i class="icon-dashboard"></i> User Management </a></li>
                    <li class="active"><i class="icon-file-alt"></i> Add User </li>
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
                 {{ $errors->first('name', '<li>:message</li>') }}
                 {{ $errors->first('password', '<li>:message</li>')}}
                 {{ $errors->first('email', '<li>:message</li>')}}
                 {{ $errors->first('role', '<li>:message</li>')}}
                 
                 </ul>
                
               </div>
               @else 
                 <div class=" alert alert-dismissable alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ "User Created Successfully" }} 
                 </div>

               @endif
            @endif 
               <!-- Messages After Submit --> 
               
                 <div class="breadcrumb user-management center-block">
               
               {{ Form::open(array('action' => 'Webxity\DashboardController@postAddUser') ) }}
                <div class="form-group">
                    <label for="username">User Name</label>
                   {{Form::text('name' , Input::old('name'),  array( 'class' => 'form-control', 'placeholder' => 'Name')) }}
                </div>
                <div class="form-group">
                    <label for="useremail">Email</label>
                   {{ Form::email('email' , Input::old('email'),  array( 'class' => 'form-control', 'placeholder' => 'Email')) }}
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control"  type="password" name="password" value="<?php echo Input::old('password')?>"  placeholder="Password">
                  
                </div>
               <div class="form-group">
                    <label for="user_role">User Role </label>
                   <br/> 
               {{  Form::select('role', [ 'client' => 'Client', 'admin' => 'Admin',  'developer' => 'Developer' , 
                                       'analyst' => 'Business Analyst'], Input::old('role') , ['class' => 'form-control', 'placeholder' => 'Role'] )  }}
              
               </div> 
               <button type="submit" class="btn btn-default" name="submit"> Create </button>
           {{ Form::close() }}
        </div><!-- form end -->

@stop

