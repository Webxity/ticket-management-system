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
    Response;

class DashboardController extends \BaseController
{
    protected $nonAdminPages = [
            'getIndex' ,
            'getLogin' ,
            'getCreateTicket' ,
            'getListTickets' ,
            'getEditTicket' ,
            'getShowTicket',
            'getAddProject' ,
            'getListProjects' ,
            'getEditProject',
             'getLogout'          
    ];
    
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


    public function getIndex()
    {
        //Check if user logged in
        if (!Auth::check()) {
            return Redirect::action(__CLASS__ . '@getLogin');

        } else {
            //User is Authenticated
            $data['tickets'] = TicketsModel::all()->take(5); 
            $data['projects'] = ProjectsModel::all()->take(5); 
            
            return View::make('dashboard', ['data' => $data]);
        }
    }


    public function postVerifylogin()
    {
        $user = [
            'email' => Input::get('email'),
            'password' => Input::get('password')
        ];

        if (Auth::attempt($user)) {
            return Redirect::to('/');

        } else {
            // validation not successful, send back to form
            return Redirect::to('login')->with('message', 'Login Failed');
        }
    }

    public function getDashboard()
    {
        return View::make('dashboard');
    }
    
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
    
    
    
    
      
    /**********************************************
   * Routes For PROJECT MANAGEMENT 
   * 
   **********************************************/
    
    public function getAddProject()
    {
      
        return View::make('add_project');
    }
    
    public function postAddProject()
    {
          Session::put('submit', 'yes');  //To identify that user submitted the form
          $project = [
            'project'               =>  Input::get('project'),
            'description'      =>  Input::get('description')
        ];

        $validator = Validator::make(
            $project,
            [
                'project'                    =>  'required'
            ]);
        
        if ($validator->fails()) {
            
            // The given data did not pass validation
            $errors = $validator->messages();
            Input::flash();

        } else {
         
            $response = ProjectsModel::create($project);
        }

        return Redirect::to('add-project')->withErrors($validator);

    }

    public function getListProjects()
    {
   
        $projects = ProjectsModel::all();
        return View::make('list_projects', ['projects' => $projects]);

    }

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
        try {
            ProjectsModel::where('id', '=', $id)
                ->update([
                    'project' => $project['project'], 'description' => $project['description']
                  ]);

        } catch (Exception $e) {
            echo $messages = 'Error Updating record';
        }

        Session::put('messages', $messages);
        return Redirect::to("edit-project/$id")->with('project', ProjectsModel::find($id));

    }
    
  
      /*************************************************************
   * Routes For Project MANAGEMENT 
   *  ENDS
   ****************************************************************/
    

    
    /**********************************************
   * Routes For TICKET MANAGEMENT 
   * 
   **********************************************/
    
    public function getCreateTicket()
    {
         $project = ProjectsModel::all();
        return View::make('create_ticket' , [ 'data' => $project ]);
    }
    
    public function postCreateTicket()
    {
         Session::put('submit', 'yes');  //To identify that user submitted the form
        $ticket = [
            'title'                   =>  Input::get('title'),
            'description'      =>  Input::get('description'),
            'project'               => Input::get('project'),
            'priority'             => Input::get('priority') ,  
            'url'                        => Input::get('url'),
            'status'                 => 'open'
        ];
        
        $ticket['url']  = HelperFunc::url_check($ticket['url']); 
         
       $validator = Validator::make(
            $ticket,
            [
                 'title'                    =>  'required',
                 'project'                =>   'required'
            ]
        );
          
        if ($validator->fails()) {
            // The given data did not pass validation
            $errors = $validator->messages();
            Input::flash();
          
         } else {

            // Create a new ticket in the database...
            $response = TicketsModel::create($ticket);
           // $event = Event::fire('ticket_created', array($ticket)); firing an event here
        }

        return Redirect::to('create-ticket')->withErrors($validator);

    }

    public function getListTickets()
    {
   
        $tickets =   TicketsModel::orderBy('id', 'DESC')->get();
        return View::make('list_tickets', ['tickets' => $tickets]);

    }

    public function getEditTicket($id)
    {
         $project = ProjectsModel::all();
         $ticket = TicketsModel::find($id); 
         return View::make('edit_ticket', ['ticket' => $ticket , 'data' => $project]);
    }

    public function postEditTicket()
    {

        $id = intval(Input::get('id'));
        Session::put('submit', 'yes');  //To identify that user submitted the form                       
        
        $ticket = [
            'title'                   =>  Input::get('title'),
            'description'      =>  Input::get('description'),
            'project'               => Input::get('project'),
             'priority'             => Input::get('priority') ,  
            'url'                        => Input::get('url'),
            'status'                 => Input::get('status')
        ];

        $messages = "Record Successfully Updated";
        
        $ticket['url']  = HelperFunc::url_check($ticket['url']); 


        // Update Tickets Record...
        
      $validator = Validator::make(
            $ticket,
            [
                 'title'                    =>  'required',
                 'project'                =>   'required'
            ]
        );
          
        if ($validator->fails()) {
            // The given data did not pass validation
            $errors = $validator->messages();
            Input::flash();
            return Redirect::to("edit-ticket/$id")->withErrors($validator);
          
         } else {
                           TicketsModel::where('id', '=', $id)
                                                          ->update([
                     'title' => $ticket['title'], 'description' => $ticket['description'], 
                    'project' => $ticket['project'] ,'priority' => $ticket['priority'] ,  'url' => $ticket['url'] , 
                    'status' => $ticket['status']

                ]);
                  
                     return Redirect::to("edit-ticket/$id")->with('ticket', $ticket);         
         }                       
       
    }
    
    public function getShowTicket($id)
    {
        $ticket = TicketsModel::find($id) ; 
       
         $convo  = ConvoModel::where('ticket_id' , '=' , intval($id) )->get(); 
      
        return View::make('show_ticket' , array ('ticket' => $ticket , 'convo_msg' => $convo )) ; 
      
        
    }   
     public function postConvoMessage() 
    {  
        if ( Session::token() === Input::get( '_token' ) ) 
        {
                
                $user = User::find(intval ( Input::get('user_id') )) ; 
                if($user)
                {   
                      
                        $convo = [
                            'message'                   =>  htmlentities (Input::get('msg') ),
                            'user_name'               =>  $user->name,
                            'user_id'                   =>  $user->id,
                            'ticket_id'               =>  Input::get('ticket_id')
                        ];

                        $validator = Validator::make(
                            $convo,
                            [
                                'ticket_id'                         => 'required|integer'
                            ]
                        );
                        if ($validator->fails()) {
                            // The given data did not pass validation
                            $errors = $validator->messages();
                            echo "invalid input" ; 
                           return ; 
                            } else {
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
     
 
      /*************************************************************
   * Routes For TICKET MANAGEMENT 
   *  ENDS
   ****************************************************************/
    
  
    
    
  /*******************
   * Routes For USER MANAGEMENT 
   * 
   *****************/
    
       public function getAddUser()
    {

        return View::make('add_user');
    }

    public function postAddUser()
    {
         Session::put('submit', 'yes');  //To identify that user submitted the form
         
        $user = [
            'name' => Input::get('name'),
            'password' => Input::get('password'),
            'email' => Input::get('email'),
            'role' => Input::get('role')
        ];

        $rules =   [
                'name' => 'required',
                'password' => 'required',
                'email' => 'required|email|unique:users',
                'role' => 'required'
            ];
        
        $validator = Validator::make($user , $rules );

       if ($validator->fails()) {
            // The given data did not pass validation  
            Input::flash(); 

        } else {

            // Create a new user in the database...
            $user['password'] =  Hash::make($user['password']);
             User::create($user); // Create user 
        }

        return Redirect::to('add-user')->withErrors($validator);

    }

    public function getListUsers()
    {
        $users = User::all();
        return View::make('list_users', ['users' => $users]);

    }
    
    public function getEditUser($id)
    {
        return View::make('edit_user', ['user' => User::find($id)]);
    }

    public function postEditUser()
    {
        
         Session::put('submit', 'yes');  //To identify that user submitted the form                       
        $id = intval(Input::get('id'));

        $user = [
            'name' => Input::get('name'),
            'password' => Input::get('password'),
            'email' => Input::get('email'),
            'role' => Input::get('role')
        ];

        
        // Update User Record...
           $rules =   [
                'name' => 'required',
                'email' => 'required|email',
               'role' => 'required'
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
    
    
    
 
      /**************************************
   * Routes For USER MANAGEMENT 
   *  ENDS
   *****************************************/
     

    public function getLogout()
    {
        Session::put('action', Input::old('action'));

        Auth::logout();
        return Redirect::to('login');

    }

    public function getLogin()
    {
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

    
  
}