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
            print $msg . ' YES in ' . $subject . PHP_EOL;
            return true;
        } else {
            print $msg . ' not in ' . $subject . PHP_EOL;
        }
    }
    return false;
}

function create_meeting_request($type, $date_received, $recipient,
    $sender_email, $sender_name, $constraints_after=null, $constraints_before=null,
    $requested_date=null, $hours=0, $subject) {

    global $PDO;
    $query = 'INSERT INTO `meeting_requests` (`type`,
        `date_received`, `recipient`, `sender_email`, `sender_name`,
        `constraints_after`, `constraints_before`, `requested_date`, `hours`, `subject`) VALUES
        (:type, :date_received, :recipient, :sender_email,
        :sender_name, :constraints_after, :constraints_before,
        :requested_date, :hours, :subject);';
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
    global $PDO;
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
    return intval(7);
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

?>
