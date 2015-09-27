<!DOCTYPE html>
<html lang="en">
<head>
    <title>SB Admin - Bootstrap Admin Template</title>
    <?php require('includes/head.php'); ?>
</head>

<body>
    <div id="wrapper">
        <?php require('includes/navigation.php'); ?>

        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Statistics overview</small>
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comment fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ current_meeting_requests }}</div>
                                        <div>Current Meeting Requests</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-hourglass fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ time_saved }}</div>
                                        <div>Time Saved</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-calendar-check-o fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ meetings_scheduled }}</div>
                                        <div>Meetings Scheduled</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ people_interacted_with }}</div>
                                        <div>People Interacted With</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Area Chart</h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-area-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require('includes/scripts.php'); ?>
    
    <script>
    $(function() {
        // Area Chart
        Morris.Area({
            element: 'morris-area-chart',
            data: [
                {% for day in daily %}
                    {
                        period: "{{ day.period }}",
                        requests: {{ day.requests }},
                    },
                {% endfor %}
            ],
            xkey: 'period',
            ykeys: ['requests'],
            labels: ['Requests'],
            pointSize: 2,
            hideHover: 'auto',
            resize: true,
            parseTime: false,
        });
    });
    </script>
</body>
</html>