<?php
include 'auth/user_details.php';
// Check if the user is authenticated
if (!isset($_SESSION['username'])) {
    // Redirect to the login page or handle unauthenticated access
    header("Location: index.php");
    exit();
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="dashboard-info row">
                        <div class="info-text">
                            <h5 class="card-title">Welcome back
                                <?php echo $username ?>
                            </h5>
                            <p>"It's easy – our trading rigs are up and running. No need to worry about making mistakes
                                and losing money while trying to make trading calls. We've got a highly profitable team
                                working for you!

                                Pick the package you want on the deposit page.
                                Choose the e-currency that works for you.
                                Start earning based on the package intervals."</p>
                            <ul>
                                <li><b>Sit Back and Relax:</b>
                                    Once you've chosen your package and selected your preferred e-currency, there's
                                    nothing more for you to do. Our trading rigs are already in action, working to
                                    maximize your earnings.</li>
                                <li><b>Keep an Eye on Your Profits:</b>
                                    You can monitor your profits as they roll in. No need for complicated trading
                                    decisions – we've got it covered.</li>
                                <li><b>Withdraw Your Earnings:</b>
                                    When you're ready to enjoy your earnings, simply follow the easy withdrawal process.
                                    It's hassle-free and designed with your convenience in mind.</li>
                                <li><b>24/7 Support:</b>
                                    If you ever have questions or need assistance, our support team is available around
                                    the clock. We're here to make your experience smooth and stress-free.</li>
                            </ul>

                            <!-- TradingView Widget END -->
                            <br><br>
                            <a href="index2.php?page=deposit" class="btn btn-warning m-t-xs">Start
                                Mining</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">

        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <h5 class="card-title">Total Balance</h5>
                    <h2 class="float-right">$
                        <?php echo $totalAmount ?>
                    </h2>

                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="45"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <h5 class="card-title">Active Rigs</h5>
                    <h2 class="float-right">$
                        <?php echo $rigs ?>
                    </h2>

                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="45"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <h5 class="card-title">Total Mining</h5>
                    <h2 class="float-right">$
                        <?php echo $totalMining ?>
                    </h2>

                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="60"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <h5 class="card-title">Total Withdrawals</h5>
                    <h2 class="float-right">$
                        <?php echo $withdraw ?>
                    </h2>

                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="45"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <h5 class="card-title">Pending Withdrawals</h5>
                    <h2 class="float-right">$
                        <?php echo $pending_withdraw ?>
                    </h2>

                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="45"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body">
                    <h5 class="card-title">Total Earning</h5>
                    <h2 class="float-right">$
                        <?php echo $earning ?>
                    </h2>

                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="45"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row content">
        <div class="col-sm-12 text-left">
            <div class="card my-4">
                <h5 class="card-header bg-primary text-white">Trading Statistics</h5>
                <div class="card-body">
                    <div class="row">

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Referral Link</td>
                                        <td>https://Legatordigitalpro.com?ref=<?php echo$username ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Upline Name</td>
                                        <td>
                                            <?php echo $fullname ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Total Balance</td>
                                        <td>$<b>
                                                <?php echo $totalAmount ?>
                                            </b><br>
                                            <small>
                                            </small>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Total Earning</td>
                                        <td>$
                                            <?php echo $earning ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Active Deposit</td>
                                        <td>$
                                            <?php echo $deposit ?>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>Last Access</td>
                                        <td>
                                            <?php echo Date("Y-m-d H:i:s", $lastAccessTime); ?>&nbsp;
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<br><br>
<br>
<!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
    <div class="tradingview-widget-container__widget">
    </div>
    <div class="tradingview-widget-copyright">
        <a href="https://www.tradingview.com/" rel="noopener" target="_blank">
            <span class="blue-text">
                Ticker Tape
            </span>
        </a>
        by TradingView
    </div>
    <script async src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js"
        type="text/javascript">
            {
                "symbols": [
                    { "title": "S&P 500", "proName": "OANDA:SPX500USD" },
                    { "title": "Nasdaq 100", "proName": "OANDA:NAS100USD" },
                    { "title": "EUR/USD", "proName": "FX_IDC:EURUSD" },
                    { "title": "BTC/USD", "proName": "BITSTAMP:BTCUSD" },
                    { "title": "ETH/USD", "proName": "BITSTAMP:ETHUSD" }
                ],
                    "colorTheme": "dark",
                        "isTransparent": false,
                            "displayMode": "adaptive",
                                "locale": "en"
            }
        </script>
</div>
<!-- TradingView Widget END -->