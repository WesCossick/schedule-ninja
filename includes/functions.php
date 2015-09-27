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

function is_meeting_request($subject, $main_body) {
    $messages = array('meeting request', 'let\'s meet', 'meeting', 'wanna netflix and chill');
    foreach ($messages as $msg) {
        if (stripos($subject, $msg) !== false) {
            return true;
        }
    }
    return false;
}

function create_meeting_request($type, $date_received, $recipient,
    $sender_email, $sender_name, $constraints_after=null, $constraints_before=null,
    $requested_date=null, $hours=0, $subject, $message_id) {

    global $PDO;
    $query = 'INSERT INTO `meeting_requests` (`type`,
        `date_received`, `recipient`, `sender_email`, `sender_name`,
        `constraints_after`, `constraints_before`, `requested_date`, `hours`, `subject`, `message_id`) VALUES
        (:type, :date_received, :recipient, :sender_email,
        :sender_name, :constraints_after, :constraints_before,
        :requested_date, :hours, :subject, :message_id);';
    try {
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
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
            'hours' => $hours,
            'subject' => $subject,
            'message_id' => $message_id,
        );
        $stmt->execute($params);
    }
    catch(Exception $e) {
        echo 'Exception -> ';
        var_dump($e->getMessage());
    }
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
    $mins = intval(8.33 * count_meetings_scheduled($recipient));
    $hrs = intval($mins /  60);
    $mins %= 60;
    return $hrs . 'h ' . $mins . 'm';
}

// int
function count_meetings_scheduled($recipient)
{
    global $PDO;
    return intval(4);
}

// int
function count_people_interacted_with($recipient)
{
    global $PDO;
    $query = 'SELECT COUNT(DISTINCT sender_email) FROM meeting_requests WHERE recipient = :recipient';
    $stmt = $PDO->prepare($query);
    $stmt->execute(array('recipient' => $recipient));
    return intval($stmt->fetchColumn());
}

function meeting_invitations($email)
{
    global $PDO;
    // Do something
    $query = "SELECT * FROM meeting_requests WHERE sender_email = :sender_email";
    $statement = $PDO->prepare($query);
    $params = array(
        'sender_email' => $sender_email,
    );
    $statement->execute($params);
    $rows = $statement->fetchAll();
    
    // Return
    return $rows;
}

function save_refresh_token($email, $refresh_token)
{
    global $PDO;
    
    $query = 'UPDATE users SET refresh_token = :refresh_token WHERE email = :email';
    
    $insert_token = $PDO->prepare($query);
    
    $params = array(
       'refresh_token' => $refresh_token,
       'email' => $email,
   );
    
    $insert_token->execute($params);
}

function days_gone_by($recipient)
{
    $requests = array();
    
    for($i = 7; $i >=0; $i--)
    {
        global $PDO;
        
        $current = date('Y-m-d', (time() + (($i*(-1)+1) * 24 * 60 * 60)));
        $yesterday = $nextWeek = time() + (($i*(-1)) * 24 * 60 * 60);
        $past = date('Y-m-d', $yesterday);
        
        $current_date = date('l', strtotime('-'.$i.'days'));
        $query = 'SELECT COUNT(*) FROM meeting_requests WHERE recipient = :email AND date_received >= :past AND date_received <= :current';
        $stmt = $PDO->prepare($query);
        $params = array(
            'email' => $email,
            'past' => $past,
            'current' => $current,
        );
        $stmt->execute($params);
        
        $requests[] = array('period' => $current_date,
        'requests' => $stmt->fetch());
    }
    return $requests;
}

?>
