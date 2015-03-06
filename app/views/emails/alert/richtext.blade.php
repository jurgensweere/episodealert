<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
        <table style="border-spacing: 0px; width:580px; font-family: Verdana; font-size:13px">
            <tr>
                <td valign="bottom" style="width:200px; border-bottom: 1px solid #b7b7b7; color:#8ab839; font-size:24px;">EPISODE ALERT</td>
                <td valign="bottom" style="width:380px; border-bottom: 1px solid #b7b7b7; color:#515151; font-size:14px; line-height: 21px;">NEW EPISODES</td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 10px; padding-bottom: 10px;">
                    Dear <% $username; %>,
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 10px; padding-bottom: 10px;">
                   We would like to inform you that the following episodes have been broadcasted yesterday and can be found on different locations for download. Don't forget to mark your episodes as seen after watching!
                </td>
            </tr>  
            <tr>
                <td colspan="2" style="font-size:15px">
                    <ul style="padding-left: 0px">
                        @foreach ($episodelist as $episode)
                        <li style="list-style:none; margin-bottom: 8px; margin-let:0px">                            
                            <strong><% $episode['series'] %></strong>
                            <br/>
                            <a href="<% $base_url; %>/series/<% $unique_name; %>" style="color:#8ab839">S<% $episode['season'] %>E<% $episode['number'] %> <% $episode['name'] %></a>
                        </li>
                        @endforeach                                                       
                    </ul>
                </td>
            </tr>
          
            <tr>
                <td colspan="2" style="padding-top: 10px; padding-bottom: 10px;">Regards,</td>
            </tr>      
            <tr>
                <td colspan="2">Team Episode-Alert</td>
            </tr>                  
        </table>
	</body>
</html>
