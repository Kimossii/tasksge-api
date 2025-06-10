<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 /**
  * @OA\Schema(
  *     schema="Task",
  *     type="object",
  *     title="Task",
  *     required={"id", "title", "user_id"},
  *     @OA\Property(property="id", type="integer", example=1),
  *     @OA\Property(property="title", type="string", example="Estudar Swagger"),
  *     @OA\Property(property="description", type="string", example="Aprender a documentar APIs"),
  *     @OA\Property(property="status", type="string", example="pendente"),
  *     @OA\Property(property="user_id", type="integer", example=1),
  *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-06-10T12:00:00Z"),
  *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-06-10T13:00:00Z"),
  * )
  */

class Task extends Model
{
    //
    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
