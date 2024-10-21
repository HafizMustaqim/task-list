<?php

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    return redirect()->route('tasks.index');
});

Route::get('/tasks', function () {
    return view('index', [
         //tasks is a key(the name can be differ from the var that is passed and when is called in blade file it is need to be called $tasks that u set here)
        'tasks' => Task::latest()->paginate(10) //query builder need to call get() to execute the query
    ]);
})->name('tasks.index');

Route::view('/tasks/create', 'create')->name('tasks.create');

Route::get('/tasks/{task}/edit', function (Task $task) {
    return view('edit', [
        'task' => $task
    ]);
})->name('tasks.edit');

Route::get('/tasks/{task}', function (Task $task) {
    return view('show', [
        'task' => $task
    ]);
})->name('tasks.show');

Route::post('/tasks', function (TaskRequest $request){
    // dd($request->all());
    $task = Task::create($request->validated()); //mask assignment
    return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Task created successfully!'); //'success' is a temporary session variable
})->name('tasks.store');

Route::put('/tasks/{task}', function (Task $task, TaskRequest $request){
    $task->update($request->validated()); //mask assignment
    return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Task updated successfully!'); //'success' is a temporary session variable
})->name('tasks.update');

Route::delete('/tasks/{task}', function (Task $task){
    $task->delete();
    return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
})->name('tasks.destroy');


Route::put('tasks/{task}/toggle-complete', function(Task $task){
    $task->toggleComplete();
    return redirect()->back()->with('success', 'Task updated successfully!');
})->name('tasks.toggle-complete');


// Route::fallback(function () {
//     return 'Still got somewhere!';
// });
