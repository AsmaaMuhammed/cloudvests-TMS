<?php

namespace App\Repositories;

use App\Http\Requests\TaskRequest;
use App\Models\Task;


/**
 * Class TaskRepository
 * @package App\Repositories
 */
class TaskRepository
{

    /**
     * @param TaskRequest $request
     * @return mixed
     */
    public function store(TaskRequest $request)
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'company_id'=> auth()->user()->company->id,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to
        ]);

        return $task;
    }

    /**
     * @param TaskRequest $request
     * @param Task $task
     * @return Task
     */
    public function update(TaskRequest $request, Task $task)
    {
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'company_id' => auth()->user()->company->id,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to
        ];
        $task->update($data);
        return $task;
    }
}