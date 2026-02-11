FROM node:18-alpine

# Set working directory
WORKDIR /app

# Copy package files
COPY package*.json ./

# Install dependencies (npm install works without package-lock.json)
RUN npm install --omit=dev

# Copy application files
COPY bot.js ./

# Create temp directory for cookies
RUN mkdir -p /tmp/bot_cookies && chmod 777 /tmp/bot_cookies

# Expose port
EXPOSE 8080

# Start the application
CMD ["node", "bot.js"]
