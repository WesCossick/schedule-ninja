<?php
function meeting_requests()
{
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

function count_meeting_requests()
{
    
}

function get_time_saved()
{
    
}

function count_meetings_scheduled()
{
    
}

function count_people_interacted_with()
{
    
}
?>