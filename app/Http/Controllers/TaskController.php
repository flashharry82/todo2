<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
         $tasks = Task::all();

         return view('tasks.index', compact('tasks'));
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
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
         $request->validate([
             'name'=>'required'
         ]);

         $contact = new Task([
             'name' => $request->get('name')
         ]);
         $contact->save();
         return redirect('/tasks')->with('success', 'Task saved!');
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
         $task = Task::find($id);
         return view('tasks.edit', compact('task'));
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
         $request->validate([
             'name'=>'required'
         ]);

         $task = Task::find($id);
         $task->name =  $request->get('name');
         $task->save();

         return redirect('/tasks')->with('success', 'Task updated!');
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function process() {
    	/*$process = new Process(['/usr/bin/curl -s -XGET http://www.google.com']);
		$process->run();
		if (!$process->isSuccessful()) {
		    throw new ProcessFailedException($process);
		}
    	$output = $process->getOutput();*/

        $output = shell_exec('/var/task/vendor/laravel/vapor-cli/vapor login');
        shell_exec("echo \"id: {$_ENV['VAPOR_APP_ID']}\" > /tmp/vapor.yml");
        $output2 = shell_exec("cat /tmp/vapor.yml");
        $output3[0] = 'test';
        $status = 0;
        //exec('/var/task/vendor/laravel/vapor-cli/vapor deploy:list production', $output2, $status);
        exec('/var/task/vendor/laravel/vapor-cli/vapor env test', $output3, $status);

        return view('tasks.process', compact(['output','output2','output3','status']));
    }
}
