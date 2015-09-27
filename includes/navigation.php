<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/"><img src="/assets/logo-small.png" style="height:25px;"></img></a>
    </div>
    
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['first_name'].' '.$_SESSION['last_name']; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                </li>
                
                <li class="divider"></li>
                
                <li>
                    <a href="/log-out.php"><i class="fa fa-fw fa-power-off"></i> Log out</a>
                </li>
            </ul>
        </li>
    </ul>
    
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li <?php if($_SERVER['REQUEST_URI'] == '/') echo 'class="active"'; ?>>
                <a href="/"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            
            <li <?php if($_SERVER['REQUEST_URI'] == '/requests') echo 'class="active"'; ?>>
                <a href="/requests"><i class="fa fa-fw fa-comment"></i> Requests</a>
            </li>
            
            <li <?php if($_SERVER['REQUEST_URI'] == '/invitations') echo 'class="active"'; ?>>
                <a href="/requests"><i class="fa fa-fw fa-arrow-circle-right"></i> Invitations</a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>