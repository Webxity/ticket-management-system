<?php

namespace Webxity;

use View,
    Auth,
    Redirect,
    Session,
    Validator,
    App,
    User,
    Hash,
    Request,
    Input,
    Event,   
	DB,
	Mail,
    Response;

class DashboardController extends \BaseController
{
    protected $nonAdminPages = [
            'getIndex' ,
            'getLogin' ,
            'getCreateTicket',
            'getListTickets' ,
            'getEditTicket' ,
            'getShowTicket',
            'getAddProject' ,
            'getListProjects' ,
            'getEditProject',
			'getEditProjectMember',
            'getLogout',
			'getProjectMember',
			'GetListMember',
			'getDeleteMember',
            'getUpdateTicketStatus',
			'getTimeTracking'          
    ];
	
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/  
  
    public function __construct()
    {
        $this->beforeFilter('auth', [
            'except' => ['getLogin', 'postVerifylogin']
        ]);

        $this->beforeFilter('csrf', [
            'on' => 'post',
            'except' => 'postVerifylogin'
        ]);
        
        $this->beforeFilter('role_access', [
            'on' => 'get',
            'except' =>  $this->nonAdminPages
        ]);
    }

/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/

    public function getIndex()
    {
        //Check if user logged in
        if (!Auth::check()) 
		{
		    return Redirect::action(__CLASS__ . '@getLogin');
        } 
		else 
		{
		    //User is Authenticated
            $data['tickets']  = TicketsModel::all()->take(5); 		
            $data['projects'] = ProjectsModel::all()->take(5); 
            return View::make('dashboard', ['data' => $data]);
        }
    }

/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/

    public function postVerifylogin()
    {
        $user = [
            'email' => Input::get('email'),
            'password' => Input::get('password'),
			'status' => 1
        ];
        if (Auth::attempt($user)) 
		{	

				$Userid = Auth::user()->getId();
				$LoginTime = date("Y-m-d H:i:s");
				$session_id = Session::getId();
				DB::table('login_history')->insert(
									array('user_id' => $Userid , 'login_time' => $LoginTime , 'session_id' => $session_id)
								);
				return Redirect::to('/');	
        }
		else 
		{
            // validation not successful, send back to form
            return Redirect::to('login')->with('msg', 'Login Failed');
        }
    }

/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/

    public function getDashboard()
    {
        return View::make('dashboard');
    }

/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	
    
    public function postDeleteRecord() 
    {  
		if ( Session::token() === Input::get( '_token' ) ) 
		{
			$id =  Input::get('id') ;
	  		switch (Input::get('page')) 
		 	{
				case "project":
				$project = ProjectsModel::find($id);
				$project->delete();
				break;

				case "user":
				$user = User::find($id);
				$user->delete();
				break;

				case "ticket":
				$ticket = TicketsModel::find($id);
				$ticket->delete();
				break;
		    }
		} 
    }
    
    
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/    
    
      
    /**********************************************
   * Routes For PROJECT MANAGEMENT 
   * 
   **********************************************/
    
    public function getAddProject()
    {
      
        return View::make('add_project');
    }
    
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	
	
    public function postAddProject()
    {
         Session::put('submit', 'yes');  //To identify that user submitted the form
         
		 $user_id = Auth::user()->getId();
		 $project = Input::get('project');
		 
		 $CheckProjectExit = DB::select("select project from projects where project='$project' AND user_id=($user_id)");
		 
		 if(empty($CheckProjectExit))
		 {
			  $project = [
				'project'               =>  Input::get('project'),
				'description'           =>  Input::get('description'),
				'user_id'               =>  Auth::user()->getId()
			];
	
			$validator = Validator::make(
				$project,
				[
					'project'                    =>  'required'
				]);
			
			if ($validator->fails())
			{
				// The given data did not pass validation
				$errors = $validator->messages();
				Input::flash();
			}
			else 
			{
				$response = ProjectsModel::create($project);
			}
	
			return Redirect::to('add-project')->withErrors($validator);
    	}
		else
		{
			return Redirect::to('add-project')->with('message','This Project is already Added.');
		}
	}
	
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	

    public function getListProjects()
    {
		$user_id     = Auth::user()->getId();
		$projects    = DB::table('projects')
						->Where('user_id', $user_id)
						->get();
		$AllProjects = DB::table('projects')->get();
				
		foreach($AllProjects as $result)
		{
			$UserDetail = User::GetUserNameById($result->user_id);
			$Username[] = $UserDetail->name;
		}
		
			
        return View::make('list_projects', ['projects' => $projects , 'AllProjects' => $AllProjects , 'Username' => $Username ]);
    }

/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/

    public function getEditProject($id)
    {

        return View::make('edit_project', ['project' => ProjectsModel::find($id)]);
    }

    public function postEditProject()
    {
        $id = intval(Input::get('id'));
        $project = [
            'project'                     =>  Input::get('project'),
            'description'            =>  Input::get('description')
        ];
        $messages = "Record Successfully Updated";
        // Update Tickets Record...
        try 
		{
            ProjectsModel::where('id', '=', $id)
                ->update([
                    'project' => $project['project'], 'description' => $project['description']
                  ]);

        }
		catch(Exception $e) 
		{
            echo $messages = 'Error Updating record';
        }

        Session::put('messages', $messages);
        return Redirect::to("edit-project/$id")->with('project', ProjectsModel::find($id));
    }
	
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	
    
  
      /*************************************************************
   * Routes For Project MANAGEMENT 
   *  ENDS
   ****************************************************************/
    

    
    /**********************************************
   * Routes For TICKET MANAGEMENT 
   * 
   **********************************************/
    
    public function getCreateTicket($id)
    {
		 $query 		= ProjectsModel::GetProjectrow($id);
		 $getDeveloper  = $row = DB::table('project_member')->where('project_id', $id)->get();		
         return View::make('create_ticket',[ 'project' => $query->project , 'getDeveloper' => $getDeveloper , 'project_id' => $id ]);
    }
    
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	
	
    public function postCreateTicket($id)
    {	
        Session::put('submit', 'yes');  //To identify that user submitted the form
        
		$UserId = Auth::user()->getId();
		$developerEmails = Input::get('developer');
		if(!empty($developerEmails)){
		  
        foreach($developerEmails as $developerId)
        {
            $GetUserId = User::GetUserName($developerId);
            $array[] = $GetUserId->id; 
        } 
        $developer_id = implode(",",$array);
        
             DB::table('tickets')->insert(
    					array( 	
    						'title' 		=> Input::get('title'),
    						'description' 	=> Input::get('description'),
    						'project' 		=> Input::get('project'),
    						'priority' 		=> Input::get('priority'),
    						'url' 		    => Input::get('url'),
    						'status' 		=> 'open',
    						'developer'     => $developer_id, 
                            'due_date'      => Input::get('due_date'),
    						'owner_id'      => $UserId )
				);
        
    		 foreach($developerEmails as $email)
    		 {     
                    $developer_name = User::GetUserName($email);
                    
                    $data = array('title'=>Input::get('title'), 'desription' => Input::get('description') , 'creator' => Auth::user()->getName() , 'developer_name' => $developer_name->name ,'project' => Input::get('project') );
                    Mail::send('email_template.task_email', ['data' => $data] , function($message) use ($email) {
           				 	$message->to($email)->subject('Webxity Ticket Management System');
       					 });
    				
    		 }
            
            
			  return Redirect::to('create-ticket/'.$id)->with('msg','Task Assigned Successfully.');
    	}
		else
		{
			return Redirect::to('create-ticket/'.$id)->with('Message','No Developer Added in this project.');
		}
	}
	
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	

    public function getListTickets()
    {
        $user_id = Auth::user()->getId();
        $GetAllTickets =  DB::table('tickets')->get();  
        $tickets = TicketsModel::GetTickets($user_id);   
        
		if(!empty($GetAllTickets)){
			foreach($GetAllTickets as $result)
			{
				$developer_ids[] = $result->developer;
			}
			if(in_array($user_id,$developer_ids))
			{
				$developer_id   = $developer_ids;
				$developer_task = TicketsModel::all(); 
			}
			else
			{
				$developer_task = '';
			}
		}
		else
		{
			$developer_task = '';
		}
		      
        return View::make('list_tickets', ['tickets' => $tickets , 'GetAllTickets' => $GetAllTickets , 'developer_task' => $developer_task]);
    }
	
/**********************************************************************************************************************************************/
/**********************************************************************************************************************************************/
	
	
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	

    public function getEditTicket($id)
    {
         $project = ProjectsModel::all();
         $ticket = TicketsModel::find($id); 
         return View::make('edit_ticket', ['ticket' => $ticket , 'data' => $project]);
    }

/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/

    public function postEditTicket()
    {

        $id = intval(Input::get('id'));
        Session::put('submit', 'yes');  //To identify that user submitted the form                       
        
        $ticket = [
            'title'            =>  Input::get('title'),
            'description'      =>  Input::get('description'),
            'project'          =>  Input::get('project'),
             'priority'        =>  Input::get('priority') ,  
            'url'              =>  Input::get('url'),
            'status'           =>  Input::get('status')
        ];

        $messages = "Record Successfully Updated";
        
        $ticket['url']  = HelperFunc::url_check($ticket['url']); 
        // Update Tickets Record...
        
      $validator = Validator::make(
            $ticket,
            [
                 'title'       =>  'required',
                 'project'     =>   'required'
            ]
        );
          
        if ($validator->fails()) 
		{
            // The given data did not pass validation
            $errors = $validator->messages();
            Input::flash();
            return Redirect::to("edit-ticket/$id")->withErrors($validator);
          
         }
		 else
		 {
              TicketsModel::where('id', '=', $id)
                                                 ->update([
                    'title'   => $ticket['title'], 'description' => $ticket['description'], 
                    'project' => $ticket['project'] ,'priority' => $ticket['priority'] ,  'url' => $ticket['url'] , 
                    'status'  => $ticket['status']
                ]);
               return Redirect::to("edit-ticket/$id")->with('ticket', $ticket);         
         }                       
       
    }
	
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	
    
    public function getShowTicket($id)
    {
        $ticket = TicketsModel::find($id) ; 
        $convo  = ConvoModel::where('ticket_id' , '=' , intval($id) )->get();       
        return View::make('show_ticket' , array ('ticket' => $ticket , 'convo_msg' => $convo )) ; 
    }  
	
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/
	 
    public function postConvoMessage() 
    {  
        if ( Session::token() === Input::get( '_token' ) ) 
        {
              $user = User::find(intval ( Input::get('user_id') )) ; 
              if($user)
              {   
			  
					$convo = [
						'message'                 =>  htmlentities (Input::get('msg') ),
						'user_name'               =>  $user->name,
						'user_id'                 =>  $user->id,
						'ticket_id'               =>  Input::get('ticket_id')
					];
	
					$validator = Validator::make(
						$convo,
						[
							'ticket_id'                         => 'required|integer'
						]
					);
					if ($validator->fails()) 
					{
						// The given data did not pass validation
						$errors = $validator->messages();
						echo "invalid input" ; 
						return ; 
					 }
					 else
					 {
						$created = ConvoModel::create($convo)->id;
						if($created) 
						{
	
							$convo = ConvoModel::find( $created ) ; 
	
							$time = date('m/d/Y  (h:i:s a)', strtotime($convo->created_at)) ;
							$data = ['name' => $user->name , 'time' => $time , 'msg' => $convo['message'] ] ; 
							echo json_encode($data) ; 
	
						}
	
					} 
			
		    }  
                
        }
    }  
     
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/

 
      /*************************************************************
   * Routes For TICKET MANAGEMENT 
   *  ENDS
   ****************************************************************/
    
  
    
    
  /*******************
   * Routes For USER MANAGEMENT 
   * 
   *****************/
   
   
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/    
	
    public function getAddUser()
    {

        return View::make('add_user');
    }

/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/

    public function postAddUser()
    {
         Session::put('submit', 'yes');  //To identify that user submitted the form
         
        $user = [
            'name' 		=> Input::get('name'),
            'password'  => Input::get('password'),
            'email' 	=> Input::get('email'),
            'role' 		=> Input::get('role')
        ];
		
        $rules =   [
                'name' 		=> 'required',
                'password'  => 'required',
                'email' 	=> 'required|email|unique:users',
                'role' 		=> 'required'
            ];
        
        $validator = Validator::make($user , $rules );

       if ($validator->fails()) 
	   {
            // The given data did not pass validation  
            Input::flash(); 
        } 
		else 
		{			 
			if(Auth::user()->role == 'admin')
			{
			 
				 $data = array('name'=>Input::get('name'), 'creator' => Auth::user()->getName() , 'user' => $user );
				  Mail::send('welcome', ['data' => $data] , function($message){
						 $message->to(Input::get('email'), Input::get('name'))->subject('Welcome to the Webxity Ticket Management System!');
				 }); //email send to client or developer.
			}
			elseif(Auth::user()->role == 'client')
			{
				 $data = array('name'=>Input::get('name'), 'creator' => Auth::user()->getName() , 'user' => $user  );
				 $mail =  Mail::send('welcome', ['data' => $data], function($message){    
							$message->to(Input::get('email'))->subject('Welcome to the Webxity Ticket Management System');    
					}); //email send to developer.
				 if(! Mail:: failures())
				 {
				 	$GetAdminEmail = DB::select('select * from users where role ="admin"');
				 	foreach($GetAdminEmail as $result)
					{
						$emails[] = $result->email;
					}

						$data2 = array('name'=>Input::get('name'), 'creator' => Auth::user()->getName());
						Mail::send('admin_email', ['data' => $data2], function($message) use ($emails)
						{    
							$message->to($emails)->subject('Welcome to the Webxity Ticket Management System');    
						}); //email send to admin.
						 
				 }
			}	 
			
			// Create a new user in the database...
             $user['password'] =  Hash::make($user['password']);
             User::create($user); // Create user 
			 
        }

        return Redirect::to('add-user')->withErrors($validator);

    }

/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/

    public function getListUsers()
    {
        $users = User::all();
        return View::make('list_users', ['users' => $users]);

    }
    
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	

	public function postUpdateUserStatus()
	{
		$id     = $_POST['id'];
		$status = $_POST['status']; 
		
		if($status == 1)
		{
			$updateStatus = '0';
		}
		else
		{
			$updateStatus = '1';
		}
		DB::table('users')
            ->where('id', $id)
            ->update(array('status' => $updateStatus));
		
		echo '1';
		//return Redirect::to('list-users')->with('message','Status Update Successfully.');
	}

/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	
	
    public function getEditUser($id)
    {
        return View::make('edit_user', ['user' => User::find($id)]);
    }

/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/

    public function postEditUser()
    {
        
         Session::put('submit', 'yes');  //To identify that user submitted the form                       
        $id = intval(Input::get('id'));

        $user = [
            'name' 		=> Input::get('name'),
            'password'  => Input::get('password'),
            'email' 	=> Input::get('email'),
            'role' 		=> Input::get('role')
        ];

        
        // Update User Record...
           $rules =   [
                'name' 	=> 'required',
                'email' => 'required|email',
                'role' 	=> 'required'
            ];
        
        $validator = Validator::make($user , $rules );

       if ($validator->fails()) {
            // The given data did not pass validation 
                Input::flash();                
          

        } else {
                  User::where('id', '=', $id)
                ->update([
                'name' => $user['name'], 'email' => $user['email'], 'role' => $user['role']
                ]);

                // If password sent update it else not

                if (Input::has('password')) {
                    $user['password'] = Hash::make($user['password']);
                    User::where('email', '=', $user['email'])
                    ->update(['password' => $user['password']]);
                }
        }
            
      
          return Redirect::to("edit-user/$id")->with('user', User::find($id))->withErrors($validator);

    }
    
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/    
    
 
      /**************************************
   * Routes For USER MANAGEMENT 
   *  ENDS
   *****************************************/
     

    public function getLogout()
    {
			$LogoutTime = date("Y-m-d H:i:s");
			
			$session_id = Session::getId();
			DB::table('login_history')
            				->where('session_id', $session_id)
            				->update(array('logout_time' => $LogoutTime));
		
			Session::put('action', Input::old('action'));
			Auth::logout();
			return Redirect::to('login');
    }

/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/

    public function getLogin()
    {
        #var_dump(Hash::make('admin123'));
        if (Auth::check()) {
            return Redirect::to('/');
        }

        if (Request::Ajax()) {
            return Response::json([
                'template' => View::make('login')->render(),
                'action' => Session::get('action')
            ]);
        }

        return View::make('login');
    }

/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/

    public function anyAjax()
    {
        $requested = Input::get('requested');
         if (!Request::Ajax() || empty($requested)) {
            return App::abort(404);
        }

        $method = Request::method();

        $requested = preg_replace('#\/+#', '/', str_replace(url(''), '', $requested));

        $requested = array_values(array_filter(explode('/', $requested), 'strlen'));

        $params = [];
        
        if (count($requested) > 1) {
            $params = array_slice($requested, 1);
        }
        
        if (isset($requested[0])) {
            $requested = $requested[0];
        }
        
        if (empty($requested)) {
            $requested = "Index";
        }
        
        $requested = camel_case('@' . strtolower($method) . '_' . $requested);
        
        if (in_array(str_replace('@', '', $requested), $this->nonAdminPages)
                || Auth::user()->role === 'admin'
        ) {
            return Redirect::action(__CLASS__ . $requested, $params)->withInput();
        } else {
            return  View::make('access_denied') ; 
        }
        
    }

/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/

    public function getTimeTracking()
	{
		$Userid 		= Auth::user()->getId();
		$LoginHistory   = DB::select( DB::raw("SELECT * FROM login_history WHERE user_id = '$Userid'") );
		return  View::make('time_tracking',compact('LoginHistory')) ;
		
	}
	
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	
	
	public function getAddMember($id)
	{
		return  View::make('project_member', [ 'project_id' => $id ]) ;	
	}
	
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	
	
	public function postAddMember()
	{
         Session::put('submit', 'yes');  //To identify that user submitted the form
         
		 $email 	 = Input::get('email');
		 $project_id = Input::get('project_id');
		 $checkEmail = DB::select( DB::raw("SELECT email FROM users WHERE email='$email' AND role='developer'") );
		 
		 if(!empty($checkEmail)) //Check Email To Database
		 {
		 	$checkDeveloper = DB::select( DB::raw("SELECT * FROM project_member WHERE developer_email='$email' AND project_id='$project_id'") );
		 
		 	if(empty($checkDeveloper)) //  check Developer is already exit in project
			{
				$user = [
					'project_owner_id'	=> Auth::user()->getId(),
					'email' 			=> Input::get('email')
				];
		
				$rules =   [
						'email' => 'required|email',
					];
				
				$validator = Validator::make($user , $rules );
		
				if ($validator->fails()) 
				{
					// The given data did not pass validation  
					Input::flash(); 
				} 
				else 
				{
					 DB::table('project_member')->insert(
									array(
									'project_owner_id' => Auth::user()->getId() , 
									'project_id' => Input::get('project_id') , 
									'developer_email' => Input::get('email')
									)
								); // Create Member
								
					$GetProjectName = ProjectsModel::GetProjectrow(Input::get('project_id'));
								 
					 $data = array('project_id' => $GetProjectName->project , 'creator' => Auth::user()->getName());
					 Mail::send('email_template.project_add_member', ['data' => $data] , function($message){
       				 	$message->to(Input::get('email'))->subject('Webxity Ticket Management System');
   					 });
					 		
				}
				 return Redirect::to('add-member/'.Input::get('project_id'))->withErrors($validator);
			}
			else
			{	
				return Redirect::to('add-member/'.Input::get('project_id'))->with('message','Developer already Added in this project.');
			}	  
		 }
		 else
		 {
			return Redirect::to('add-member/'.Input::get('project_id'))->with('message','Email Does not Exit.');
		 }
		       
	}
	
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	
	
	public function getListMember($project_id)
	{
		$GetProjectName = ProjectsModel::GetProjectrow($project_id);
		$projectMembers = $user = DB::table('project_member')->where('project_id', $project_id)->get();
		if(!empty($projectMembers)){
			foreach($projectMembers as $result)
			{
				$UserDetail 	= User::GetUserName($result->developer_email);
				$Username[]		= $UserDetail->name;
			}
		}
		else
		{
			$Username = '';
		}
		return  View::make('list_project_member',[ 'projectMembers' => $projectMembers , 'GetProjectName' => $GetProjectName->project , 'Username' => $Username ]) ;	
	}
	
/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/

	public function postDeleteMember()
	{
		$id = $_POST['id'];
		DB::table('project_member')->where('id',$id)->delete();
		echo '1';
	}

/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/

    public function postUpdateTicketStatus()
    {
        $id      =  $_POST['rowid'];
        $explode =  explode('_',$_POST['status']); 
        $status  =  $explode[0];
        $project_owner_id = $explode[1];
        
        if($status == 'open')
        {
           $UpdateStatus = 'complete';
            
           $GetTask = DB::table('tickets')->where('id', $id)->first();  
         
           $GetProjectName = User::GetUserNameById($GetTask->owner_id);
           
           $emails = $GetProjectName->email;
                
           $data = array('project_owner_name' => $GetProjectName->name , 'creator' => Auth::user()->getName() , 'task' =>$GetTask->title );
      	   Mail::send('email_template.task_complete', ['data' => $data] , function($message) use ($emails) {
       	 	   $message->to($emails)->subject('Webxity Ticket Management System');
      	   });
            
        }
        else
        {
            $UpdateStatus = 'open';
        }
        DB::table('tickets')
            ->where('id', $id)
            ->update(array('status' => $UpdateStatus));
    
    }
	
/**********************************************************************************************************************************************/	
/*********************************************************************************************************************************************/



/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/



/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/



/**********************************************************************************************************************************************/	
/**********************************************************************************************************************************************/	
  
}