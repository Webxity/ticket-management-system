<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Please! Sign in</title>
      {{ HTML::style('css/bootstrap.min.css') }}
       {{ HTML::style('css/login.css') }}
    
</head>
<body>
<div class="row">
    <div class="page-header">
        <h1>Ticket Management System</h1>
    </div>
    <div class="col-md-6 col-md-offset-3" id="login-box">
        <div class="breadcrumb">
            <form class="form-horizontal" role="form" name="login" action="{{ url( 'verifylogin' ) }}" method="post" >
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail3" name="email"  placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name ="password" class="form-control" id="inputPassword3" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"> Remember me
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" name="login" value="login" >Sign in</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>