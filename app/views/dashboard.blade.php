@extends('layouts.master-child')

@section('page-wrapper')
<div class="row">
    <div class="col-lg-12">
        <h1>Dashboard
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
        </ol>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Welcome to Ticket Managment system created by <a class="alert-link" href="http://webxity.com">Webxity technologies</a>!
        </div>
    </div>
</div><!-- /.row -->



<div class="row">
    
 <div class="col-lg-10">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-money"></i> Recent Tickets</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped tablesorter">
                        <thead>
                        <tr>
                            <th>Ticket # <i class="fa fa-sort"></i></th>
                            <th>Title <i class="fa fa-sort"></i></th>
                            <th>Status <i class="fa fa-sort"></i></th>
                            <th>Priority <i class="fa fa-sort"></i></th>
                            <th>Created At <i class="fa fa-sort"></i></th>
                            <th>Updated At <i class="fa fa-sort"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                   @if( count($data['tickets']) > 0 ) 
                     @foreach($data['tickets'] as $tickets)      
                        <tr>
                            <td>{{$tickets->id}}</td>
                            <td>{{{$tickets->title}}}</td>
                            <td>{{{$tickets->status}}}</td>
                            <td>{{{$tickets->priority}}}</td>
                            <td>{{  Webxity\HelperFunc::get_date($tickets->created_at )  }}</td>
                           <td> 
                            @if ( $tickets->created_at != $tickets->updated_at )
                                {{ Webxity\HelperFunc::get_date($tickets->updated_at )  }} 
                                @else 
                                Not Updated 
                            @endif 
                        </td>
                        </tr>
                      @endforeach
                   @endif  
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    <a href="{{url('list-tickets')}}">View All Tickets <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    
    
     <div class="col-lg-10">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-file"></i> Recent Projects</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped tablesorter">
                        <thead>
                        <tr>
                            <th>Project # <i class="fa fa-sort"></i></th>
                            <th>Name <i class="fa fa-sort"></i></th>
                            <th>Started At <i class="fa fa-sort"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                   @if( count($data['projects']) > 0 ) 
                     @foreach($data['projects'] as $projects)      
                        <tr>
                            <td>{{$projects->id}}</td>
                            <td>{{{$projects->project}}}</td>
                           <td> {{  Webxity\HelperFunc::get_date($projects->created_at )  }}</td>
                        </tr>
                      @endforeach
                   @endif  
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    <a href="{{url('list-projects')}}">View All Projects <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    
    
</div><!-- /.row -->
@stop