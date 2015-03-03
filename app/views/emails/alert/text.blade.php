Dear <% $username; %>,

We would like to inform you that the following episodes have been broadcasted yesterday and can be found on different locations for download. Don't forget to mark your episodes as seen after watching!

@foreach ($episodelist as $episode)
<% $episode['series'] %> : S<% $episode['season'] %>E<% $episode['number'] %> <% $episode['name'] %>
@endforeach

Regards,

Team Episode-Alert