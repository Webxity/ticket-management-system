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
                <table class="table table-bordered table-hover table-striped tablesorter" >
                    <thead>
                    <tr>
                        <th> # <i class="fa fa-sort"></i></th>
                        <th> Name <i class="fa fa-sort"></i></th>
                        <th> Description <i class="fa fa-sort"></i></th>
                        <th> Created On <i class="fa fa-sort"></i></th>
                        <th> Modify</th> 
                        <th> Delete</th> 
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
                        <td> {{  Webxity\HelperFunc::get_date($project->created_at )  }}</td>
                        <td><a href="{{{ url('edit-project/'.$project->id )}}}"> Edit </a></td>
                        <td> <button    class ="btn btn-danger"   data-delete-id="{{$project->id}}"  data-session-id="{{Session::token()}}"  data-page="project" >Remove</button></td>
                   </tr>
                    <?php $id++; ?>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>    

            
            <!-- <div class="text-right">
                 <a href="#">View All Transactions <i class="fa fa-arrow-circle-right"></i></a>
             </div>-->
        </div>
    </div>

</div><!-- form end -->

@stop