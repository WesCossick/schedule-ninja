<?php
function meeting_requests($user_recipient)
{
    // Do something
    $query = "SELECT * FROM meeting_requests WHERE user_recipient = :user_recipient";
    $statement = $PDO->prepare($query);
    $params = array(
        'user_recipient' => $user_recipient,
    );
    $statement->execute($params);
    $rows = $statement->fetchAll();
    
    // Return
    return $rows;
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