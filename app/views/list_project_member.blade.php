@extends('layouts.master-child')

@section('page-wrapper')

<div class="row">
    <div class="col-lg-12">
        <h1>Project Management
            <small>List Projects Members </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('') }}"><i class="icon-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="icon-dashboard"></i> Project Management </a></li>
            <li class="active"><i class="icon-file-alt"></i> List Project Members </li>
        </ol>
    </div>
</div><!-- /.row -->

<div class="breadcrumb user-management center-block">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-user"></i> Project Members </h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped tablesorter"  >
                    <thead>
                    <tr>
                        <th> # <i class="fa fa-sort"></i></th>
                        <th> Name <i class="fa fa-sort"></i></th>
                        <th> Develoepr Email <i class="fa fa-sort"></i></th>
                        <th> Created On <i class="fa fa-sort"></i></th>
                        <th> Project Name <i class="fa fa-sort"></i></th>
                        <th> Action</th> 
                    </tr>
                    </thead>
                    <tbody id="project-table">
					<?php
					if(!empty($projectMembers)){
						 $array = 0 ;
						 $index = 1 ;
						 foreach($projectMembers as $result): 
					 ?>
                    <tr>
                        <td>{{ $index }}</td>
                        <td>{{ $Username[$array] }}</td>
                        <td>{{ $result->developer_email }}</td>
                        <td>{{ date('d-m-Y',strtotime($result->created_at)) }}</td>
                        <td>{{ $GetProjectName}}</td>
                        <td> 
                        	<a onclick="DeleteMember('{{ $result->id }}');" class ="btn btn-danger delete-member{{ $result->id }}">Remove</a>
                        </td>
                   </tr>
				   <?php 
				    	$index++;
						$array++;
						endforeach; } else {
					?>
                    <td colspan="6" style="color:#FF0000;">No Developer Found.</td>
                    <?php } ?>
                    </tbody>
                </table>
            </div>    

            
            <!-- <div class="text-right">
                 <a href="#">View All Transactions <i class="fa fa-arrow-circle-right"></i></a>
             </div>-->
        </div>
    </div>
<script type="text/javascript">
function DeleteMember(id)
{
	var td  = $('.delete-member'+id).parent();
	var tr  = td.parent();
	var msg = confirm('Do you want to delete this developer...?');
	if(msg)
	{
		$.ajax({
			type : "POST",
			url  : "{{ URL::action('Webxity\DashboardController@postDeleteMember') }}",
			data : {id:id},
			success : function(d)
			{
				if(d == 1)
				{
					tr.fadeOut('slow');
				}
			}
		});
	} 

}
</script>
</div><!-- form end -->

@stop