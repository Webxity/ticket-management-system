@extends('layouts.master-child')

@section('page-wrapper')


<div class="row">
    <div class="col-lg-12">
        <h1>Project Management
            <small>List Projects </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('') }}"><i class="icon-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="icon-dashboard"></i> Project Management </a></li>
            <li class="active"><i class="icon-file-alt"></i> List Projects </li>
        </ol>
    </div>
</div><!-- /.row -->

<div class="breadcrumb user-management center-block">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-user"></i> Projects </h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped tablesorter"  >
                @if(Auth::user()->role == 'admin') 
                <thead>
                    <tr>
                        <th> # <i class="fa fa-sort"></i></th>
                        <th> Name <i class="fa fa-sort"></i></th>
                        <th> Description <i class="fa fa-sort"></i></th>
                        <th> Created On <i class="fa fa-sort"></i></th>
                        <th>Created By</th>
                        <th> Modify</th> 
                        <th> Action</th> 
                    </tr>
                    </thead>
                    <tbody id="project-table">
                    <?php $id = 1;  ?>
                    @if($AllProjects)
                    <?php $array = 0; ?>                    
                    @foreach($AllProjects as $project)
                    <tr  data-project-id="{{$project->id}}" >
                        <td> <?php echo $id; ?> </td>
                        <td> {{{ $project->project }}}</td>
                        <td> {{{ $project->description }}}</td>
                        <td> {{  date('d-m-Y' , strtotime( $project->created_at))  }}</td>
                        <td> {{ $Username[$array] }}</td>
                        <td><a href="{{{ url('edit-project/'.$project->id )}}}"> Edit </a></td>
                        <td> 
                        	<button class ="btn btn-danger"   data-delete-id="{{$project->id}}"  data-session-id="{{Session::token()}}"  data-page="project" >Remove</button>
                        	<a href="{{ url( 'create-ticket/'. $project->id ) }}"><button class="btn btn-success">Add Task</button></a>
                            <a href="{{ url( 'add-member/'. $project->id ) }}"><button class="btn btn-primary">Add Developer</button></a>
                            <a href="{{ url( 'list-member/'. $project->id ) }}"><button class="btn btn-primary">View Developer</button></a>
                        </td>
                   </tr>
                    <?php 
						$id++; 
						$array++;	
					?>
                    @endforeach
                    @endif
                    </tbody>
                    @else
                    <thead>
                    <tr>
                        <th> # <i class="fa fa-sort"></i></th>
                        <th> Name <i class="fa fa-sort"></i></th>
                        <th> Description <i class="fa fa-sort"></i></th>
                        <th> Created On <i class="fa fa-sort"></i></th>
                        <th> Modify</th> 
                        <th> Action</th> 
                    </tr>
                    </thead>
                    <tbody id="project-table">
                    <?php $id = 1;  ?>
                    @if($projects)                    
                    @foreach($projects as $project)
                    <tr  data-project-id="{{$project->id}}" >
                        <td> <?php echo $id; ?> </td>
                        <td> {{{ $project->project }}}</td>
                        <td> {{{ $project->description }}}</td>
                        <td> {{  date('d-m-Y' , strtotime( $project->created_at))  }}</td>
                        <td><a href="{{{ url('edit-project/'.$project->id )}}}"> Edit </a></td>
                        <td> 
                        	<button class ="btn btn-danger"   data-delete-id="{{$project->id}}"  data-session-id="{{Session::token()}}"  data-page="project" >Remove</button>
                        	<a href="{{ url( 'create-ticket/'. $project->id ) }}"><button class="btn btn-success">Add Task</button></a>
                            <a href="{{ url( 'add-member/'. $project->id ) }}"><button class="btn btn-primary">Add Member</button></a>
                            <a href="{{ url( 'list-member/'. $project->id ) }}"><button class="btn btn-primary">View Member</button></a>
                        </td>
                   </tr>
                    <?php $id++; ?>
                    @endforeach
                    @endif
                    </tbody>
                 @endif   
                </table>
            </div>    

            
            <!-- <div class="text-right">
                 <a href="#">View All Transactions <i class="fa fa-arrow-circle-right"></i></a>
             </div>-->
        </div>
    </div>

</div><!-- form end -->

@stop