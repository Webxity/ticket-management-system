@extends('layouts.master-child')

@section('page-wrapper')
<div class="row">
  <div class="col-lg-12">
    <h1>Ticket Management <small>List Tickets </small> </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('') }}"><i class="icon-dashboard"></i> Dashboard</a></li>
      <li id="ticket_bread"><a href="#"><i class="icon-dashboard"></i> Ticket Management </a></li>
      <li class="active"><i class="icon-file-alt"></i> List Tickets </li>
    </ol>
  </div>
</div>
<!-- /.row -->

<!-- Client ticket Start -->

@if(Auth::user()->role == 'client')
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
              <th> Task <i class="fa fa-sort"></i></th>
              <th> Project Name <i class="fa fa-sort"></i></th>
              <th> Priority <i class="fa fa-sort"></i></th>
              <th> Status <i class="fa fa-sort"></i></th>
              <th>Due Date</th>
              <th>Created On</th>
              <th> Modify </th>
              <th> Delete </th>
            </tr>
          </thead>
          <tbody id="project-table" >
          
          @if(!empty($tickets))
          <?php $id = 1;  ?>
          @if($tickets)
          @foreach($tickets as $ticket)
          <tr>
            <td><?php echo $id; ?> </td>
            <td><a href = "{{url('show-ticket/'.$ticket->id)}}">{{{ $ticket->title }}} </a></td>
            <td> {{{ $ticket->project }}}</td>
            <td> {{{ $ticket->priority }}} </a></td>
            @if($ticket->status == 'open')
            <td><span class="btn btn-primary">{{{ $ticket->status  }}}</span></td>
            @else
            <td><span class="btn btn-success">{{{ $ticket->status  }}}</span></td>
            @endif
            <td> {{ date('d-m-Y',strtotime($ticket->due_date)) }} </td>
            <td> {{ date('d-m-Y',strtotime($ticket->created_at)); }} </td>
            <td><a href="{{{ url('edit-ticket/'.$ticket->id )}}}"> Edit </a></td>
            <td><button    class ="btn btn-danger"  data-page="ticket"  data-delete-id="{{$ticket->id}}"  data-session-id="{{Session::token()}}" >Remove</button></td>
          </tr>
          <?php $id++; ?>
          @endforeach
          @endif
          @else
          <td colspan="9" style="color: red;">No Ticket Found.</td>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endif     
    
<!-- Client ticket End -->
<!-- Client ticket Admin -->                        
                        
@elseif(Auth::user()->role == 'admin')
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
              <th> Task <i class="fa fa-sort"></i></th>
              <th> Project Name <i class="fa fa-sort"></i></th>
              <th> Priority <i class="fa fa-sort"></i></th>
              <th> Status <i class="fa fa-sort"></i></th>
              <th>Due Date</th>
              <th>Created On</th>
              <th> Modify </th>
              <th> Delete </th>
            </tr>
        </thead>
          <tbody id="project-table" >
                              
          @if(!empty($GetAllTickets))
          <?php $id = 1;  ?>
          @if($GetAllTickets)
          @foreach($GetAllTickets as $ticket)
          <tr>
            <td><?php echo $id; ?> </td>
            <td><a href = "{{url('show-ticket/'.$ticket->id)}}">{{{ $ticket->title }}} </a></td>
            <td> {{{ $ticket->project }}}</td>
            <td> {{{ $ticket->priority }}} </a></td>
            @if($ticket->status == 'open')
            <td><span class="btn btn-primary">{{{ $ticket->status  }}}</span></td>
            @else
            <td><span class="btn btn-success">{{{ $ticket->status  }}}</span></td>
            @endif
            <td> {{ date('d-m-Y',strtotime($ticket->due_date)) }} </td>
            <td> {{ date('d-m-Y',strtotime($ticket->created_at)); }} </td>
            <td><a href="{{{ url('edit-ticket/'.$ticket->id )}}}"> Edit </a></td>
            <td><button    class ="btn btn-danger"  data-page="ticket"  data-delete-id="{{$ticket->id}}"  data-session-id="{{Session::token()}}" >Remove</button></td>
          </tr>
          <?php $id++; ?>
          @endforeach
          @endif
          @else
          <td colspan="9" style="color: red;">No Ticket Found.</td>
        </tbody>
      </table>
      @endif 
     </div>
    </div>
  </div>
</div>
@endif

<!-- Admin ticket End -->
<!-- Developer ticket  -->
                   
@if(Auth::user()->role == 'developer')
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
              <th> Task <i class="fa fa-sort"></i></th>
              <th> Project Name <i class="fa fa-sort"></i></th>
              <th> Priority <i class="fa fa-sort"></i></th>
              <th> Status <i class="fa fa-sort"></i></th>
              <th>Due Date</th>
              <th>Assign date</th>
              <th> Action </th>
            </tr>
          </thead>
          <tbody id="project-table" >                           
          @if(!empty($developer_task))
          <?php 
            $index = '';    
            foreach($developer_task as $ticket): 
            $index++;
          ?>
          <tr>
            <td>{{ $index }}</td>
            <td><a href = "{{url('show-ticket/'.$ticket->id)}}">{{ $ticket->title }}</a></td>
            <td>{{ $ticket->project }}</td>
            <td>{{ $ticket->priority }}</td>
            @if($ticket->status == 'open')
                <td><span class="btn btn-primary">{{ $ticket->status }}</span></td>
            @else
                <td><span class="btn btn-success">{{ $ticket->status }}</span></td>
            @endif
            <td>{{ $ticket->due_date }}</td>
            <td>{{ date('d-m-Y',strtotime($ticket->created_at)) }}</td>
            @if($ticket->status == 'open')
            <td>
                <a style="cursor: pointer;" onclick="UpdateTicketStatus('{{ $ticket->id }}');" id="{{ $ticket->status }}_{{$ticket->owner_id}}" class="Status{{ $ticket->id }} btn btn-default">
                    Mark as Submit
                </a>
            </td>
            @else
            <td>
                <a style="cursor: pointer;" onclick="UpdateTicketStatus('{{ $ticket->id }}');" id="{{ $ticket->status }}_{{$ticket->owner_id}}" class="Status{{ $ticket->id }} btn btn-primary">
                    Re-open Project
                </a>
            </td>
            @endif
         </tr>
          <?php endforeach; ?>
          @else
          <tr>
            <td colspan="8" style="color: red;">No Task Found.</td>
          </tr>
          @endif
          </tbody>   
        </table>
     </div>
    </div>
  </div>
</div>
@endif
<!-- Developer ticket End -->  
<script type="text/javascript">
function UpdateTicketStatus(rowid)
{
  var status = $('.Status'+rowid).attr('id');  
  var msg = confirm('Do you want to confirm submit this project.');
  
  if(msg)
  {
    $.ajax({ 
        type:"POST",
        url:"{{ URL::action('Webxity\DashboardController@postUpdateTicketStatus') }}",
        data:{rowid:rowid,status:status},
        success:function(d)
        {
            document.location.reload(true);  
        }  
    });   
    return true
  }
  else
  {
    return false;
  }
        
}    
</script>                
@stop