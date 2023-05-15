<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $date = ['deleted_at'];

    const DEFAULT_RETURNING_FIELDS = [
        'tasks.title',
        'tasks.description',
        'tasks.is_completed',
        'tasks.created_at',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * Mass assignment not allowed
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * returns the task details
     *
     * @param array $fields
     * @param array $filter
     * @return object
     */
    public static function getTaskDetails(array $fields = [], array $filter = []) {
        return self::select($fields)->where($filter)->get();
    }

    /**
     * Returns the tasks details
     *
     * @param array $filter
     * @return Task
     */
    public static function getTask(array $select, array $filter)
    {
        if (!empty($select)) {
            return self::select($select)->where($filter)->first();
        } else {
            return self::where($filter)->first();
        }
    }
    /**
     * Create/Updates the tasks details
     *
     * @param array $data
     * @return boolean true | false
     */
    public function store(array $data)
    {
        $possibleColumnsToStore = [
            "title",
            "description",
            "is_completed"
        ];
        foreach ($data as $column => $value) {
            if (in_array($column, $possibleColumnsToStore)) {
                $this->$column = $value;
            }
        }
        $task = $this->save();
        return $task;
    }
    /**
     * Returns the Task details
     *
     * @param  array $fields
     * @param  array $filter
     *
     * @return array
     */
    public static function getAll(array $fields, array $filter): array
    {
         $fields = [
            'tasks.id',
            'tasks.title',
            'tasks.description',
            'tasks.is_completed',
            DB::raw('DATE_FORMAT(tasks.created_at, "%m/%d/%Y %H:%i %p") as created_at_time'),
        ];
        $model = self::select($fields)
            ->where($filter);
        return $model->select($fields)->orderBy('id','desc')->get()->toArray();
    }

    // This function soft deletes information from the database
    public function remove()
    {
        return $this->delete();
    }
}
