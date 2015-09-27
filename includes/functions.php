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
?>