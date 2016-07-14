<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Task;
use App\Repositories\TaskRepository;
use DB;
use Excel;
use View;

class TaskController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct(TaskRepository $tasks){
        $this->middleware('auth');

        $this->tasks = $tasks; //assign protected $tasks to a Repository
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $tasks = $this->tasks->foruser($request->user());//call the forUser in Repository
        $role  = $request->user()->userRole();

        return view('tasks.index', [
            'tasks' => $tasks, 'role' =>$role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'taskname' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->taskname, 'description' => $request->tdesc
        ]);
        /*$task = new Task();
        $task->name = $request->input('tname');
        $task->description = $request->input('tdesc');
        $task->user_id = $request->user()->id();*/

        return redirect('/tasks');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {   
        $task = Task::findOrFail($id);
        return view('tasks.edit')->with('task', $task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate the input
        $this->validate($request, [
            'taskname' => 'required|max:255',
        ]);

        $task = Task::findOrFail($id);
        $task->name        = $request->input('taskname');
        $task->description = $request->input('tdesc');
        $task->state       = $request->input('tstatus');

        $task->save();
        $message = "Task Successfully Updated.";
        return redirect()->back()->with(['task' => $task, 'success' => $message]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeState(Request $request, $id)
    {        
        $newstate = $request->input('newstate');        
        $taskID   = $request->input('taskID');        

        $task = Task::findOrFail($taskID);
        $task->state = $newstate;

        $task->save();

        $message = "Task State Successfully Changed.";
        return redirect()->back()->with(['success' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     *  @param \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {       
        $taskID   = $request->input('taskID');
        
        Task::destroy($taskID);

        $message = "Task Deleted Successfully.";
        return redirect()->back()->with(['success' => $message]);
    }

    /**
     * Download tasks in Excel File for the logged in user
     *
     */
    public function downloadExcel(Request $request){        
        $user = Auth::user();
       
        $tasks = DB::table('tasks')->select('name', 'description', 'state','created_at', 'updated_at')->where('user_id', $user->id)->get();
        
        $data = [];
        foreach ($tasks as $task) {
            $one_task = array($task->name, $task->description, $task->state, date('jS M Y H:i', strtotime($task->created_at)), date('jS M Y H:i', strtotime($task->updated_at)));
            array_push($data, $one_task);
        }

        $workbookname = $user->email;

         return Excel::create("MY TASK LIST", function($excel) use ($data) {
            $excel->sheet('', function($sheet) use ($data){
                
                $sheet->fromArray($data);
                $sheet->row(1, array(
                     'Task Name', 'Task Description', 'Task State', 'Created On', 'Last Updated'
                ));
                
            });
        })->download('csv');
    }

     /**
     * Download tasks in XML File for the logged in user
     *
     */
    public function downloadXML(Request $request) {
        $tasks = DB::table('tasks')->select('name', 'description', 'state','created_at', 'updated_at')->where('user_id', $request->user()->id)->get();
        
        $data = [];
        foreach ($tasks as $task) {
            $one_task = array($task->name, $task->description, $task->state, date('jS M Y H:i', strtotime($task->created_at)), date('jS M Y H:i', strtotime($task->updated_at)));
            array_push($data, $one_task);
        }

        // Pick a format to export to
        $format = 'xml';

        // Filename
        $filename = 'MY TASK LIST.xml';

        // Set Content-Type
        $content_type = 'text/xml';

        //For the data stream
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
