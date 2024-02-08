<?php
include 'auth/conn.php';
// session_start();
?>

    <div class="card">
        <h5 class="card-header bg-primary text-white">Referals</h5>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">S No</th>
                            <th scope="col">Level</th>
                            <th scope="col">Total referral commission</th>
                            <th scope="col">Referral Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query2 = "SELECT * FROM referrals WHERE referrername = ?";
                        $stmtGetUser = $connect_db->prepare($query2);
                        $stmtGetUser->bind_param("s", $_SESSION['username']);
                        $stmtGetUser->execute();
                        $result2 = $stmtGetUser->get_result();
                        // Check if the user exists
                        if ($result2->num_rows > 0) {
                            $sno = 1;
                            while ($row = $result2->fetch_assoc()) {
                                $amount = $row['amount'];
                                $refereeName = $row['refereename'];
                                $level = $row['level'];
                                echo '
                                                            <tr>
                                                                <td>
                                                                     ' . $sno . '
                                                                </td>
                                                                <td>
                                                                    ' . $level . '
                                                                </td>
                                                                <td>$
                                                                    ' . $amount . '
                                                                </td>
                                                                <td>
                                                                    ' . $refereeName . '
                                                                </td>
                                                            </tr>';
                                                            $sno++;
                            }
                            
                        } else {
                            // echo "No deposits to process.<br>";
                        }
                        ?>

                    </tbody>
                </table>

            </div>

            <br>

        </div>
    </div>