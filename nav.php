<div class="lime-sidebar">
        <div class="lime-sidebar-inner slimscroll">
            <ul class="accordion-menu">
                <li class="sidebar-title">
                    Hello
                    <?php echo $username ?>
                </li>
                <li>
                    <a href="index2.php?page=dashboard"><i class="material-icons">airplay</i>Mining Dashboard</a>
                </li>

                <li>
                    <a href="index2.php?page=deposit"><i class="material-icons">queue_play_next</i>Deposit</a>
                </li>
                <li>
                    <a href="index2.php?page=mining_list"><i class="material-icons">subject</i>Mining List</a>
                </li>
                <li>
                    <a href="index2.php?page=withdraw"><i class="material-icons">remove_from_queue</i>Withdraw</a>
                </li>
                <li>
                    <a href="#"><i class="material-icons">update</i>Mining Reports<i
                            class="material-icons has-sub-menu">keyboard_arrow_left</i></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="index2.php?page=history" onclick="go('deposit');">Deposit History</a>
                        </li>
                        <li>
                            <a href="index2.php?page=history" onclick="go('earning');">Earnings History</a>
                        </li>

                        <li>
                            <a href="index2.php?page=history" onclick="go('withdrawal');">Withdrawals
                                History</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="index2.php?page=account"><i class="material-icons">person_add</i>My Profile</a>
                </li>
                <li>
                    <a href="index2.php?page=referral"><i class="material-icons">people_alt</i>My Referrals</a>
                </li>
                <li>
                    <a href="index2.php?page=promotion"><i class="material-icons">build</i>Promotional Tools</a>
                </li>
                <li>
                    <a href="index2.php?page=security"><i class="material-icons">enhanced_encryption</i>Security</a>
                </li>
                <li>
                    <a href="auth/logout.php"><i class="material-icons">power_settings_new</i>Logout</a>
                </li>
                <br>
                <div id="ytWidget" style="overflow-y:scroll; height:300px"></div>
                <script
                    src="https://translate.yandex.net/website-widget/v1/widget.js?widgetId=ytWidget&pageLang=en&widgetTheme=light&autoMode=false"
                    type="text/javascript"></script>

            </ul>
        </div>
    </div>

    <div class="lime-header">
        <nav class="navbar navbar-expand-lg">
            <section class="material-design-hamburger navigation-toggle">
                <a href="javascript:void(0)" class="button-collapse material-design-hamburger__icon">
                    <span class="material-design-hamburger__layer"></span>
                </a>
            </section>
            <a class="navbar-brand" href="#">Legator Digital</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="material-icons">keyboard_arrow_down</i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a class="dropdown-item" href="index2.php?page=account">Account</a></li>
                            <li><a class="dropdown-item" href="index2.php?page=support">Support</a></li>
                            <li class="divider"></li>
                            <li><a class="dropdown-item" href="auth/logout.php">Log Out</a>
                            </li>

                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

