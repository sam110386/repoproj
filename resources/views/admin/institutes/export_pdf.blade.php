
<html>
<body style="text-align: center;">
    <table width="400" cellpadding="0" cellspacing="0" border="0" bgcolor="#fff">
        <tr>
            <td align="center"><strong><font size="11">{{$institute->name}}</font></strong></td>
        </tr>
        @if(!empty($logo))
        <tr>
            <td> <img height="120" width="120" src="{{$logo}}" /></td>
        </tr>
        @endif
        <tr>
            <td align="center">
           <table width="100%" cellpadding="2" cellspacing="2" border="0" bgcolor="#fff">
            <tr>
                <td align="center">
                    <font size="8">Client Male:</font>
                </td>
                <td align="center">
                    <font size="8"><strong>{{$institute->client_male}} </strong></font>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <font size="8">Client Female:</font>
                </td>
                <td align="center">
                    <font size="8"><strong>{{$institute->client_female}}</strong></font>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <font size="8">Staff Male:</font>
                </td>
                <td align="center">
                    <font size="8"><strong>{{$institute->staff_male}}</strong></font>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <font size="8">Staff Female:</font>
                </td>
                <td align="center">
                    <font size="8"><strong>{{$institute->staff_female}}</strong></font>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <font size="8">Board Memeber Male:</font>
                </td>
                <td align="center">
                    <font size="8"><strong>{{$institute->boardmember_male}}</strong></font>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <font size="8">Board Memeber Female:</font>
                </td>
                <td align="center">
                    <font size="8"><strong>{{$institute->boardmember_female}}</strong></font>
                </td>
            </tr>
        </table>
    </td></tr>

    <tr><td></td></tr>
</table>
</body>
</html>