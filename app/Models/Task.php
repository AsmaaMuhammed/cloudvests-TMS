<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Task
 * @package App\Models
 */
class Task extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['title','company_id', 'description', 'priority', 'assigned_to'];

    public function getPartDescription($value)
    {
        return substr($value,0,50).".....";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }
}
