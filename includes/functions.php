<?php

function meeting_requests()
{
    global $PDO;
    // Do something
    $query = "SELECT * FROM users WHERE email = :email";
    $statement = $PDO->prepare($query);
    $params = array(
        'email' => 'something@example.com',
    );
    $statement->execute($params);
    $row = $statement->fetch();
    
    
    // Return
    return $row;
}

// int
function count_meeting_requests($recipient)
{
    global $PDO;
   $query = 'SELECT COUNT(*) FROM meeting_requests WHERE recipient = :recipient'; 
   $stmt = $PDO->prepare($query);
   $params = array(
       'recipient' => $recipient,
   );
   $stmt->execute($params);
   $row = $statement->fetch();
   var_dump($row);

   return $row;
}

function get_time_saved($recipient)
{
    global $PDO;
    return 5 * count_meeting_requests();
}

// int
function count_meetings_scheduled($recipient)
{
    global $PDO;
    
}

// int
function count_people_interacted_with($recipient)
{
    global $PDO;
    
}
?>
