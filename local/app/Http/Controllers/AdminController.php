<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Task;
use App\User;
use DB;
use Excel;

class AdminController extends Controller {

	/**
	 * To act as admin you have to be logged in
	 */
	public function __construct(){
        $this->middleware(['auth', 'admin.only']);
    }
    
    /**
     * show index
     */
    public function index(Request $request) {
    	$users = User::where('activated', 1)->count();
    	$tasks = Task::all()->count();
    	return view('admin.index')->with(['users' =>$users , 'tasks' => $tasks]);
    }

    /**
     * show users
     */
    public function getUsers(Request $request) {
    	$users = User::paginate(8);
    	return view('admin.users')->with('users', $users);
    }

    /**
     * show all tasks, paginated
     */
    public function getTasks(Request $request) {
    	$tasks = Task::paginate(8);
    	return view('admin.tasks')->with('tasks', $tasks);
    }

    /**
     * show form to edit user
     */
    public function editUser(Request $request, $uid) {
    	
    	$user = User::findOrFail($uid);

    	return view('admin.edit-user')->with('user', $user);
    }

    /**
     * update user after edit
     */
    public function updateUser(Request $request) {
    	if($request->has('update')){
    		//validate the input
	        $this->validate($request, [
	            'email' => 'required|max:255',
	            'role' => 'required|max:255',
	        ]);
	        $user_id = $request->input('uid');
	        $user = User::findOrFail($user_id);
	        $user->firstname = $request->input('firstname');
	        $user->lastname  = $request->input('lastname');
	        $user->email     = $request->input('email');
	        $user->role      = $request->input('role');

	        $user->save();
	        $message = "User Details Successfully Updated.";
	        return redirect()->back()->with(['user' => $user, 'success' => $message]);
    	}else{
    		echo "NOT FROM FROM";
    	}        

    }

    /**
     * edit single task
     */
    public function editTask(Request $request, $tuid){

    	$task = Task::findOrFail($tuid);

    	return view('admin.edit-task')->with('task', $task);
    }

    /**
     * generate CSV for all tasks for all users
     */
    public function getBigExcel(Request $request){

        $tasks = DB::table('tasks')->select('user_id', 'name', 'description', 'state', 'created_at', 'updated_at')->get();
        $data = [];
        foreach ($tasks as $task) {
            $one_task = array($task->name, $task->description, $task->state, User::getName($task->user_id), date('jS M Y H:i', strtotime($task->created_at)), date('jS M Y H:i', strtotime($task->updated_at)));
            array_push($data, $one_task);
        }

        $workbookname = "All Tasks";

         return Excel::create($workbookname, function($excel) use ($data) {
            $excel->sheet('', function($sheet) use ($data){
                
                $sheet->fromArray($data);
                $sheet->row(1, array(
                     'Task Name', 'Task Description', 'Task State', 'Owner', 'Created On', 'Last Updated'
                ));
                
            });
        })->download('csv');
    }

    /**
     * generate XML for all tasks for all users
     */
    public function getBigXML(Request $request) {
        $tasks = DB::table('tasks')->select('user_id', 'name', 'description', 'state', 'created_at', 'updated_at')->get();
        $data = [];
        foreach ($tasks as $task) {
            $one_task = array($task->name, $task->description, $task->state, User::getName($task->user_id), date('jS M Y H:i', strtotime($task->created_at)), date('jS M Y H:i', strtotime($task->updated_at)));
            array_push($data, $one_task);
        }
        
        // Pick a format to export to
        $format = 'xml';

        // Filename
        $filename = 'All Tasks.xml';

        // Set Content-Type
        $content_type = 'text/xml';

        //for the data stream
        $export_to = 'php://output';


        // Data to export
        $exporter_source = new \Exporter\Source\ArraySourceIterator($data);

        // Get an Instance of the Writer
        $exporter_writer = '\Exporter\Writer\\' . ucfirst($format) . 'Writer';

        $exporter_writer = new $exporter_writer($export_to);

        // Set the right headers
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Description: File Transfer');
        header('Content-type: ' . $content_type);
        header('Content-Disposition: attachment; filename=' . $filename . ';');
        header('Expires: 0');
        header('Pragma: public');

        // Export to the format
        return \Exporter\Handler::create($exporter_source, $exporter_writer)->export();
    }
}
