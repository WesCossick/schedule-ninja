<?php require($_SERVER['DOCUMENT_ROOT'].'/config/main.php'); ?>

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
                    <?php
                    $count = 0;
                    foreach(meeting_invitations($_SESSION['email']) as $meeting_invitation)
                    {
                    ?>
                        <div class="col-xs-12 col-lg-6">
                            <div class="email_box">
                                <div class="top_half">
                                    <h3><?php echo $meeting_invitation['recipient_name']; ?> <small>Sent <?php if($meeting_request['type'] == 'direct') { ?>
                                        invitation
                                    <?php } else { ?>
                                        availability
                                    <?php } ?></small></h3>
                                    
                                    <?php if($meeting_request['type'] == 'direct'){ ?>
                                        <?php if($meeting_request['hours'] != 0){ ?>
                                            The meeting will last <strong>about
                                            <?php
                                            if($meeting_request['hours'] == .5)
                                                echo 'half an hour';
                                            else if($meeting_request['hours'] == 1)
                                                echo 'an hour';
                                            else if($meeting_request['hours'] == 1.5)
                                                echo 'an hour and a half';
                                            else if($meeting_request['hours'] == 2)
                                                echo 'two hours';
                                            else if($meeting_request['hours'] == 2.5)
                                                echo 'two and a half hours';
                                            else if($meeting_request['hours'] == 3)
                                                echo 'three hours';
                                            else if($meeting_request['hours'] == 3.5)
                                                echo 'three and a half hours';
                                            else if($meeting_request['hours'] == 4)
                                                echo 'four hours';
                                            else if($meeting_request['hours'] == 5)
                                                echo 'five hours';
                                            else if($meeting_request['hours'] == 6)
                                                echo 'six hours';
                                            ?></strong>.
                                        <?php } ?>
                                        
                                        <?php
                                        if($meeting_request['connected_with'])
                                        {
                                            $query = "SELECT * FROM meeting_requests WHERE connected_with = :connected_with AND recipient != :email";
                                            $statement = $PDO->prepare($query);
                                            $params = array(
                                                'connected_with' => $meeting_request['connected_with'],
                                                'email' => $_SESSION['email'],
                                            );
                                            $statement->execute($params);
                                            
                                            while($row = $statement->fetch())
                                            {
                                                $names[] = $row['recipient_name'];
                                            }
                                            
                                            echo '<strong>You, '.implode(', ', $names).'</strong> have all been invited.';
                                        }
                                        ?>
                                    <?php } else { ?>
                                        <?php echo $meeting_request['body']; ?>
                                    <?php } ?>
                                    
                                    <div class="date">
                                        Sent <?php echo date('F j, g:ia', strtotime($meeting_request['date_received'])); ?>
                                        
                                        <?php
                                        if($meeting_request['type'] == 'direct')
                                        {
                                            echo 'via direct invite';
                                        }
                                        else
                                        {
                                            echo 'to '.$meeting_request['recipient'];
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