<?php
require($_SERVER['DOCUMENT_ROOT'].'/config/main.php');

if($_POST['email1'] != '' && $_POST['name1'] != '' && $_POST['hours'] != '')
{
    $connected_with = 0;
    if($_POST['email2'] != '' && $_POST['name2'] != '')
        $connected_with = rand();
    
    
    create_meeting_request('direct', date('Y-m-d H:i:s'), $_POST['email1'], $_SESSION['email'], $_SESSION['first_name'].' '.$_SESSION['last_name'], null, null, null, $_POST['hours'], '', null, null, $_POST['name1'], $connected_with);
    
    if($_POST['email2'] != '' && $_POST['name2'] != '')
        create_meeting_request('direct', date('Y-m-d H:i:s'), $_POST['email2'], $_SESSION['email'], $_SESSION['first_name'].' '.$_SESSION['last_name'], null, null, null, $_POST['hours'], '', null, null, $_POST['name2'], $connected_with);
        
    if($_POST['email3'] != '' && $_POST['name3'] != '')
        create_meeting_request('direct', date('Y-m-d H:i:s'), $_POST['email3'], $_SESSION['email'], $_SESSION['first_name'].' '.$_SESSION['last_name'], null, null, null, $_POST['hours'], '', null, null, $_POST['name3'], $connected_with);
        
    if($_POST['email4'] != '' && $_POST['name4'] != '')
        create_meeting_request('direct', date('Y-m-d H:i:s'), $_POST['email4'], $_SESSION['email'], $_SESSION['first_name'].' '.$_SESSION['last_name'], null, null, null, $_POST['hours'], '', null, null, $_POST['name4'], $connected_with);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Invitations - Schedule Ninja</title>
    <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/head.php'); ?>
    
    <style>
    div.email_box{
        width:100%;
        margin:0 0 15px 0;
        background:#f5f5f5;
        box-shadow:0 0 5px rgba(0, 0, 0, .15);
        font-size:16px;
        line-height:1.2;
        border:1px solid #eaeaea;
    }

    div.email_box .top_half{
        padding:20px;
    }

    div.email_box .top_half h3{
        margin-top:0;
    }

    div.email_box .top_half div.date{
        margin-top:10px;
        font-size:12px;
        font-style:italic;
        color:#bbb;
    }
    
    form input{
        margin-bottom:5px;
    }
    </style>
</head>

<body>
    <div id="wrapper">
        <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/navigation.php'); ?>

        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Meeting invitations <small>Initiate meetings</small>
                        </h1>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12">
                        <div class="well">
                            <h3 style="margin-top:0;">Send invitation</h3>
                            <form method="post">
                                <div class="form-group">
                                    <label for="email1">Recipient email(s)</label>
                                    <input type="email" class="form-control" name="email1" id="email1" placeholder="user@example.com">
                                    <input type="email" class="form-control" name="email2" id="email2" placeholder="user@example.com">
                                    <input type="email" class="form-control" name="email3" id="email3" placeholder="user@example.com">
                                    <input type="email" class="form-control" name="email4" id="email4" placeholder="user@example.com">
                                </div>
                                
                                <div class="form-group">
                                    <label for="name1">Recipient name(s)</label>
                                    <input type="text" class="form-control" name="name1" id="name1" placeholder="John Doe">
                                    <input type="text" class="form-control" name="name2" id="name2" placeholder="John Doe">
                                    <input type="text" class="form-control" name="name3" id="name3" placeholder="John Doe">
                                    <input type="text" class="form-control" name="name4" id="name4" placeholder="John Doe">
                                </div>
                                
                                <div class="form-group">
                                    <label for="name1">Approximate length in hours</label>
                                    <input type="number" class="form-control" name="hours" id="hours" value="1" min=".5" max="6" step=".5" placeholder="1">
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                    
                    <?php
                    $count = 0;
                    foreach(meeting_invitations($_SESSION['email']) as $meeting_invitation)
                    {
                    ?>
                        <div class="col-xs-12 col-lg-6">
                            <div class="email_box">
                                <div class="top_half">
                                    <h3><?php echo $meeting_invitation['recipient_name']; ?> <small>Sent <?php if($meeting_invitation['type'] == 'direct') { ?>
                                        invitation
                                    <?php } else { ?>
                                        availability
                                    <?php } ?></small></h3>
                                    
                                    <?php if($meeting_invitation['type'] == 'direct'){ ?>
                                        <?php if($meeting_invitation['hours'] != 0){ ?>
                                            The meeting will last <strong>about
                                            <?php
                                            if($meeting_invitation['hours'] == .5)
                                                echo 'half an hour';
                                            else if($meeting_invitation['hours'] == 1)
                                                echo 'an hour';
                                            else if($meeting_invitation['hours'] == 1.5)
                                                echo 'an hour and a half';
                                            else if($meeting_invitation['hours'] == 2)
                                                echo 'two hours';
                                            else if($meeting_invitation['hours'] == 2.5)
                                                echo 'two and a half hours';
                                            else if($meeting_invitation['hours'] == 3)
                                                echo 'three hours';
                                            else if($meeting_invitation['hours'] == 3.5)
                                                echo 'three and a half hours';
                                            else if($meeting_invitation['hours'] == 4)
                                                echo 'four hours';
                                            else if($meeting_invitation['hours'] == 5)
                                                echo 'five hours';
                                            else if($meeting_invitation['hours'] == 6)
                                                echo 'six hours';
                                            ?></strong>.
                                        <?php } ?>
                                        
                                        <?php
                                        if($meeting_invitation['connected_with'])
                                        {
                                            $query = "SELECT * FROM meeting_requests WHERE connected_with = :connected_with AND recipient != :email";
                                            $statement = $PDO->prepare($query);
                                            $params = array(
                                                'connected_with' => $meeting_invitation['connected_with'],
                                                'email' => $_SESSION['email'],
                                            );
                                            $statement->execute($params);
                                            
                                            while($row = $statement->fetch())
                                            {
                                                $names[] = $row['recipient_name'];
                                            }
                                            
                                            echo '<strong>'.implode(', ', $names).' and you</strong> have been invited.';
                                        }
                                        ?>
                                    <?php } else { ?>
                                        <?php echo $meeting_invitation['body']; ?>
                                    <?php } ?>
                                    
                                    <div class="date">
                                        Sent <?php echo date('F j, g:ia', strtotime($meeting_invitation['date_received'])); ?>
                                        
                                        <?php
                                        if($meeting_invitation['type'] == 'direct')
                                        {
                                            echo 'via direct invite';
                                        }
                                        else
                                        {
                                            echo 'to '.$meeting_invitation['recipient'];
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if($count % 2 == 1) { ?>
                            <div class="clearfix visible-lg-block"></div>
                        <?php } ?>
                    <?php
                        $count++;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/scripts.php'); ?>
</body>
</html>