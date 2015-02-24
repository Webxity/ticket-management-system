@extends('layouts.master-child')

@section('page-wrapper')

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
    	@if(empty(Session::has('Message')))
             <div class=" alert alert-dismissable alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               {{ Session::get('msg') }} 
             </div>
        @else
        	<div class=" alert alert-dismissable alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               {{ Session::get('Message') }} 
             </div>
        @endif     
    @endif 
       <!-- Messages After Submit --> 

       <div class="breadcrumb user-management center-block">   
           
        {{ Form::open(array('url' => url('create-ticket/'.$project_id))  ) }}
        
        <div class="form-group">
            <label for="project"> Project Name </label>

           {{Form::text('project', $project , array('class' => 'form-control' , 'readonly' => 'readonly')) }}

        </div>
        
        <div class="form-group">
            <label for="title"> Task </label>
           {{Form::text('title' , Input::old('title'),  array( 'class' => 'form-control', 'placeholder' => 'Title' , 'required' => 'required' )) }}

        </div>
        <div class="form-group">
            <label for="description"> Description </label>
             {{Form::textarea('description' ,  Input::old('description'),  
                                      array( 'placeholder' => 'Description Here..' ,  'class' => 'form-control' , 'required' => 'required' )) }}

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
        <input type="text" name="url" class="form-control" placeholder="Optional Url" />
           </div>
        </div>
        
        <div class="form-group">
            <label>Due Date</label>
            <div class="form-group">
                <input type="text" name="due_date" class="form-control" id="datepicker" />
            </div>
        </div>
        
        <div class="form-group">
         <label for="url">Developer</label>
           <div class="form-group"> 
                <select name="developer[]" class="form-control" readonly multiple="multiple" required>
                  <?php 
				  	if(!empty($getDeveloper)){ 	
						foreach($getDeveloper as $result): 
				   ?>	
                    <option value="<?php echo $result->developer_email ?>" selected="selected"><?php echo $result->developer_email; ?></option>
                  <?php 
				  		endforeach; 
					}else{	
				  ?>
                    <option value="">No Developer in this Project</option>
                  <?php } ?>
                </select>
           </div>
        </div>
        
    <button type="submit" class="btn btn-default" name="submit">Create</button>
   {{ Form::close() }}
</div><!-- form end -->

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
        $( "#datepicker" ).datepicker();
</script>


@stop

