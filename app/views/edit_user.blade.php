@extends('layouts.master-child')

@section('page-wrapper')


        <div class="row">
            <div class="col-lg-12">
                <h1>User Management <small>Edit User</small></h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('') }}"><i class="icon-dashboard"></i> Dashboard</a></li>
                     <li><a href="#"><i class="icon-dashboard"></i> User Management </a></li>
                    <li class="active"><i class="icon-file-alt"></i> Edit User </li>
                </ol>
            </div>
        </div><!-- /.row -->

        
          <!-- form start -->
              <!-- Messages After Submit --> 
            
            @if( Session::pull('submit'))
             @if(Input::old())
             <?php
                               $user->name = Input::old('name') ; 
                               $user->email = Input::old('email') ; 
                               $user->role = Input::old('role');
                               $user->passowrd = Input::old('password');
                              ?>
             @endif
             
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
                {{ "User Edited Successfully" }} 
                 </div>

               @endif
            @endif 
               <!-- Messages After Submit --> 
            
         @if($user) 
         <div class="breadcrumb user-management center-block">
            {{ Form::model($user, array('action' => 'Webxity\DashboardController@postEditUser', $user->id))  }}
                <div class="form-group">
                    <label for="username">User Name</label>
                    {{Form::text('name' , $user->name,  array( 'class' => 'form-control')) }}
            </div>
                <div class="form-group">
                    <label for="useremail">Email</label>
                   {{Form::text('email' , $user->email,  array( 'class' => 'form-control')) }}
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                     <input class="form-control"  type="password" name="password" value="<?php echo Input::old('password')?>"  placeholder="Password">
                  
                   
                {{" * Let this field be empty to retain the previous password"}}
                </div>
               <div class="form-group">
                    <label for="user_role">User Role </label>
                   <br/> 
               {{  Form::select('role', [ 'client' => 'Client', 'admin' => 'Admin',  'developer' => 'Developer' , 
                                       'analyst' => 'Business Analyst'], $user->role , ['class' => 'form-control'] )  }}
               {{Form::hidden('id' , $user->id)}}    
               </div> 
              <br/>

                <button type="submit" class="btn btn-default" name="submit">Submit</button>
           {{ Form::close() }}
           
       @endif    
        </div><!-- form end -->


@stop

