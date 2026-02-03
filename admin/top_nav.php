<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav class="" role="navigation">
            <div class="nav toggle">
                <a id="menu_toggle" href="javascript:void(0);">
                    <i class="fa fa-bars"></i>
                </a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <?php
                include('include/dbcon.php');
                $user_query=mysqli_query($con,"select * from admin where admin_id='$id_session'")or die(mysqli_error());
                $row=mysqli_fetch_array($user_query); {
                ?>
                <li class="dropdown">
                    <a href="javascript:void(0);" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <?php if($row['admin_image'] != ""): ?>
                        <img src="upload/<?php echo $row['admin_image']; ?>" style="width: 29px; height: 29px; border-radius: 50%; margin-right: 5px;">
                        <?php else: ?>
                        <img src="images/user.png" style="width: 29px; height: 29px; border-radius: 50%; margin-right: 5px;">
                        <?php endif; ?> 
                        <?php echo $row['firstname']; ?>
                        <span class="fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                        <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                </li>
                <?php } ?>
            </ul>
            
            <!-- Clearfix for proper layout -->
            <div class="clearfix"></div>
        </nav>
    </div>
</div>
<!-- /top navigation -->