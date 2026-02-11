# 🔗 Telegram Bot Webhook Setup Guide

## 📋 Prerequisites

Before setting up the webhook, you need:

1. ✅ **Bot Token** - Get from @BotFather on Telegram
2. ✅ **Deployed Bot** - Your bot must be running on a server
3. ✅ **HTTPS URL** - Railway/Heroku provides this automatically

---

## 🚀 Quick Setup (3 Methods)

### Method 1: Using the Setup Script (Easiest) ⭐

1. **Double-click** `setup-webhook.bat`
2. **Enter your Bot Token** when prompted
3. **Enter your App URL** (from Railway/Heroku)
4. Done! ✅

---

### Method 2: Using Your Browser

1. **Get your deployment URL** from Railway:
   - Go to https://railway.app/
   - Open your project
   - Click on your service
   - Copy the domain (e.g., `https://your-app.railway.app`)

2. **Open this URL in your browser** (replace the values):
   ```
   https://api.telegram.org/bot<YOUR_BOT_TOKEN>/setWebhook?url=<YOUR_APP_URL>/
   ```

3. **Example**:
   ```
   https://api.telegram.org/bot1234567890:ABCdefGHIjklMNOpqrsTUVwxyz/setWebhook?url=https://mybot.railway.app/
   ```

4. **You should see**:
   ```json
   {
     "ok": true,
     "result": true,
     "description": "Webhook was set"
   }
   ```

---

### Method 3: Using cURL (Command Line)

```bash
# Set webhook
curl "https://api.telegram.org/bot<YOUR_BOT_TOKEN>/setWebhook?url=<YOUR_APP_URL>/"

# Check webhook status
curl "https://api.telegram.org/bot<YOUR_BOT_TOKEN>/getWebhookInfo"
```

---

## 📝 Step-by-Step Example

Let's say:
- Your bot token: `1234567890:ABCdefGHIjklMNOpqrsTUVwxyz`
- Your Railway URL: `https://telegrambot-production.up.railway.app`

### Step 1: Set Webhook
Open in browser:
```
https://api.telegram.org/bot1234567890:ABCdefGHIjklMNOpqrsTUVwxyz/setWebhook?url=https://telegrambot-production.up.railway.app/
```

### Step 2: Verify
Open in browser:
```
https://api.telegram.org/bot1234567890:ABCdefGHIjklMNOpqrsTUVwxyz/getWebhookInfo
```

You should see:
```json
{
  "ok": true,
  "result": {
    "url": "https://telegrambot-production.up.railway.app/",
    "has_custom_certificate": false,
    "pending_update_count": 0,
    "max_connections": 40
  }
}
```

---

## 🔍 How to Get Your Railway URL

### Option 1: Railway Dashboard
1. Go to https://railway.app/
2. Click on your project
3. Click on your service
4. Look for **"Domains"** section
5. Copy the URL (looks like `https://your-app-production.up.railway.app`)

### Option 2: Generate Domain
If you don't see a domain:
1. In Railway, go to your service
2. Click **"Settings"** tab
3. Scroll to **"Domains"**
4. Click **"Generate Domain"**
5. Copy the generated URL

---

## ✅ Test Your Bot

After setting the webhook:

1. **Open Telegram** and find your bot
2. **Send**: `/start`
3. **Bot should respond** with:
   ```
   🤖 Card Checker Bot
   
   Commands:
   /check - Check a card
   /help - Show help
   
   Format:
   Send card as: 4350940005555920|07|2025
   or 4350940005555920|07|2025|123
   ```

4. **Test card checking**:
   ```
   4350940005555920|07|2025|123
   ```

---

## 🔧 Troubleshooting

### Bot not responding?

1. **Check if bot is running**:
   ```
   https://your-app-url/health
   ```
   Should return: `{"status":"ok","timestamp":"..."}`

2. **Check webhook status**:
   ```
   https://api.telegram.org/bot<YOUR_TOKEN>/getWebhookInfo
   ```
   - Look at `pending_update_count` (should be 0)
   - Check `last_error_message` if present

3. **Check Railway logs**:
   - Go to Railway dashboard
   - Click your service
   - Click **"Deployments"** tab
   - Click **"View Logs"**
   - Look for errors

### Common Issues:

#### ❌ "Webhook not set" or "url" is empty
- **Solution**: Run setWebhook again
- Make sure URL ends with `/`

#### ❌ "Invalid token"
- **Solution**: Double-check your bot token from @BotFather
- No spaces before/after the token

#### ❌ "Can't parse URL"
- **Solution**: Make sure URL starts with `https://`
- URL must be publicly accessible

#### ❌ SSL/Certificate errors
- **Solution**: Railway/Heroku provide valid SSL automatically
- If using custom domain, ensure it has valid SSL certificate

#### ❌ Bot responds slowly
- **Solution**: Check Railway logs for errors
- Might be cold start (first request after idle)

---

## 🔄 Update Webhook (When You Redeploy)

If you redeploy or change domains, you need to update the webhook:

```
https://api.telegram.org/bot<YOUR_TOKEN>/setWebhook?url=<NEW_URL>/
```

---

## 🗑️ Remove Webhook (For Local Testing)

If you want to test locally with long polling:

```
https://api.telegram.org/bot<YOUR_TOKEN>/deleteWebhook
```

---

## 📱 Telegram Bot API Commands

### Set Webhook:
```
/setWebhook?url=https://your-app.com/
```

### Get Webhook Info:
```
/getWebhookInfo
```

### Delete Webhook:
```
/deleteWebhook
```

### Get Bot Info:
```
/getMe
```

### Get Updates (for testing):
```
/getUpdates
```

---

## 🎯 Quick Reference

| Action | URL Pattern |
|--------|-------------|
| Set Webhook | `https://api.telegram.org/bot<TOKEN>/setWebhook?url=<URL>/` |
| Check Status | `https://api.telegram.org/bot<TOKEN>/getWebhookInfo` |
| Delete Webhook | `https://api.telegram.org/bot<TOKEN>/deleteWebhook` |
| Test Bot | `https://api.telegram.org/bot<TOKEN>/getMe` |

---

## 🆘 Still Having Issues?

1. **Check Railway Environment Variables**:
   - `BOT_TOKEN` must be set
   - No other required variables

2. **Check Bot Code**:
   - Read the logs: Railway → Your Service → View Logs
   - Look for: `✅ Bot server running on port 8080`

3. **Test Health Endpoint**:
   ```
   https://your-app-url/health
   ```

4. **Send Test Message**:
   - The bot logs every incoming message
   - Check Railway logs after sending a message

---

## ✨ Success Indicators

Your webhook is working correctly if:

✅ `getWebhookInfo` shows your URL
✅ `pending_update_count` is 0
✅ Bot responds to `/start` command
✅ Bot processes card checks
✅ Railway logs show incoming requests

---

## 📞 Support

If you still have issues:
1. Check Railway logs for detailed errors
2. Verify bot token is correct
3. Ensure app is deployed and running
4. Make sure domain is accessible via HTTPS

**Your bot should be working now! Test it on Telegram!** 🎉
