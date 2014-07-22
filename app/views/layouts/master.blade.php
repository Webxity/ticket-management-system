@if(!$isAjax)
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard - Webxity</title>

    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('css/sb-admin.css') }}
    {{ HTML::style('css/css/font-awesome.min.css') }}

</head>

<body>
<div id="wrapper">
    <!-- Sidebar -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url('')}}">Webxity</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li class="active"><a href="{{ url('') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-money"></i>
                        Ticket Management <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url( 'create-ticket' ) }}"><i class="fa fa-plus"></i> Add Ticket </a></li>
                        <li><a href="{{ url( 'list-tickets' ) }}"><i class="fa fa-list"></i> List Tickets </a></li>
                    </ul>
                </li>
                @if (  Auth::user()->role == 'admin') 
                   <li class="dropdown">
                       <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                        User Management <b class="caret"></b></a>
                       <ul class="dropdown-menu">
                         <li><a href="{{ url( 'add-user' ) }}"><i class="fa fa-plus"></i> Add User </a></li>
                         <li><a href="{{ url( 'list-users' ) }}"><i class="fa fa-list"></i> List User </a></li>
                       </ul>
                    </li>
                @endif
                    <li class="dropdown">
                       <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-file"></i>
                        Project Management <b class="caret"></b></a>
                       <ul class="dropdown-menu">
                         <li><a href="{{ url( 'add-project' ) }}"><i class="fa fa-plus"></i> Add Project </a></li>
                         <li><a href="{{ url( 'list-projects' ) }}"><i class="fa fa-list"></i> List Project </a></li>
                       </ul>
                    </li>
            </ul>
                    
            <ul class="nav navbar-nav navbar-right navbar-user">
            
                <li class="dropdown user-dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                        Hello , @if( Auth::check() ) {{{ Auth::user()->getName() }}}. @endif  <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        
                        <li class="divider"></li>
                        <li><a href="{{ url('logout') }}" data-action="logout"><i class="fa fa-power-off"></i> Log
                                Out</a></li>
                    </ul>
                </li>
            </ul>
            
            <!-- <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown messages-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i>  Message <span class="badge"> 7 </span> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">7 New Messages</li>
                <li class="message-preview">
                  <a href="#">
                    <span class="avatar"><img src="http://placehold.it/50x50"></span>
                    <span class="name">John Smith:</span>
                    <span class="message">Hey there, I wanted to ask you something...</span>
                    <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                  </a>
                </li>
                <li class="divider"></li>
                <li class="message-preview">
                  <a href="#">
                    <span class="avatar"><img src="http://placehold.it/50x50"></span>
                    <span class="name">John Smith:</span>
                    <span class="message">Hey there, I wanted to ask you something...</span>
                    <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                  </a>
                </li>
                <li class="divider"></li>
                <li class="message-preview">
                  <a href="#">
                    <span class="avatar"><img src="http://placehold.it/50x50"></span>
                    <span class="name">John Smith:</span>
                    <span class="message">Hey there, I wanted to ask you something...</span>
                    <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                  </a>
                </li>
                <li class="divider"></li>
                <li><a href="#">View Inbox <span class="badge">7</span></a></li>
              </ul>
            </li>
            
          </ul>
          <!-- /.navbar-collapse --> -->   
        </div>
       
    </nav>

    <div id="page-wrapper">
        @section('page-wrapper')

        @show
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

{{ HTML::script('js/jquery.min.js') }}

{{ HTML::script('js/bootstrap.js') }}
<script>
    var __tmsOBJ = {
        __tmsBaseURI: "{{ url('') }}",
        _token: "{{ Session::token() }}"
    };
</script>
{{ HTML::script('js/tablesorter/tables.js') }}
{{ HTML::script('js/tablesorter/tablesorter.js') }}
{{ HTML::script('js/init.js') }}
</body>
</html>
@endif
