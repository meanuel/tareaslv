<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return boolean
     */
    public function verify(User $user, Task $task)
    {
        return $user->id === $task->user_id;
    }
}
