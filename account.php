<?php
// Include the contents of header.php
include('auth/get_user_details.php');
?>

<div class="card">
    <h5 class="card-header bg-primary text-white">Profile</h5>
    <div class="card-body">

        <script language=javascript>
            function IsNumeric(sText) {
                var ValidChars = "0123456789.";
                var IsNumber = true;
                var Char;
                if (sText == '') return false;
                for (i = 0; i < sText.length && IsNumber == true; i++) {
                    Char = sText.charAt(i);
                    if (ValidChars.indexOf(Char) == -1) {
                        IsNumber = false;
                    }
                }
                return IsNumber;
            }

            function checkform() {
                if (document.editform.fullname.value == '') {
                    alert("Please type your full name!");
                    document.editform.fullname.focus();
                    return false;
                }


                if (document.editform.password.value != document.editform.password2.value) {
                    alert("Please check your password!");
                    document.editform.fullname.focus();
                    return false;
                }




                if (document.editform.email.value == '') {
                    alert("Please enter your e-mail address!");
                    document.editform.email.focus();
                    return false;
                }



                for (i in document.editform.elements) {
                    f = document.editform.elements[i];
                    if (f.name && f.name.match(/^account/)) {
                        if (f.value == '') continue;
                        var notice = f.getAttribute('data-validate-notice');
                        var invalid = 0;
                        if (f.getAttribute('data-validate') == 'regexp') {
                            var re = new RegExp(f.getAttribute('data-validate-regexp'));
                            if (!f.value.match(re)) {
                                invalid = 1;
                            }
                        } else if (f.getAttribute('data-validate') == 'email') {
                            var re = /^[^\@]+\@[^\@]+\.\w{2,4}$/;
                            if (!f.value.match(re)) {
                                invalid = 1;
                            }
                        }
                        if (invalid) {
                            alert('Invalid account format. Expected ' + notice);
                            f.focus();
                            return false;
                        }
                    }
                }

                return true;
            }
        </script>


        <form method=post action="auth/update_user_details.php" onsubmit="return checkform()" name=editform>
            <input type="hidden" name="form_id" value="17035927984907">
            <input type="hidden" name="form_token" value="7f8249deadd4a4d1898f40e420a4d9d9">
            <input type=hidden name=a value=edit_account>
            <input type=hidden name=action value=edit_account>
            <input type=hidden name=say value="">

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td class="title">Account Name:</td>
                        <td>
                            <?php echo $username ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="title">Registration date:</td>
                        <td>
                            <?php echo $formattedTimestamp ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="title">Your Full Name:</td>

                        <td><input type=text name=fullname value='<?php echo $fullname ?>' class="form-control"></td>

                    </tr>

                    <tr>
                        <td class="title">New Password:</td>
                        <td><input type=password name=password value="" class="form-control"></td>
                    </tr>
                    <tr>
                        <td class="title">Retype Password:</td>
                        <td><input type=password name=password2 value="" class="form-control"></td>
                    </tr>
                    <tr>
                        <td class="title">Your USDT ERC20 Account ID:</td>
                        <td><input type=text class="form-control" name="account" value='<?php echo $accountNo ?>'></td>
                    </tr>
                    <tr>
                        <td class="title">Your E-mail address:</td>
                        <td>
                            <?php echo $email ?>
                        </td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td><input type=submit value="Change Account data" class="btn btn-primary ml-auto"></td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</div>