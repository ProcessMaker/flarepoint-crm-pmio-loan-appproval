<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
class ChangeStatusController
{
    public function changeLoanStatus(Request $request)
    {
        if ($request->has('case_id') && $request->has('status')) {
            /** @var Task $task */
            $task = Task::whereId((integer)$request->input('case_id'))->first();
            $statuses = [
                'approved'=>3,
                'rejected'=>4
            ];
            $task->update(
                ['status' => $statuses[$request->input('status')]]
            );
            return \Response::json([
                'state'=>'success'
            ], 200);
        } else {
            return \Response::json([
                'state'=>'wrong data'
            ], 200);
        }

    }
}
