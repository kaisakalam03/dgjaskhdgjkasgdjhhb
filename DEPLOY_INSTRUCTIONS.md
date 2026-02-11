# Quick Deploy Instructions

## Method 1: Railway (Recommended - Easiest)

### Option A: Using Railway Web UI
1. Go to https://railway.app/
2. Click "Start a New Project"
3. Choose "Deploy from GitHub repo"
4. Connect your GitHub account and select this repository
5. Railway will auto-detect the Dockerfile and deploy
6. After deployment, go to Settings → Variables and add:
   - `BOT_TOKEN` = `8269957175:AAEA2PiWIt5s3KWsvRJRLRKXnY-tdko9z-4`
   - `PROXY_HOST` = `proxy.okeyproxy.com:31212` (optional)
   - `PROXY_AUTH` = `customer-4nao708160-continent-AS-country-SG:7tzdwvba` (optional)
7. Copy your deployment URL (e.g., `https://your-app.railway.app`)
8. Set webhook: Open this URL in browser:
   ```
   https://api.telegram.org/bot8269957175:AAEA2PiWIt5s3KWsvRJRLRKXnY-tdko9z-4/setWebhook?url=https://your-app.railway.app/telegram_bot.php
   ```

### Option B: Using Railway CLI
```bash
# Install Railway CLI
npm i -g @railway/cli

# Login
railway login

# Initialize project
railway init

# Deploy
railway up

# Set environment variables
railway variables set BOT_TOKEN=8269957175:AAEA2PiWIt5s3KWsvRJRLRKXnY-tdko9z-4

# Get deployment URL
railway domain
```

## Method 2: Heroku

1. Install Heroku CLI: https://devcenter.heroku.com/articles/heroku-cli
2. Login: `heroku login`
3. Create app: `heroku create your-bot-name`
4. Set stack: `heroku stack:set container`
5. Set config: `heroku config:set BOT_TOKEN=8269957175:AAEA2PiWIt5s3KWsvRJRLRKXnY-tdko9z-4`
6. Deploy: `git push heroku main`
7. Get URL: `heroku apps:info`
8. Set webhook (replace <app-name>):
   ```
   https://api.telegram.org/bot8269957175:AAEA2PiWIt5s3KWsvRJRLRKXnY-tdko9z-4/setWebhook?url=https://<app-name>.herokuapp.com/telegram_bot.php
   ```

## Method 3: Render

1. Go to https://render.com/
2. Click "New +" → "Web Service"
3. Connect your GitHub repository
4. Render will detect Dockerfile automatically
5. Set environment variables:
   - `BOT_TOKEN` = `8269957175:AAEA2PiWIt5s3KWsvRJRLRKXnY-tdko9z-4`
6. Click "Create Web Service"
7. Copy your service URL
8. Set webhook with your URL

## Method 4: Local Testing with ngrok

If you want to test locally first:

```bash
# Start the bot locally
php -S localhost:8080 -t .

# In another terminal, expose it with ngrok
ngrok http 8080

# Copy the ngrok URL (e.g., https://abc123.ngrok.io)
# Set webhook:
https://api.telegram.org/bot8269957175:AAEA2PiWIt5s3KWsvRJRLRKXnY-tdko9z-4/setWebhook?url=https://abc123.ngrok.io/telegram_bot.php
```

## Verify Webhook is Set

Check webhook status:
```
https://api.telegram.org/bot8269957175:AAEA2PiWIt5s3KWsvRJRLRKXnY-tdko9z-4/getWebhookInfo
```

## Files to Commit (if using Git)

All necessary files are ready:
- ✅ Dockerfile
- ✅ .dockerignore
- ✅ railway.toml
- ✅ nixpacks.toml
- ✅ Procfile
- ✅ start.sh
- ✅ composer.json
- ✅ telegram_bot.php (updated with security fixes)
- ✅ userAgent.php
- ✅ vendor/autoload.php
- ✅ .env.example
- ✅ .gitignore

## Next Steps After Deployment

1. Test the bot by sending `/start` to your bot on Telegram
2. Try checking a card: `4350940005555920|07|2025|123`
3. Monitor logs on your deployment platform

## Troubleshooting

If the bot doesn't respond:
1. Check webhook status (URL above)
2. Check deployment logs on your platform
3. Ensure environment variables are set correctly
4. Make sure the deployment is running (not sleeping)
