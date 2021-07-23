<?php

namespace App\Enums;

class TaskStatus
{
    const BACKLOG = 'Backlog';
    const TODO = 'To do';
    const DOING = 'Doing';
    const READYFORREVIEW = 'Ready for review';
    const DEV = 'Dev';
    const TEST = 'Test';
    const STAGING = 'Staging';
    const ARCHIVE = 'Archive';
    const PRODUCTION = 'Production';
    const FINISHED = 'Finished';
}
