# 🔐 shield-press
ShieldPress is a lightweight WordPress plugin that adds a secure, password-protected landing gate to your entire site — without using JavaScript. Designed for simplicity, privacy, and admin control, it allows site owners to restrict public access with a single password and configure it easily from the WordPress dashboard.

# 🚀 How to Use
1. Install the Plugin

Download or clone the repository into your WordPress /wp-content/plugins/ directory:

git clone https://github.com/yourusername/shieldpress.git wp-content/plugins/shieldpress

Or upload the ZIP file via the WordPress admin:

Plugins → Add New → Upload Plugin

2. Activate ShieldPress

Go to Plugins → Installed Plugins

Click Activate on ShieldPress

3. Set Your Password

Go to Tools → ShieldPress in the WordPress dashboard

Enter your desired access password and save it

You’ll see a toggle (eye icon) to show/hide the saved password

4. Create the Access Page

Add a new page in WordPress (e.g., titled "Enter" or "Gate")

Set the slug to match what’s configured in the plugin (default: /enter)

No shortcode or block needed — ShieldPress handles everything automatically

5. Test the Gate

Open your site in an incognito/private window

You’ll be redirected to the access page until you enter the correct password

6. Admin Bypass

Logged-in admins can always bypass the password gate

7. Log Out / Reset Session

To test the flow again, visit:

arduino
Αντιγραφή
Επεξεργασία
https://yoursite.com/enter/?pwg_logout
