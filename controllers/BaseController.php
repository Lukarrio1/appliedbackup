<?php

require_once '../core/Database.php';
require_once '../traits/validation.php';
require_once '../helpers/query.php';
require_once '../traits/sanitize.php';
require_once '../traits/file.php';
require_once '../traits/tempStorage.php';
require_once '../traits/Notification.php';
// require_once '../traits/email.php';

class Base extends Database
{
    use validator;
    use Sanitize;
    use Helpers;
    use File;
    use State;
    use Notification;
    // use Email;
}
