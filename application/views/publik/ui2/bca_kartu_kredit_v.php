<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>BCA CREDIT CARD PAGE REDIRECT</title>
    </head>
    <body style="font: 10pt Verdana">
        <FORM ACTION="<?= $urlPost; ?>" METHOD="post" name="sinsertForm" style="background-color: #FFFFFF">
            <table width="725" class="tablePayment" align="center" bordercolor="##FF0000" border="0">
                <tr>
                    <td align="center">
                        <table border="0" width="725">
                            <tr>
                                <td colspan="4">
                                    <p align="center" class="style4"><u><b><font face="Verdana">TRANSACTION INFORMATION </font></b></u></p>	  </td>
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                            <tr align="left">
                                <td><font color="#000000">Merchant Site ID:</font></td>
                                <td class="cellContent"><input type="text" name="siteID" value="<?= htmlentities($siteId); ?>" readonly="readonly"></td>
                            </tr>
                            <tr align="left">
                                <td>Merchant Invoice ID:</td>
                                <td class="cellContent"><input type="text" name="merchantTransactionID" value="<?= htmlentities($trans_id); ?>" readonly="readonly"></td></tr>
                            <tr align="left">
                                <td>Service Version:</td>
                                <td class="cellContent"><input type="text" name="serviceVersion" value="<?= htmlentities($versionPayment); ?>" readonly="readonly"></td>
                            </tr>  
                            <tr align="left">
                                <td>Currency:</td>
                                <td class="cellContent"><input type="text" name="currency" value="<?= htmlentities($currency); ?>" readonly="readonly"></td>
                            </tr>
                            <tr align="left">
                                <td>Amount:</td>
                                <td><input type="text" name="amount" value="<?= $amount; ?>" readonly="readonly"></td>
                            </tr>	
                            <tr align="left">
                                <td>Biling Name:</td>
                                <td><input type="text" name="billingName" value="<?= htmlentities($user['nama']); ?>" readonly="readonly"></td>
                            </tr>
                            <tr align="left">
                                <td>Biling Email:</td>
                                <td><input type="text" name="billingEmail" value="<?= htmlentities($email); ?>" readonly="readonly"></td>
                            </tr>	
                            <tr align="left">
                                <td>Biling Address:</td>
                                <td><input type="text" name="billingAddress" value="<?= htmlentities($user['alamat']); ?>" readonly="readonly"></td>
                            </tr>	
                            <tr align="left">
                                <td>Biling City:</td>
                                <td><input type="text" name="billingCity" value="<?= htmlentities($user['nama_kota']); ?>" readonly="readonly"></td>
                            </tr>	
                            <tr align="left">
                                <td>Biling PostCode:</td>
                                <td><input type="text" name="billingPostalCode" value="00000" readonly="readonly"></td>
                            </tr>	
                            <tr align="left">
                                <td>Biling State:</td>
                                <td><input type="text" name="billingState" value="<?= htmlentities(strtoupper($user['nama_provinsi'])); ?>" readonly="readonly"></td>
                            </tr>	
                            <tr align="left">
                                <td>Biling Country:</td>
                                <td><input type="text" name="billingCountry" value="ID" readonly="readonly"></td>
                            </tr>	
                            <tr align="left">
                                <td>Phone:</td>
                                <td><input type="text" name="billingPhone" value="<?= htmlentities($user['hp']); ?>" readonly="readonly"></td>
                            </tr>	
                        </table>
                        <p>&nbsp;</p>  
                        <font face="Verdana">
                            <input type="submit" name="Submit" value="Submit" class="formButton">&nbsp;<input name="" type="reset" value="Reset" class="formButton"></font>&nbsp;</p>
                        </p>
                    </td>
                </tr>
            </table>
        </FORM>
    </body>
    <script>
        window.onload = function() {
            document.forms['sinsertForm'].submit()
        }
    </script>
</html>
