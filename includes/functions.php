<?php
function meeting_requests($user_recipient)
{
    global $PDO;
    // Do something
    $query = "SELECT * FROM meeting_requests WHERE recipient = :user_recipient";
    $statement = $PDO->prepare($query);
    $params = array(
        'user_recipient' => $user_recipient,
    );
    $statement->execute($params);
    $rows = $statement->fetchAll();
    
    // Return
    return $rows;
}

function create_meeting_request($type, $date_received, $recipient, 
    $sender_email, $sender_name, $constraints_after, $constraints_before, 
    $requested_date) {

    global $PDO;
    $query = 'INSERT INTO `meeting_requests` (`meeting_request_id`, `type`,'.  
        '`date_received`, `recipient`, `sender_email`, `sender_name`, '.
        '`constraints_after`, `constraints_before`, `requested_date`) VALUES '.
        '(NULL, :type, :date_received, :recipient, :sender_email,'.
        ':sender_name, :constraints_after, :constraints_before,'.
        ':requested_date);';

    $stmt = $PDO->prepare($query);
    $params = array(
        'type' => $type,
        'date_received' => $date_received,
        'recipient' => $recipient,
        'sender_email' => $sender_email,
        'sender_name' => $sender_name,
        'constraints_after' => $constraints_after,
        'constraints_before' => $constraints_before,
        'requested_date' => $requested_date,
    );
    $stmt->execute($params);
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

   return intval($stmt->fetchColumn());
}

function get_time_saved($recipient)
{
    global $PDO;
    $mins = intval(8.33 * count_meeting_requests($recipient));
    $hrs = intval($mins /  60);
    $mins %= 60;
    return $hrs . 'h ' . $mins . 'm';
}

// int
function count_meetings_scheduled($recipient)
{
    global $PDO;
    return intval(0);
}

// int
function count_people_interacted_with($recipient)
{
    global $PDO;
    return intval(0);
}
?>
