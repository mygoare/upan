upan
====

upan in the cloud

###How to deploy

0.  clone this repo to `/var/www/ folder`

1.  **Database:** `cd application/config` folder, `cp database.php.sample database.php`, fill with your own database name & password

2.  **SMS:** `vim application/config/constants.php`, change `$tui3_api_key` value & fill the vps server ip address at tui3 website

3.  **Mail:** ssh to vps server, `sudo tasksel` install the `mail server`. Make a virtual machine to `/var/www/mail/` folder with `mail.upan.us` domain
