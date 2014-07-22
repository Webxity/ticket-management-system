@extends('layouts.master-child')

@section('page-wrapper')

<div class="row">
    <div class="col-lg-12">
        <h1>Ticket Management
            <small>Show Tickets </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('') }}"><i class="icon-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="icon-dashboard"></i> Ticket Management </a></li>
            <li class="active"><i class="icon-file-alt"></i> Show Tickets </li>
        </ol>
    </div>
</div><!-- /.row -->

<div class="breadcrumb user-management center-block">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-user"></i> {{ $ticket->title }} </h3>
        </div>
        <div class="panel-body">
          
         
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
              <h3 id="container">Description</h3>
            </div>
             @if( $ticket->description  === "" )
                   <div class="alert alert-dismissable alert-info" id="not-available">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    No Description Available. 
                    </div>
            @endif  
            <div class="bs-example">
              <div class="jumbotron">
                @if( $ticket->description  !== "" )
                  <p> 
                    
                   {{{   $ticket->description  }}}
                  </p>
               @endif    
                    
                @if( $ticket->url  !== "" )
                <h1> Reference Url </h1>

                    <p>
                        <a href="http://{{{   $ticket->url  }}}"> http://{{{   $ticket->url  }}}  </a>   

                    </p>
                @endif 
                 </div>
              </div>
            </div>
          </div> <!-- /.row -->
        
            <div class="page-header">
              <h3 id="container">Conversation</h3>
            </div>
            
            
         <div id="convo-box">
           @if(count ( $convo_msg) > 0 )
            @foreach($convo_msg as $convo) 
             <blockquote class ="convo-message">
                
              <p>{{{$convo->message. "."}}}</p>
              <small>{{{" By " . $convo->user_name . "  At  " . date('m/d/Y  (h:i:s a)', strtotime($convo->created_at)) }}}</small>
            </blockquote>
            @endforeach 
           @else
           <div class="alert alert-dismissable alert-info" id="not-available">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               No Conversations available. 
           </div>
          @endif 
         </div>   
           <div class ="show-ticket" > 
                <div id="error-msg" class="alert alert-dismissable alert-danger" style="display:none;">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 Invalid  Input
                </div> 
               {{ Form::open() }} 
           
           <div class="form-group">
                    <label for="message"> Message </label>
                     {{Form::textarea('msg' ,  Input::old('msg'),  
                                              array( 'placeholder' => 'Type Your Message Here..' ,  'class' => 'form-control' , 'id' =>'text-box')) }}
                   
                      {{Form::hidden('id' , $ticket->id , array('id' => 'ticket-id'))}}
                      {{Form::hidden('user' , Auth::user()->id  , array('id' => 'user-id'))}}
                    <br/>
                     {{ Form::submit('Send', array('class' => 'btn btn-primary' , 'id' => 'convo-message'))}} 
            </div>
           
           
           </div>
        </div>
    </div>

</div><!-- form end -->
@stop