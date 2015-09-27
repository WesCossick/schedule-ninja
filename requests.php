<?php require($_SERVER['DOCUMENT_ROOT'].'/config/main.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>SB Admin - Bootstrap Admin Template</title>
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
                    <?php foreach(meeting_requests($_SESSION['email']) as $meeting_request){ ?>
                        <?php print_r($meeting_request); ?>
                        
                        <div class="clearfix visible-lg-block"></div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php require($_SERVER['DOCUMENT_ROOT'].'/includes/scripts.php'); ?>
</body>
</html>