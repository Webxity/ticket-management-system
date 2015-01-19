<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Webxity Ticket Management</title>
</head>
<body>

<div id="wrapper" style="border:1px solid #E8E1E1; width:700px;">
    <!-- Sidebar -->
    <div id="header" style="padding:5px 10px; background:#222222; margin-bottom:50px;">
    	<h1 style="background-color:#222222; font-family:Arial; font-size:24px; color:#999999;">Webxity</h1>
    </div>
   <!-- Project Member Email -->
    	<div id="page-wrapper" style="margin-bottom:20px; padding-left:10px;">
            <p style="font-family:Arial; font-size:18px; color:#000000;">Hi {{ $data['developer_name'] }},</p>
            <p style="font-family:Arial; font-size:16px; color:#000000;">{{ $data['creator'] }} assign tasks in the webxity Ticket Management System.</p>
            
            <h3>Task Detail</h3>
            <p style="font-family:Arial; font-size:16px; color:#000000;"><b>Project</b> : {{ $data['project'] }} </p>
            
            <p style="font-family:Arial; font-size:16px; color:#000000;"><b>Task</b>    : {{ $data['title'] }} </p>
            
            <p style="font-family:Arial; font-size:16px; color:#000000;"><b>Description</b> : {{ $data['desription'] }} </p>
        	
            <p style="font-family:Arial; font-size:16px; color:#0000FF;"><a href="{{URL::to('/')}}">visit site</a></p>
        </div>
</div>
</body>
</html>
