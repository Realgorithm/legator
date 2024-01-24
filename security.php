<h3>Advanced login security settings:</h3><br><br>

<form method=post><input type="hidden" name="form_id" value="17035927988696"><input type="hidden" name="form_token"
        value="6ee7983533cd67ab316b58353e1303c8">
    <input type=hidden name=a value="security">
    <input type=hidden name=action value="save">
    Detect IP Address Change Sensitivity<br>
    <input type=radio name=ip value=disabled checked>Disabled<br>
    <input type=radio name=ip value=medium>Medium<br>
    <input type=radio name=ip value=high>High<br>
    <input type=radio name=ip value=always>Paranoic<br><br>

    Detect Browser Change<br>
    <input type=radio name=browser value=disabled checked>Disabled<br>
    <input type=radio name=browser value=enabled>Enabled<br><br>
    <input type=submit value="Set" class=sbmt>
</form>

<h3>Two Factor Authentication</h3>
<form method=post name=mainform><input type="hidden" name="form_id" value="17035927988696"><input type="hidden"
        name="form_token" value="6ee7983533cd67ab316b58353e1303c8">
    <input type=hidden name=a value="security">
    <input type=hidden name=action value="tfa_save">
    <input type=hidden name=time>

    1. Install <a href="http://m.google.com/authenticator" targe=_blank>Google
        Authenticator</a> on your mobile
    device.<br>
    2. Your Secret Code is: <b>A6TGTQX3FYYL2J4P</b> <input type=hidden name="tfa_secret" value="A6TGTQX3FYYL2J4P"><br>
    <img
        src="https://chart.googleapis.com/chart?chs=200x200&amp;chld=M|0&amp;cht=qr&amp;chl=otpauth%3A%2F%2Ftotp%2FLegatordigitalpro.com%3Fsecret%3DA6TGTQX3FYYL2J4P"><br>
    3. Please enter two factor token from Google Authenticator to verify correct
    setup:<br>
    <input type=text name="code" class=inpts> <input type=submit value="Enable" class=sbmt>
</form>



<script language=javascript>
    document.mainform.time.value = (new Date()).getTime();

    function checkform() {
        if (!document.mainform.code.value.match(/^[0-9]{6}$/)) {
            alert("Please type code!");
            document.mainform.code.focus();
            return false;
        }
        return true;
    }
</script>