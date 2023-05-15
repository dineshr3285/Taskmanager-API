<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\TaskRequest;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    /**
     * Returns the filter
     *
     * @param  TaskRequest $request
     *
     * @return array
     */
    private function _generateFilter(TaskRequest $request): array
    {
        $possibleSearchFilterParams = [
            'status'
        ];
        $sort = [
            'field'     => 'tasks.id',
            'direction' => 'desc'
        ];
        $paginate = config('app.pagination.limit');

        $filter = [];
        $filterData = $request->all();
        if (!empty($filterData)) {
            foreach ($filterData as $param => $value) {
                if (in_array($param, $possibleSearchFilterParams) && strlen($value)) {
                    if ($param == 'status') {
                        $filter[] = ['tasks.is_completed', $value];
                    } else {
                        $filter[] = [$param, 'ilike', "%$value%"];
                    }
                }
            }
        }
        if ($request->has('page_limit')) {
            $paginate =   (in_array('page_limit', $filterData)) ? $request->page_limit : config('app.pagination.limit');
        }
        $options = [
            'sort' => $sort,
            'page_limit' => (int)$paginate
        ];
        return [
            'filter'  => $filter,
            'options' => $options,
            'fields'  => $request->fields ?: [],
        ];
    }
    /**
     * Returns all the Task details based on the filter criteria
     *
     * @param  TaskRequest  $request
     *
     * @return JsonResponse
     */
    public function getAllTasks(TaskRequest $request)
    {
        $filterData = $this->_generateFilter($request);
        $inputData = $request->fields;
        $data       = Task::getAll($inputData ?: [], $filterData['filter']);
        
        return response()->json([
            'message' => 'Task retrieved successfully.',
            'data'    => [
                'tasks' => $data
            ],
            'errors'  => []
        ], Response::HTTP_OK);
    }

    /**
     * To store the Task detail
     *
     * @param TaskRequest $request
     *
     * @return JsonResponse
     */
    public function store(TaskRequest $request)
    {
        if ($request->method() === "POST") {
            $inputData = $request->all();
            if ($inputData) {
                $task     = new Task();
                $isSaved    = $task->store($inputData);
                if ($isSaved) {
                    return response()
                        ->json([
                            'message' => 'New Task Created Successfully.',
                            'data'    =>  [],
                            'errors'  => []
                        ], Response::HTTP_OK);
                } else {
                    return response()
                        ->json([
                            'message' => 'Unexpected error. Please try again later.',
                            'data'    =>  [],
                            'errors'  => []
                        ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            }
        }
    }

    /**
     * Edit the Task detail
     *
     * @param TaskRequest $request
     *
     * @return JsonResponse
     */
    public function edit(string $id)
    {
        $Task = Task::getTask([], ['id' => $id]);
        if (!$Task) {
            return response()
                ->json([
                    'message' => 'No Task Details Found',
                    'data'    =>  [],
                    'errors'  => []
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()
            ->json([
                'message' => 'Task Detail Retrieved Successfully.',
                'data'    =>  ['task' => $Task],
                'errors'  => []
            ], Response::HTTP_OK);
    }

    /**
     * To update the Task detail
     *
     * @param TaskRequest $request
     *
     * @return JsonResponse
     */
    public function update(TaskRequest $request)
    {
        $tasks = Task::getTask([], ['id' => $request->id]);
        if (!$tasks) {
            return response()->json([
                'message' => 'Unexpected error. Please try again later.',
                'data'    =>  [],
                'errors'  => []
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $inputData = $request->validated();
        if ($inputData) {
            $task    = Task::getTask(['id'], ['id' => $request->id]);
            $isSaved = $task->store($inputData);

            if ($isSaved) {
                return response()
                    ->json([
                        'message' => 'Task has been Updated Successfully.',
                        'data'    =>  [],
                        'errors'  => []
                    ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'message' => 'Unexpected error. Please try again later.',
                    'data'    =>  [],
                    'errors'  => []
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
    }

    /**
     * Change the status of the Task
     *
     * @param TaskRequest $request
     *
     * @return JsonResponse
     */
    public function changeStatus(TaskRequest $request)
    {
        $idValue = $request->id;
        $select   = ['id'];

        if($idValue != "") {
            $filter = ['id' => $idValue];
            $task = Task::getTask($select, $filter);
            $task->is_completed = $request->status;
            $task->save();
        }

        if ($request->status == 1) {
            return response()
                ->json([
                    'message' => 'Task Mark as Completed Sucessfully',
                    'data'    => [],
                    'errors'  => []
                ], Response::HTTP_OK);
        } else {
            return response()
                ->json([
                    'message' => 'Task Mark as Incomplete Successfully',
                    'data'    => [],
                    'errors'  => []
                ], Response::HTTP_OK);
        }
    }

     /**
     * To Delete the Task
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function delete(string $id)
    {
        $model = Task::getTask([], ['id' => $id]);

        $isDeleted = $model->remove();

        return $isDeleted
        ? response()->default([], 'Task deleted successfully.', [], Response::HTTP_OK)
        : response()->default([], 'Task could not be deleted.', [], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
