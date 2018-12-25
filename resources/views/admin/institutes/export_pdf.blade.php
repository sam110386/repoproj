
<html>
<body style="text-align: center;">
    <table width="400" cellpadding="0" cellspacing="0" border="0" bgcolor="#fff">
        <tr>
                <td ><center><strong><font size="11">{{$institute->name}}</font></strong></center></td>
            </tr>
            @if(!empty($logo))
            <tr>
                <td ><center> <img height="120" width="120" src="{{$logo}}" /></center></td>
            </tr>
            @endif
        <tr><td>
           <table width="100%" cellpadding="2" cellspacing="2" border="0" bgcolor="#fff">
              
            <tr>
                <td align="center">
                    <font size="8">Usename :</font>
                </td>
                <td align="center">
                    <font size="8"><strong>{{$institute->username}}</strong></font>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <font size="8">Email :</font>
                </td>
                <td align="center">
                    <font size="8"><strong>{{$institute->email}}</strong></font>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <font size="8">Phone # :</font>
                </td>
                <td align="center">
                    <font size="8"><strong>{{$institute->phone}}</strong></font>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <font size="8">Street Address :</font>
                </td>
                <td align="center">
                    <font size="8"><strong>{{$institute->address}}</strong></font>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <font size="8">Region :</font>
                </td>
                <td align="center">
                    <font size="8"><strong>{{$institute->region}}</strong></font>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <font size="8">District :</font>
                </td>
                <td align="center">
                    <font size="8"><strong>{{$institute->district}}</strong></font>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <font size="8">Ward :</font>
                </td>
                <td align="center">
                    <font size="8"><strong>{{$institute->ward}}</strong></font>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <font size="8">Zip Code :</font>
                </td>
                <td align="center">
                    <font size="8"><strong>{{$institute->zipcode}}</strong></font>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <font size="8">Client :</font>
                </td>
                <td align="center">
                    <font size="8"><strong>{{$institute->client_male}} (M) {{$institute->client_female}} (F)</strong></font>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <font size="8">Staff :</font>
                </td>
                <td align="center">
                    <font size="8"><strong>{{$institute->staff_male}} (M) {{$institute->staff_female}} (F)</strong></font>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <font size="8">Board Memeber :</font>
                </td>
                <td align="center">
                    <font size="8"><strong>{{$institute->boardmember_male}} (M) {{$institute->boardmember_female}} (F)</strong></font>
                </td>
            </tr>
        </table>
    </td></tr>

    <tr><td></td></tr>
</table>
</body>
</html>