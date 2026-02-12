# 🔧 Bot Not Responding - Troubleshooting Guide

## 🎯 Quick Diagnosis

Run `diagnose-bot.bat` to check your bot status automatically!

---

## ✅ Checklist (Follow in Order)

### Step 1: Is Your Bot Deployed?

**Check Railway Dashboard:**
1. Go to https://railway.app/
2. Open your project
3. Check deployment status - should say **"Active"** or **"Running"**
4. If it says "Failed" or "Building" - wait or check build logs

**Test if app is running:**
- Open: `https://your-railway-url/health`
- Should return: `{"status":"ok","timestamp":"..."}`
- If it fails, your app isn't running!

---

### Step 2: Is BOT_TOKEN Set in Railway?

**CRITICAL: Check Environment Variables**

1. Railway Dashboard → Your Project
2. Click your service
3. Click **"Variables"** tab
4. Look for `BOT_TOKEN`

**If missing:**
1. Click **"New Variable"**
2. Key: `BOT_TOKEN`
3. Value: Your bot token from @BotFather
4. Save

**After adding, Railway will auto-redeploy (wait 2-3 minutes)**

---

### Step 3: Is Webhook Set Correctly?

**Check webhook status:**

Open in browser:
```
https://api.telegram.org/botYOUR_BOT_TOKEN/getWebhookInfo
```

**What to look for:**

✅ **Good Response:**
```json
{
  "ok": true,
  "result": {
    "url": "https://your-app.railway.app/",
    "pending_update_count": 0
  }
}
```

❌ **Bad Response:**
```json
{
  "ok": true,
  "result": {
    "url": "",  // Empty = webhook not set!
  }
}
```

**Fix:** Run `setup-webhook.bat` or set manually:
```
https://api.telegram.org/botYOUR_BOT_TOKEN/setWebhook?url=https://your-railway-url/
```

---

### Step 4: Check Railway Logs

**View Logs:**
1. Railway → Your Service
2. Click **"Deployments"** tab
3. Click latest deployment
4. Click **"View Logs"**

**What to look for:**

✅ **Good Logs:**
```
✅ Bot server running on port 8080
Webhook: https://your-domain.com/
Health: https://your-domain.com/health
```

❌ **Bad Logs:**
```
ERROR: BOT_TOKEN environment variable is required.
```
**Fix:** Add BOT_TOKEN in Railway Variables (see Step 2)

❌ **Bad Logs:**
```
npm ERR! ...
```
**Fix:** Check build logs, might need to redeploy

---

### Step 5: Test Bot Token

**Verify token is valid:**

Open in browser:
```
https://api.telegram.org/botYOUR_BOT_TOKEN/getMe
```

**Should return:**
```json
{
  "ok": true,
  "result": {
    "id": 1234567890,
    "is_bot": true,
    "first_name": "YourBotName",
    "username": "yourbotname_bot"
  }
}
```

**If "ok": false** - Your token is invalid!
- Get new token from @BotFather on Telegram

---

## 🔍 Common Issues & Solutions

### Issue 1: "Webhook is not set" or URL is empty

**Symptoms:**
- `getWebhookInfo` shows empty URL
- Bot doesn't respond to messages

**Solution:**
```bash
# Set webhook
https://api.telegram.org/botYOUR_TOKEN/setWebhook?url=https://your-railway-url/

# Or run setup-webhook.bat
```

---

### Issue 2: "BOT_TOKEN environment variable is required"

**Symptoms:**
- Railway logs show this error
- App crashes immediately

**Solution:**
1. Railway → Your Service → Variables
2. Add: `BOT_TOKEN` = your token
3. Wait for auto-redeploy (2-3 min)

---

### Issue 3: Railway shows "Failed" or "Crashed"

**Symptoms:**
- Deployment status is red
- App not accessible

**Solution:**
1. Check Railway logs for error messages
2. Common causes:
   - Missing BOT_TOKEN
   - Build errors (check package.json)
   - Port issues (should be 8080)

**Quick fix:**
```bash
# Trigger redeploy
git commit --allow-empty -m "Trigger redeploy"
git push
```

---

### Issue 4: Webhook set but bot still not responding

**Symptoms:**
- Webhook is set correctly
- App is running
- Bot still doesn't respond

**Solution A: Check pending updates**
```
https://api.telegram.org/botYOUR_TOKEN/getWebhookInfo
```
Look at `pending_update_count`:
- If > 0: Bot received messages but couldn't process them
- Check Railway logs for errors

**Solution B: Reset webhook**
```bash
# Delete webhook
https://api.telegram.org/botYOUR_TOKEN/deleteWebhook

# Set it again
https://api.telegram.org/botYOUR_TOKEN/setWebhook?url=https://your-railway-url/
```

**Solution C: Check URL format**
- URL must end with `/`
- Must be HTTPS (Railway provides this)
- Must be publicly accessible

---

### Issue 5: "SSL/Certificate" errors in logs

**Symptoms:**
- Logs show SSL errors
- Webhook shows certificate errors

**Solution:**
- Railway provides valid SSL automatically
- Make sure you're using the Railway domain
- If using custom domain, ensure SSL is configured

---

### Issue 6: Bot responds but very slowly

**Symptoms:**
- First message takes long time
- Subsequent messages are fast

**Cause:** Railway "cold start" (app was sleeping)

**Solution:**
- This is normal for free tier
- Keep app active with monitoring service
- Or upgrade Railway plan

---

## 🚀 Step-by-Step Fix Guide

### If bot is completely not responding:

**1. Check Deployment (30 seconds)**
- Railway dashboard → Is it "Active"?
- Visit: `https://your-url/health`

**2. Add BOT_TOKEN (2 minutes)**
- Railway → Variables → Add BOT_TOKEN
- Wait for redeploy

**3. Set Webhook (30 seconds)**
- Run `setup-webhook.bat`
- OR open browser: `https://api.telegram.org/botTOKEN/setWebhook?url=RAILWAY_URL/`

**4. Test Bot (10 seconds)**
- Open Telegram
- Send `/start` to your bot
- Should respond immediately!

---

## 🧪 Manual Test Commands

### Test 1: Check Bot Info
```
https://api.telegram.org/botYOUR_TOKEN/getMe
```

### Test 2: Check Webhook
```
https://api.telegram.org/botYOUR_TOKEN/getWebhookInfo
```

### Test 3: Get Updates (shows received messages)
```
https://api.telegram.org/botYOUR_TOKEN/getUpdates
```

### Test 4: Set Webhook
```
https://api.telegram.org/botYOUR_TOKEN/setWebhook?url=https://your-railway-url/
```

### Test 5: Delete Webhook (for testing)
```
https://api.telegram.org/botYOUR_TOKEN/deleteWebhook
```

### Test 6: Check App Health
```
https://your-railway-url/health
```

---

## 📋 Pre-Flight Checklist

Before asking for help, verify:

- [ ] Bot token is valid (test with `/getMe`)
- [ ] Bot is deployed on Railway (status = Active)
- [ ] BOT_TOKEN is set in Railway Variables
- [ ] Railway app is accessible (`/health` endpoint works)
- [ ] Webhook is set (check with `/getWebhookInfo`)
- [ ] Webhook URL matches Railway domain
- [ ] Railway logs show no errors
- [ ] You're messaging the correct bot on Telegram

---

## 🆘 Still Not Working?

### Get Detailed Information:

1. **Run diagnostics:**
   ```
   Double-click: diagnose-bot.bat
   ```

2. **Check Railway logs:**
   - Railway → Deployments → View Logs
   - Copy any error messages

3. **Verify all settings:**
   - Bot Token from @BotFather
   - Railway URL from Railway dashboard
   - Webhook URL matches Railway URL
   - BOT_TOKEN variable is set

4. **Common last resort fixes:**
   ```bash
   # Force redeploy
   git commit --allow-empty -m "Restart"
   git push
   
   # Reset webhook
   # Delete: https://api.telegram.org/botTOKEN/deleteWebhook
   # Set: https://api.telegram.org/botTOKEN/setWebhook?url=URL/
   ```

---

## ✨ Success Indicators

Your bot is working correctly when:

✅ Railway shows "Active" status
✅ `/health` endpoint returns `{"status":"ok"}`
✅ Webhook is set (check `/getWebhookInfo`)
✅ `pending_update_count` is 0
✅ Bot responds to `/start` command
✅ Railway logs show incoming requests

---

## 💡 Pro Tips

1. **Always check Railway logs first** - they tell you exactly what's wrong
2. **Set webhook AFTER deployment** - not before
3. **Use the generated Railway domain** - don't use custom domains initially
4. **Test with `/start` command first** - simplest test
5. **Check environment variables** - most common issue

---

**Run `diagnose-bot.bat` now to find the exact issue!** 🔍
