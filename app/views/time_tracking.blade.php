@extends('layouts.master-child')

@section('page-wrapper')

<div class="row">
    <div class="col-lg-12">
        <h1>Time Tracking
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('') }}"><i class="icon-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="icon-dashboard"></i> Time Tracking </a></li>
        </ol>
    </div>
</div>

<div class="breadcrumb user-management center-block">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-user"></i> Login History </h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped tablesorter">
                    <thead>
                    <tr>
                        <th> # </th>
                        <th> User Name </th>
                        <th> Login Time </th>
                        <th> Logout Time </th>
                        <th> Login Date </th>
                        <th> Logout Date </th>
                        <th> Total Duration</th>
                    </tr>
                    </thead>
                    <tbody id="project-table" >
                    <?php 
						$index = '';
						foreach($LoginHistory as $result): 
						$index++;
					?>
                        <tr>
                            <td> {{ $index }}</td>
                            <td> {{ Auth::user()->getName() }}</td>
                            <td> {{ date('h:i A',strtotime($result->login_time)) }}</td>
                            <?php 
								if($result->logout_time !== '0000-00-00 00:00:00'){ 
								$date = new DateTime($result->login_time);
								$diff = $date->diff(new DateTime($result->logout_time));
								
								if($diff->h !=='0' || $diff->i !=='0' || $diff->s == '0')
								{
									$hour    =  $diff->h;
									$minute  =	$diff->i;
									$second	 =	$diff->s;
								}
								else
								{
									$hour    =  '0';
									$minute  =	'0';
									$second	 =	'0';
								}
								
							?>
                            <td> {{ date('h:i A',strtotime($result->logout_time)) }} </td>
                            <td>{{ date('d-M-Y',strtotime($result->login_time)) }}</td>
                            <td>{{ date('d-M-Y',strtotime($result->logout_time)) }}</td>
                            <td>
                            {{ $hour }}  Hours
                            
                            @if ( $minute > 0 )
                             {{ $minute }} Min
                            
                            {{ $second }} Sec
                            @endif  
                            </td>
                            <?php }else { ?>
                            
                            <td  colspan="4" style="color:#CC3300; text-align:center; background:#CCFF99;"><b>Currently Login</b></td>
                            <?php } ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
                    <!--  Code for Toggle button
                    <div class="btn-group" data-toggle="buttons">

                    <label class="btn btn-primary">
                    <input type="checkbox"> Option 3
                    </label>
                    </div> -->       

            
            <!-- <div class="text-right">
                 <a href="#">View All Transactions <i class="fa fa-arrow-circle-right"></i></a>
             </div>-->
        </div>
    </div>

</div>
@stop