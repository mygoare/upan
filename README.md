upan
====

upan in the cloud

###How to deploy

0.  clone this repo to `/var/www/ folder`

1.  **Database:** `cd application/config` folder, `cp database.php.sample database.php`, fill with your own database name & password

2.  **SMS:** `vim application/config/constants.php`, change `TUI3_API_KEY` value & fill the vps server ip address at tui3 website

3.  **Mail:** ssh to vps server, `sudo tasksel` install the `mail server`. Make a virtual machine to `/var/www/upanMail/` folder with `mail.upan.us` domain

4.  `sudo chmod -r o+w assets/upload_files`. Let users can upload files
