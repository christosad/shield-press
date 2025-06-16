# 🔐 shield-press
ShieldPress is a lightweight WordPress plugin that adds a secure, password-protected landing gate to your entire site — without using JavaScript. Designed for simplicity, privacy, and admin control, it allows site owners to restrict public access with a single password and configure it easily from the WordPress dashboard.

## 🚀 How to Use

### 🔧 Install the Plugin

Download or clone the repository into your WordPress `/wp-content/plugins/` directory:

git clone https://github.com/yourusername/shield-press.git wp-content/plugins/shieldpress
Or upload the ZIP via WordPress admin:

Go to Plugins → Add New → Upload Plugin

Upload the ShieldPress ZIP and click Install Now

### ✅ Activate ShieldPress
Go to Plugins → Installed Plugins

Click Activate on ShieldPress

### 🔐 Set Your Access Password
Go to Tools → ShieldPress

Enter your desired password and click Save

An eye icon toggle allows you to view/hide the password

Password is securely stored using PHP hashing

### 🧱 Create the Access Page
In WordPress, go to Pages → Add New

Title it something like "Enter" or "Gate"

⚠️ Set the permalink slug to **/enter**

On the right side, under Page Attributes → Template, select:

Enter Page (Shield Press)
Publish the page

### 📝 The page uses a special custom template included with the plugin to render the secure password form. (see the enter-page.php file inside login page template)

### 🔎 Test the Gate
Open your site in an incognito/private window

You should be redirected to /enter until the correct password is entered

### 👤 Admin Bypass
If you're logged in as an admin, you’ll bypass the password screen automatically

