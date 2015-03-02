<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
        <img src="http://www.episode-alert.com/images/hd-logo.png" />
		<p>Dear <% $username; %>,</p>
            
        <p>We would like to inform you that the following episodes have been broadcasted yesterday and can be found on different locations for download. Don't forget to mark your episodes as seen after watching!</p>
   
        @foreach ($episodelist as $episode)
            <p><% $episode %></p>
        @endforeach        
		
        <p>Regards,</p>

        <p>Team Episode-Alert</p>

	</body>
</html>
