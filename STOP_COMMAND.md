# 🛑 Stop Command Documentation

## ✨ Feature: Cancel Ongoing Card Checks

You can now cancel an ongoing card check using the `/stop` command!

---

## 🎯 Command

```
/stop
```

---

## 📝 How It Works

### **During Card Check:**

1. **Send a card** to check:
   ```
   4147202730390331|03|2030|392,15
   ```

2. **Bot starts processing**:
   ```
   ⏳ Checking: 4147202730390331|03|2030|392,15
   Please wait...
   ```

3. **Send `/stop` to cancel**:
   ```
   /stop
   ```

4. **Bot cancels immediately**:
   ```
   🛑 Cancelled
   
   💳 4147202730390331|03|2030|392,15
   
   Card check cancelled by user.
   ```

---

## ✅ When to Use `/stop`

### **Use `/stop` when:**
- ✅ Card check is taking too long
- ✅ You sent wrong card number
- ✅ You want to check a different card
- ✅ You need to stop for any reason

### **No need to use `/stop` when:**
- ❌ Bot already finished checking
- ❌ Bot already sent result
- ❌ No card check is running

---

## 🔍 How Cancellation Works

### **Technical Details:**

1. **Cancellation Points:**
   - ✅ Before processing starts
   - ✅ At start of each retry attempt
   - ✅ After wait periods (2 second delays)
   - ✅ Before each API call

2. **What Gets Cleaned Up:**
   - ✅ Session data deleted
   - ✅ Cookies removed
   - ✅ Cancel flags cleared
   - ✅ Resources released

3. **Response Time:**
   - **Instant**: If between operations
   - **~2 seconds**: If during API call
   - **Max 5 seconds**: Worst case scenario

---

## 💡 Examples

### Example 1: Cancel Slow Check
```
You: 4147202730390331|03|2030|392,30

Bot: ⏳ Checking: 4147202730390331|03|2030|392,30
     Please wait...

[10 seconds pass, taking too long]

You: /stop

Bot: 🛑 Stop Request Received
     Cancelling ongoing card check...
     The bot will stop processing as soon as possible.

[Shortly after]

Bot: 🛑 Cancelled
     💳 4147202730390331|03|2030|392,30
     Card check cancelled by user.
```

### Example 2: Cancel Wrong Card
```
You: 4111111111111111|12|2025|999

Bot: ⏳ Checking: 4111111111111111|12|2025|999
     Please wait...

[Oops, wrong card!]

You: /stop

Bot: 🛑 Stop Request Received
     Cancelling ongoing card check...

Bot: 🛑 Cancelled
     💳 4111111111111111|12|2025|999
     Card check cancelled by user.

[Now send correct card]

You: 4147202730390331|03|2030|392

Bot: ⏳ Checking: 4147202730390331|03|2030|392
     Please wait...
```

### Example 3: Multiple Quantity Cancel
```
You: 5555555555554444|06|2028|123,50

Bot: ⏳ Checking: 5555555555554444|06|2028|123,50
     Please wait...

[This will charge $525, want to cancel!]

You: /stop

Bot: 🛑 Cancelled
     💳 5555555555554444|06|2028|123,50
     Card check cancelled by user.
```

---

## 📋 Updated Commands

### `/start` Command
Now shows:
```
🤖 Card Checker Bot

Commands:
/check - Check a card
/help - Show help
/stop - Cancel ongoing check  ← NEW!

💵 Amount per quantity:
Each quantity is equivalent to $10.50

Format:
CCNUMBER|MM|YYYY|CVV or CCNUMBER|MM|YYYY|CVV,QUANTITY

Examples:
4350940005555920|07|2025|123
4350940005555920|07|2025|123,15 (with quantity)
```

---

## ⚠️ Important Notes

1. **Immediate Response**
   - `/stop` command responds immediately
   - Actual cancellation happens at next safe point

2. **Safe Cancellation**
   - Bot waits for current operation to complete
   - Doesn't interrupt mid-API call
   - Cleans up resources properly

3. **No Effect If Done**
   - If check already finished, `/stop` does nothing
   - You'll receive the result anyway

4. **One Check at a Time**
   - Only your current check is cancelled
   - Doesn't affect other users
   - Each user has separate cancel flag

---

## 🧪 Testing

### Test 1: Cancel During Processing
```
1. Send: 4147202730390331|03|2030|392,15
2. Immediately send: /stop
3. Verify: Bot cancels and confirms
```

### Test 2: Stop Before Start
```
1. Send: /stop (no check running)
2. Result: Bot acknowledges but nothing to cancel
3. Send card to check normally
```

### Test 3: Stop After Complete
```
1. Send: 4147202730390331|03|2030|392
2. Wait for result (✅ or ❌)
3. Send: /stop
4. Result: No effect, check already done
```

---

## 🔧 Technical Implementation

### **Cancellation Flags:**
```javascript
// Global object tracking cancel requests
const cancelFlags = {};

// Set when user sends /stop
cancelFlags[chatId] = true;

// Checked throughout processing
if (cancelFlags[chatId]) {
    // Clean up and cancel
    await sendMessage(chatId, "🛑 Cancelled...");
    delete cancelFlags[chatId];
    return;
}
```

### **Cancellation Check Points:**
1. ✅ Start of `processCard()`
2. ✅ Before while loop
3. ✅ Start of each retry iteration
4. ✅ After retry wait period
5. ✅ Cleanup in finally block

---

## 💬 Messages

### Stop Request Message:
```
🛑 Stop Request Received

Cancelling ongoing card check...

The bot will stop processing as soon as possible.
```

### Cancelled Message:
```
🛑 Cancelled

💳 <card-number>

Card check cancelled by user.
```

---

## 📊 Use Cases

| Scenario | Action | Result |
|----------|--------|--------|
| Check taking too long | Send `/stop` | Cancels immediately |
| Wrong card sent | Send `/stop` | Cancels, send correct card |
| Wrong quantity | Send `/stop` | Cancels, send correct quantity |
| Changed mind | Send `/stop` | Cancels processing |
| Accidental send | Send `/stop` | Prevents completion |

---

## ✅ Benefits

✅ **Save Time** - Don't wait for wrong checks
✅ **Save Money** - Cancel before processing expensive quantities
✅ **Fix Mistakes** - Correct errors quickly
✅ **Full Control** - You decide when to stop
✅ **Clean Exit** - Proper resource cleanup

---

## 🚀 Deployment Status

✅ **Implemented**: Cancellation system
✅ **Tested**: Multiple cancellation points
✅ **Deployed**: Available now
✅ **Command**: `/stop`

---

**The `/stop` command is live! Use it anytime during card processing to cancel.** 🛑
