@extends('layouts.master-child')

@section('page-wrapper')

<div class="row">
    <div class="col-lg-12">
        <h1>Ticket Management
            <small>List Tickets </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('') }}"><i class="icon-dashboard"></i> Dashboard</a></li>
            <li id="ticket_bread"><a href="#"><i class="icon-dashboard"></i> Ticket Management </a></li>
            <li class="active"><i class="icon-file-alt"></i> List Tickets </li>
        </ol>
    </div>
</div><!-- /.row -->

<div class="breadcrumb user-management center-block">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-user"></i> Tickets </h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped tablesorter">
                    <thead>
                    <tr>
                        <th> # <i class="fa fa-sort"></i></th>
                        <th> Title <i class="fa fa-sort"></i></th>
                        <th> Project Name <i class="fa fa-sort"></i></th>
                        <th> Priority <i class="fa fa-sort"></i></th>
                        <th> Status <i class="fa fa-sort"></i></th>
                        <th> Created On <i class="fa fa-sort"></i></th>
                        <th> Updated On <i class="fa fa-sort"></i></th> 
                        <th> Modify </th>
                        <th> Delete </th>
                    </tr>
                    </thead>
                    <tbody id="project-table" >
                    <?php $id = 1;  ?>
                    @if($tickets)
                    @foreach($tickets as $ticket)
                    <tr>
                        <td> <?php echo $id; ?> </td>
                        <td> <a href = "{{url('show-ticket/'.$ticket->id)}}">{{{ $ticket->title }}} </a></td>
                        <td> {{{ $ticket->project }}}</td>
                        <td> {{{ $ticket->priority }}} </a></td>
                        <td> {{{ $ticket->status  }}}</td>
                        <td> {{  Webxity\HelperFunc::get_date($ticket->created_at )  }}</td>
                        <td> 
                            @if ( $ticket->created_at != $ticket->updated_at )
                                {{ Webxity\HelperFunc::get_date($ticket->updated_at )  }} 
                                @else 
                                Not Updated 
                            @endif 
                        </td>
                        <td><a href="{{{ url('edit-ticket/'.$ticket->id )}}}"> Edit </a></td>
                        <td> <button    class ="btn btn-danger"  data-page="ticket"  data-delete-id="{{$ticket->id}}"  data-session-id="{{Session::token()}}" >Remove</button></td>
                    </tr>
                    <?php $id++; ?>
                    @endforeach
                    @endif
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

</div><!-- form end -->
@stop