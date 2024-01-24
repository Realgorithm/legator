<?php
include 'auth/user_details.php';
// Check if the user is authenticated
if (!isset( $_SESSION['username'])) {
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
                            <p>It’s super simple - Your trading rigs are already set up and
                                running.Don’t make mistakes and loose your money while tring to make
                                trading calls. We have the most profitbale team running for you
                                already!</p>
                            <ul>
                                <li>Choose the package you want to invest from deposit page</li>
                                <li>Select the e-currency you are suitable with.</li>
                                <li>Your earnings will be started according to the intervals of
                                    packages.</li>
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
                    <h5 class="card-title">Mining Balance</h5>
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
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="45"
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
                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="60"
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