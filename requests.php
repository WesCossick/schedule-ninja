<?php require($_SERVER['DOCUMENT_ROOT'].'/config/main.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Requests - Schedule Ninja</title>
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

    div.email_box .bottom_half{
        background:#eee;
        border-top:1px solid #e0e0e0;
    }

    div.email_box .bottom_half table{
        width:100%;
        margin:0;
        padding:0;
    }

    div.email_box .bottom_half table td{
        width:50%;
        margin:0;
        padding:15px;
        text-align:center;
        cursor:pointer;
    }

    div.email_box .bottom_half table td:not(:last-child){
        border-right:#e0e0e0 solid 1px;
    }

    div.email_box .bottom_half table td i.fa-check{
        color:#5cb85c;
    }

    div.email_box .bottom_half table td i.fa-times{
        color:#d9534f;
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
                            Meeting requests <small>Last 7 days</small>
                        </h1>
                    </div>
                </div>
                
                <div class="row">
                    <?php
                    $count = 0;
                    foreach(meeting_requests($_SESSION['email']) as $meeting_request)
                    {
                    ?>
                        <div class="col-xs-12 col-lg-6">
                            <div class="email_box">
                                <div class="top_half">
                                    <h3><?php echo $meeting_request['sender_name']; ?> <small>Would like to meet
                                    
                                    <?php if(!is_null($meeting_request['constraints_after']) && !is_null($meeting_request['constraints_before'])) { ?>
                                        between <?php echo date('D (n/j)', strtotime($meeting_request['constraints_after'])); ?> and <?php echo date('D (n/j)', strtotime($meeting_request['constraints_before'])); ?>
                                    <?php } else if(!is_null($meeting_request['constraints_after'])) { ?>
                                        after <?php echo date('D (n/j)', strtotime($meeting_request['constraints_after'])); ?>
                                    <?php } else if(!is_null($meeting_request['constraints_before'])) { ?>
                                        before <?php echo date('D (n/j)', strtotime($meeting_request['constraints_before'])); ?>
                                    <?php } else if(!is_null($meeting_request['requested_date'])) { ?>
                                        on <?php echo date('D (n/j)', strtotime($meeting_request['requested_date'])); ?>
                                    <?php } else { ?>
                                        soon
                                    <?php } ?>
                                    
                                    </small></h3>
                                    
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
                                            
                                            echo '<strong>'.implode(', ', $names).' and you</strong> have been invited.';
                                        }
                                        ?>
                                    <?php } else { ?>
                                        <?php echo $meeting_request['body']; ?>
                                    <?php } ?>
                                    
                                    <div class="date">
                                        Received <?php echo date('F j, g:ia', strtotime($meeting_request['date_received'])); ?>
                                        
                                        <?php
                                        if($meeting_request['type'] == 'direct')
                                        {
                                            echo 'via direct invite';
                                        }
                                        else
                                        {
                                            echo '@ '.$meeting_request['recipient'];
                                        }
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="bottom_half">
                                    <table>
                                        <tr>
                                            <td class="approve_<?php echo $meeting_request['type']; ?>" data-senderemail="<?php echo $meeting_request['sender_email']; ?>" data-useremail="<?php echo $_SESSION['email']; ?>" data-subject="<?php echo $meeting_request['subject']; ?>" data-id="<?php echo $_SESSION['meeting_request_id']; ?>">
                                                <i class="fa fa-check"></i>
                                                
                                                <?php if($meeting_request['type'] == 'direct') { ?>
                                                    Find common time
                                                <?php } else { ?>
                                                    Reply with availability
                                                <?php } ?>
                                            </td>
                                            
                                            <td class="deny_<?php echo $meeting_request['type']; ?>" data-senderemail="<?php echo $meeting_request['sender_email']; ?>" data-useremail="<?php echo $_SESSION['email']; ?>" data-subject="<?php echo $meeting_request['subject']; ?>">
                                                <i class="fa fa-times"></i> Deny
                                            </td>
                                        </tr>
                                    </table>
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
    
    <script>
    $(document).ready(function(){
        $(".approve_email").click(function(){
            var sender_email = $(this).data("senderemail");
            var user_email = $(this).data("useremail");
            var subject = $(this).data("subject");
            var $box = $(this).closest(".email_box");
            
            $.ajax({
                method: "POST",
                url: "/approve_email",
                data: {
                    sender_email: sender_email,
                    user_email: user_email,
                    subject: subject,
                }
            }).done(function(msg){
                $box.fadeTo(250, .3);
                $box.css({
                    "pointer-events": "none",
                });
                console.log(msg);
            });
        });
        
        $(".approve_direct").click(function(){
            var sender_email = $(this).data("senderemail");
            var user_email = $(this).data("useremail");
            var id = $(this).data("id");
            var $box = $(this).closest(".email_box");
            
            $.ajax({
                method: "POST",
                url: "/approve_direct",
                data: {
                    sender_email: sender_email,
                    user_email: user_email,
                    id: id,
                }
            }).done(function(msg){
                $box.fadeTo(250, .3);
                $box.css({
                    "pointer-events": "none",
                });
                
                var data = JSON.parse(msg);
                var html = "<ul>";
                
                for(var i = 0; i < data.length && i < 3; i++)
                {
                    var start = moment.unix(data[i].start);
                    var end = moment.unix(data[i].end);
                    html += "<li>";
                    html += start.format("ddd, hA");
                    html += " ";
                    html += end.format("ddd, hA");
                    html += "</li>";
                    html += "<br>";
                }
                var html += "</ul>";
                
                $(".container-fluid").prepend("<div class='alert alert-success'><strong>Great!</strong> here are some times you are free:<br>"+html+"</div>");
            });
        });
        
        $(".deny_email").click(function(){
            var sender_email = $(this).data("senderemail");
            var user_email = $(this).data("useremail");
            var subject = $(this).data("subject");
            var $box = $(this).closest(".email_box");
            
            $.ajax({
                method: "POST",
                url: "/deny_email",
                data: {
                    sender_email: sender_email,
                    user_email: user_email,
                    subject: subject,
                }
            }).done(function(msg){
                $box.fadeTo(250, .3);
                $box.css({
                    "pointer-events": "none",
                });
                console.log(msg);
            });
        });
    });
    </script>
</body>
</html>