Setup Guide for SiteCountry (DirectAdmin/cPanel)

This guide will help you install the RSA Admin Dashboard on your SiteCountry hosting.

1. Prepare Your Files

You should have the following files downloaded from the generator:

data.json

api.php

config.php

admin/index.php

admin/dashboard.php

uploads/ (Create this empty folder)

2. Upload to SiteCountry

Log in to your SiteCountry Control Panel (usually DirectAdmin).

Open the File Manager.

Navigate to the public_html directory.

Upload the following files directly to public_html:

api.php

data.json

config.php

(Your main website file, rename index.html to index.php if you are connecting them)

Create a New Folder named admin inside public_html.

Open the admin folder and upload:

admin/index.php

admin/dashboard.php

Go back to public_html, create a folder named uploads.

3. Set Permissions (CRITICAL)

For the dashboard to save data and upload images, you must set specific permissions.

In File Manager, find data.json.

Right-click it and select Set Permissions (or "Change Mode").

Set it to 644 (User: Read/Write, Group: Read, World: Read).

Note: If saving fails later, try 666.

Find the uploads folder.

Right-click and set Permissions to 755.

4. Default Credentials

Login URL: your-site.com/admin/

Default Password: admin123

5. Security (Important)

Once you have logged in successfully:

Open api.php in the File Manager's Edit mode.

Find $adminHash near the top.

Change the password logic to use your own secure password hash (instructions in config.php).

6. Connecting Your Frontend

To make your main website display the data from the admin panel:

Rename your index.html to index.php.

At the very top of index.php, add:

<?php
$data = json_decode(file_get_contents('data.json'), true);
?>


Replace static text with PHP variables. Example:
Replace: <h1>Precision</h1>
With: <h1><?php echo $data['hero']['title_line_1']; ?></h1>