<?php

namespace App\Enums;

class TaskStatus
{
    const BACKLOG = 'Backlog';
    const TODO = 'To do';
    const DOING = 'Doing';
    const READYFORREVIEW = 'Ready for review';
    const NEEDFIX = 'Need fix';
    const READYFORTEST = 'Ready for test';
    const FINISHED = 'Finished';
}
