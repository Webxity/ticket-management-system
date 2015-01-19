<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Register - Webxity Ticket Management</title>
</head>
<body>

<div id="wrapper">
    <!-- Sidebar -->
    <div id="header" style="padding:5px 10px; background:#222222; margin-bottom:50px;">
    	<h1 style="background-color:#222222; font-family:Arial; font-size:24px; color:#999999;">Webxity</h1>
    </div>    
        <div id="page-wrapper">
            <p style="margin-bottom:10px; font-family:Arial; font-size:18px; color:#000000; margin-bottom:20px;"><b>Welcome : {{ $data['name'] }}<b></p>
            <p style="margin-bottom:10px;font-family:Arial; font-size:16px; color:#000000;">
            	<span style="margin-bottom:10px;text-transform:capitalize;">{{ $data['creator'] }}</span> register you on webxity ticket management system.</p>
            <p style="margin-bottom:10px;font-family:Arial; font-size:16px; color:#000000;">Below its your login detail.</p>    
            <p style="margin-bottom:10px;font-family:Arial; font-size:16px; color:#000000;">Email    :  <span style="color:#0000FF;">{{ $data['user']['email'] }}</p> 
            <p style="margin-bottom:10px;font-family:Arial; font-size:16px; color:#000000;">Password :  <span style="color:#0000FF;">{{ $data['user']['password'] }}</p> 
            <p style="margin-bottom:10px;font-family:Arial; font-size:16px; color:#000000;"><a href="{{URL::to('/')}}">Visit site</a></p>   
        </div>
        <!-- /#page-wrapper -->
</div>
</body>
</html>
