# Node.js Telegram Bot - Setup Guide

## 🚀 Quick Start

### Installation

1. **Install Node.js** (v18 or higher):
   - Download from: https://nodejs.org/

2. **Install Dependencies**:
   ```bash
   npm install
   ```

3. **Set Environment Variables**:
   - Copy `.env.nodejs` to `.env`
   - Edit `.env` and add your bot token

4. **Run the Bot**:
   ```bash
   npm start
   ```

## 📝 Environment Variables

Create a `.env` file or set these in your deployment platform:

```bash
BOT_TOKEN=your_bot_token_from_botfather
FORWARDERSD_TOKEN=optional_forwarder_token
PROXY_HOST=optional_proxy_host:port
PROXY_AUTH=optional_proxy_username:password
PORT=8080
```

## 🔧 Development

Run with auto-reload:
```bash
npm run dev
```

## 🐳 Docker Deployment

### Build Docker Image:
```bash
docker build -f Dockerfile.nodejs -t telegram-bot-nodejs .
```

### Run Docker Container:
```bash
docker run -p 8080:8080 \
  -e BOT_TOKEN=your_token \
  telegram-bot-nodejs
```

## 🌐 Railway Deployment

### Option 1: Using Railway Dashboard

1. Go to https://railway.app/
2. Click "New Project" → "Deploy from GitHub repo"
3. Select your repository
4. Railway will detect `package.json` and deploy automatically
5. Set environment variables:
   - `BOT_TOKEN` = Your bot token
   - `FORWARDERSD_TOKEN` = (Optional) Forwarder token
   - `PROXY_HOST` = (Optional) Proxy host
   - `PROXY_AUTH` = (Optional) Proxy auth

### Option 2: Using Railway CLI

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
railway variables set BOT_TOKEN=your_token

# Get deployment URL
railway domain
```

## 🔗 Set Webhook

After deployment, set the webhook (replace YOUR_BOT_TOKEN and YOUR_APP_URL):

```
https://api.telegram.org/botYOUR_BOT_TOKEN/setWebhook?url=https://YOUR_APP_URL/
```

Verify webhook:
```
https://api.telegram.org/botYOUR_BOT_TOKEN/getWebhookInfo
```

## 🧪 Testing Locally

### Using ngrok:

1. **Start the bot**:
   ```bash
   npm start
   ```

2. **In another terminal, start ngrok**:
   ```bash
   ngrok http 8080
   ```

3. **Copy the ngrok URL** (e.g., `https://abc123.ngrok.io`)

4. **Set webhook**:
   ```
   https://api.telegram.org/botYOUR_BOT_TOKEN/setWebhook?url=https://abc123.ngrok.io/
   ```

## 📋 Available Endpoints

- `GET /` - Health check (returns "Telegram Bot is running!")
- `GET /health` - Detailed health status (JSON)
- `POST /` - Webhook endpoint for Telegram updates

## 🔄 Bot Commands

- `/start` - Show welcome message and commands
- `/help` - Show help information
- Send card: `CCNUMBER|MM|YYYY|CVV` - Check a card

Example: `4350940005555920|07|2025|123`

## 📦 Dependencies

- **express** - Web framework for webhook
- **axios** - HTTP client for API requests
- **uuid** - Generate unique IDs
- **https-proxy-agent** - Proxy support

## 🆚 PHP vs Node.js

### Advantages of Node.js version:

✅ **Better Performance**: Async/await for non-blocking operations
✅ **Modern Syntax**: Clean, readable code
✅ **Better Error Handling**: Try-catch with proper error messages
✅ **NPM Ecosystem**: Vast library of packages
✅ **Built-in JSON**: Native JSON parsing
✅ **Active Development**: Modern runtime with regular updates
✅ **Memory Efficient**: Better memory management
✅ **Easier Debugging**: Better debugging tools and logging

### Migration Notes:

- Session storage is in-memory (use Redis for production)
- Cookie handling uses file system (same as PHP)
- All core functionality is preserved
- Same API endpoints and responses
- Better retry logic with async/await

## 🔒 Security

- ✅ No hardcoded credentials
- ✅ Environment variables for secrets
- ✅ Proper error handling
- ✅ Request timeout protection
- ✅ Secure cookie storage

## 🐛 Troubleshooting

### Bot not responding:
1. Check if server is running: `curl http://localhost:8080/health`
2. Check webhook status: Use getWebhookInfo API
3. Check logs for errors
4. Verify BOT_TOKEN is set correctly

### Connection errors:
1. Check proxy settings if using proxy
2. Verify network connectivity
3. Check firewall settings

### Deployment issues:
1. Ensure `package.json` is in root directory
2. Check Node.js version (should be 18+)
3. Verify environment variables are set
4. Check deployment logs

## 📚 Additional Resources

- Node.js Docs: https://nodejs.org/docs
- Telegram Bot API: https://core.telegram.org/bots/api
- Express.js: https://expressjs.com/
- Axios: https://axios-http.com/

## 🔄 Updating the Bot

```bash
# Pull latest changes
git pull

# Install any new dependencies
npm install

# Restart the bot
npm start
```

On Railway, just push to GitHub and it will auto-deploy.
