TEST TEST test
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<!-- Header [Brand and toggle get grouped for better mobile display] -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <!-- LOGO -->
            <a href="../index.php" class="navbar-brand" target="_blank">
                <i class="glyphicon glyphicon-home"></i>
            </a>
            <p class="navbar-text">
                Admin Panel : ระบบจัดการข้อมูล
            </p>
    </div>
<!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$_SESSION['m_name'];?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="admin.php"><i class="fa fa-fw fa-user"></i> ผู้ดูแลระบบ</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> ออกจากระบบ</a>
                </li>
            </ul>
        </li>
    </ul>
<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            
            <!--
            <li>
                <a href="owner.php" data-toggle="collapse" data-target="#menu2"><i class="fa fa-fw fa-user"></i> เจ้าของ </a>
            </li>
            -->
            
            <li>
                <a href="villa-package-list.php" data-toggle="collapse" data-target="#menu4"><i class="fa fa-fw fa-bars"></i> Villa+Package</a>
            </li>
            <li>
                <a href="villa-guest-list.php" data-toggle="collapse" data-target="#menu5"><i class="fa fa-fw fa-bars"></i> Villa+Guest</a>
            </li>
            <!--
            <li>
                <a href="villa-guest.php?owner_id=2" data-toggle="collapse" data-target="#menu6"><i class="fa fa-fw fa-bars"></i> ผุ้เข้าพัก ของ วิลล่า</a>
            </li>
            -->
            <li>
                <a href="admin.php" data-toggle="collapse" data-target="#menu1"><i class="fa fa-fw fa-wrench"></i> ผู้ดูแลระบบ </a>
            </li>
            <li>
                <a href="villa-list.php" data-toggle="collapse" data-target="#menu3"><i class="fa fa-fw fa-home"></i> วิลล่า </a>
            </li>
            <li>
                <a href="internet-package.php" data-toggle="collapse" data-target="#menu7"><i class="fa fa-fw fa-wifi"></i> Internet Package </a>
            </li>
            <li>
            
                <a href="tv-package.php" data-toggle="collapse" data-target="#menu8"><i class="fa fa-fw fa-tv" ></i> TV Package</a>
            </li>
            <li>
                <a href="service-company.php" data-toggle="collapse" data-target="#menu9"><i class="fa fa-fw fa-home"></i>Service Company</a>
            </li>
            <li>
                <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> ออกจากระบบ</a>
            </li>
        </ul>
    </div>
</nav>
