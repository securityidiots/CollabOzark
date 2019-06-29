# CollabOzark
CollabOzark is a simple tool which helps the researchers track SSRF, Blind XSS, XXE, SQLi, External Resource Access payloads triggers.

I wanted a basic solution easy to implement and hence this tool do not use SQL database. It keeps the data saved under JSON files.

This single file can be used with your BURP collaborator polling URL to keep a track of all the hits you got from your payloads, be it SSRF, XXE, RCE, XSS, SQL etc.

As we have noticed previously a lot of researchers implement thier own VPS just to keep a track of hits they get from thier payloads. Many times it take a long time to get response from the payloads we inserted and hence a better and a more cost effective solution was required to keep a track of all the hits we get from the payloads we throw around the applications.

This tool can be easily implemented on a subdomain or a subdirectory of your hosting. We do not require a complete VPS with root access to implement such logs tracking system anymore. 

Here are the steps you need to follow to implement this tool on your shared hosting.
1. Launch your BURP Suite.
2. Visit Project options -> Misc -> Burp Collaborator Server, tick the "Poll over unencrypted HTTP" option.
3. Launch your Wireshark and now click on "Run Health Check" button in your Burp.
4. In the wireshark choose HTTP traffic and you will find your current BURP Project collaborator subdomain XxXxXx.burpcollaborator.net
5. Also copy the Biid token value from the next URL http://polling.burpcollaborator.net/burpresults?biid=YOUR_TOKEN

Now replace just replace the [YOUR TOKEN] value with YOUR_TOKEN_HERE in 89th line of the PHP code.

Host the PHP file on your shared hosting and make sure to secure it using HTACCESS. Now trigger some logs by visiting the URL in 4th step and refresh your hosted php file, you will notice all the Logs visible in your dashboard. It will show you HTTP, HTTPS, DNS, SMTP logs on your dashboard.

The dashboard will not only show you all the details grabbed from BURP polling but also fetch other additional information using IP tools about the IP address which triggered the log.

TODO
1. Add other logs which I might have missed.
2. Add notification and auto update of new payload triggers.
3. Result Filtering.
4. Filtered removal of logs.

Suggestions are welcome. Feel free to reach me out if you would like to collaborate in this project. 
