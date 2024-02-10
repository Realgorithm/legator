<?php
include 'auth/user_details.php';
// Check if the user is authenticated
if (!isset($_SESSION['username'])) {
    // Redirect to the login page or handle unauthenticated access
    header("Location: home?error=login");
    exit();
}
?>
<style>
    .icon {
        width: 30px;
        height: 30px;
        margin-right: 10px;
        cursor: pointer;
    }
</style>
<div class="col-md-12">
    <script>
        <?php if (isset($updateMessage)) : ?>
            showErrorMessage('<?php echo $updateMessage ?>', 'success')
        <?php endif ?>
    </script>
    <div class="card bg-info text-white">
        <div class="card-body">
            <div class="dashboard-info row">
                <div class="info-text">
                    <h5 class="card-title">Welcome back, <span style="text-transform: capitalize;"><?php echo $username ?></span>

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
<div class="row">

    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <h5 class="card-title">Total Balance</h5>
                <h2 class="float-right">$
                    <?php echo $totalAmount ?>
                </h2>

                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
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
                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
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
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
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
                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body">
                <h5 class="card-title">Referral Income</h5>
                <h2 class="float-right">$
                    <?php echo $referal ?>
                </h2>

                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
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
                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
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
                                    <td class="title">Referral Link</td>
                                    <td>https://legator.pro/signup?ref=<?php echo $username ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="title">Upline Name</td>
                                    <td>
                                        <?php echo $fullname ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="title">Total Balance</td>
                                    <td>$<b>
                                            <?php echo $totalAmount ?>
                                        </b><br>
                                        <small>
                                        </small>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="title">Total Earning</td>
                                    <td>$
                                        <?php echo $earning ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="title">Pending Withdraw</td>
                                    <td>$
                                        <?php echo $pending_withdraw ?>
                                    </td>
                                </tr>


                                <tr>
                                    <td class="title">Last Access</td>
                                    <td>
                                        <?php echo $lastAccessTime ?>&nbsp;
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4"><b>Refer to your friends: </b></div>
                            <div class="col-md-8">
                                <!-- Icons for platforms -->
                                <img class="icon" src="images/facebook.png" alt="Facebook" id="facebookIcon">
                                <img class="icon" src="images/twitter.png" alt="Twitter" id="twitterIcon">
                                <img class="icon" src="images/linkedin.png" alt="LinkedIn" id="linkedinIcon">
                                <img class="icon" src="images/pinterest.png" alt="Pinterest" id="pinterestIcon">
                                <img class="icon" src="images/whatsapp.png" alt="WhatsApp" id="whatsappIcon">
                                <img class="icon" src="images/gmail.png" alt="Email" id="emailIcon">
                                <img class="icon" src="images/social.png" alt="copy" id="copyLinkButton">
                            </div>

                            <script>
                                // URL of the referral link
                                const referralLink = "https://legator.pro/signup?ref=<?php echo $username ?>";

                                // Description to be shared
                                const description = "Join the mining revolution today! Sign up and earn a $10 bonus instantly. Plus, boost your earnings further by inviting friends and get an extra 8% bonus on their mining rewards. Don't miss out on this lucrative opportunity to multiply your crypto earnings effortlessly!";

                                // Image URL to be shared
                                const imageUrl = "https://i.ibb.co/g6S6W32/Screenshot-10-Copy.png";


                                // Function to handle sharing on each platform
                                function shareOnPlatform(platform) {
                                    // Shareable link for the selected platform
                                    const shareLink = {
                                        facebook: `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(referralLink)}&quote=${encodeURIComponent(description)}`,
                                        twitter: `https://twitter.com/intent/tweet?url=${encodeURIComponent(referralLink)}&text=${encodeURIComponent(description)}`,
                                        linkedin: `https://www.linkedin.com/shareArticle?url=${encodeURIComponent(referralLink)}&title=${encodeURIComponent(document.title)}&summary=${encodeURIComponent(description)}`,
                                        pinterest: `https://pinterest.com/pin/create/button/?url=${encodeURIComponent(referralLink)}&description=${encodeURIComponent(description)}&media=${encodeURIComponent(imageUrl)}`,
                                        whatsapp: `https://api.whatsapp.com/send?text=${encodeURIComponent(description + '\n' + referralLink)}&image=${encodeURIComponent(imageUrl)}`,
                                        email: `mailto:?subject=${encodeURIComponent(document.title)}&body=${encodeURIComponent(description + '\n' + referralLink)}`,
                                    };

                                    // Open the share link for the selected platform
                                    window.open(shareLink[platform], '_blank');
                                }

                                // Function to copy the referral link to clipboard
                                function copyReferralLink() {
                                    const textField = document.createElement('textarea');
                                    textField.innerText = referralLink;
                                    document.body.appendChild(textField);
                                    textField.select();
                                    document.execCommand('copy');
                                    textField.remove();

                                    // Show a popup message indicating that the link has been copied
                                    const popup = document.createElement('div');
                                    popup.innerText = 'Link copied!';
                                    popup.style.position = 'fixed';
                                    popup.style.bottom = '30%';
                                    popup.style.left = '45%';
                                    popup.style.transform = 'translateX(-50%)';
                                    popup.style.padding = '10px 20px';
                                    popup.style.backgroundColor = '#389020';
                                    popup.style.color = '#fff';
                                    popup.style.borderRadius = '5px';
                                    popup.style.boxShadow = '0 0 10px rgba(0, 0, 0, 0.5)';
                                    popup.style.zIndex = '9999';
                                    document.body.appendChild(popup);
                                    console.log("text");

                                    // Remove the popup after 2 seconds
                                    setTimeout(function() {
                                        popup.remove();
                                    }, 2000);
                                }

                                // Add click event listeners to each platform icon
                                document.getElementById('facebookIcon').addEventListener('click', function() {
                                    shareOnPlatform('facebook');
                                });

                                document.getElementById('twitterIcon').addEventListener('click', function() {
                                    shareOnPlatform('twitter');
                                });

                                document.getElementById('linkedinIcon').addEventListener('click', function() {
                                    shareOnPlatform('linkedin');
                                });

                                document.getElementById('pinterestIcon').addEventListener('click', function() {
                                    shareOnPlatform('pinterest');
                                });

                                document.getElementById('whatsappIcon').addEventListener('click', function() {
                                    shareOnPlatform('whatsapp');
                                });

                                document.getElementById('emailIcon').addEventListener('click', function() {
                                    shareOnPlatform('email');
                                });
                                // Add click event listener to the "Copy Link" button
                                document.getElementById('copyLinkButton').addEventListener('click', function() {
                                    copyReferralLink();
                                });
                            </script>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Button to trigger the share functionality -->
                        <button id="shareButton" class="btn btn-warning m-t-xs">Share Referral Link</button>
                        <script>
                            document.getElementById('shareButton').addEventListener('click', function() {

                                // // Share on different platforms
                                if (navigator.share) { // Check if the navigator.share API is supported
                                    navigator.share({
                                            title: document.title,
                                            text: description,
                                            url: referralLink,
                                        })
                                        .then(() => console.log('Successful share'))
                                        .catch((error) => console.log('Error sharing:', error));
                                } else { // Fallback for platforms that do not support navigator.share
                                    const shareUrl = `mailto:?subject=${encodeURIComponent(document.title)}&body=${encodeURIComponent(description + '\n' + referralLink)}`;
                                    window.location.href = shareUrl;

                                    // Social media platforms
                                    const platforms = {
                                        facebook: `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(referralLink)}&quote=${encodeURIComponent(description)}`,
                                        twitter: `https://twitter.com/intent/tweet?url=${encodeURIComponent(referralLink)}&text=${encodeURIComponent(description)}`,
                                        linkedin: `https://www.linkedin.com/shareArticle?url=${encodeURIComponent(referralLink)}&title=${encodeURIComponent(document.title)}&summary=${encodeURIComponent(description)}`,
                                        pinterest: `https://pinterest.com/pin/create/button/?url=${encodeURIComponent(referralLink)}&description=${encodeURIComponent(description)}&media=${encodeURIComponent(imageUrl)}`,
                                        whatsapp: `whatsapp://send?text=${encodeURIComponent(description + '\n' + referralLink)}`,
                                        email: `mailto:?subject=${encodeURIComponent(document.title)}&body=${encodeURIComponent(description + '\n' + referralLink)}`,
                                    };

                                    // Open share links for each platform
                                    for (const platform in platforms) {
                                        window.open(platforms[platform], '_blank');
                                    }
                                }

                            });
                        </script>
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
        <script async src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" type="text/javascript">
            {
                "symbols";
                [{
                        "title": "S&P 500",
                        "proName": "OANDA:SPX500USD"
                    },
                    {
                        "title": "Nasdaq 100",
                        "proName": "OANDA:NAS100USD"
                    },
                    {
                        "title": "EUR/USD",
                        "proName": "FX_IDC:EURUSD"
                    },
                    {
                        "title": "BTC/USD",
                        "proName": "BITSTAMP:BTCUSD"
                    },
                    {
                        "title": "ETH/USD",
                        "proName": "BITSTAMP:ETHUSD"
                    }
                ],
                "colorTheme";
                "dark",
                "isTransparent";
                false,
                "displayMode";
                "adaptive",
                "locale";
                "en"
            }
        </script>
    </div>
    <!-- TradingView Widget END -->