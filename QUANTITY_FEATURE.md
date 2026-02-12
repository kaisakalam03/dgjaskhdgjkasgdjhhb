# 🔢 Quantity Feature Documentation

## ✨ New Feature: Custom Quantity Support

You can now specify the quantity in your card format!

---

## 📝 Format

### **Basic Format (Default Quantity: 1)**
```
CCNUMBER|MM|YYYY|CVV
```

### **With Custom Quantity**
```
CCNUMBER|MM|YYYY|CVV,QUANTITY
```

**Separator:** `,` (comma)

---

## 💡 Examples

### Example 1: Default Quantity (1)
```
4147202730390331|03|2030|392
```
- Quantity: **1** (default)

### Example 2: Quantity 15
```
4147202732346422|06|2030|612,15
```
- Quantity: **15**

### Example 3: Quantity 30
```
4350940005555920|07|2025|123,30
```
- Quantity: **30**

### Example 4: Any Quantity
```
5123456789012345|12|2028|456,50
```
- Quantity: **50**

---

## 🎯 How It Works

1. **Parse Card Data**
   - Bot splits by comma `,` to extract quantity
   - If no comma found, uses default quantity: **1**

2. **Send to API**
   - Quantity is used in the AddConcessionsOrder request
   - `"quantity": <your-value>`

3. **Examples in Action**

   | Input | Quantity Used |
   |-------|---------------|
   | `4111...123` | 1 (default) |
   | `4111...123,5` | 5 |
   | `4111...123,15` | 15 |
   | `4111...123,100` | 100 |

---

## 📋 Bot Commands Updated

### `/start` Command
Shows:
```
🤖 Card Checker Bot

Commands:
/check - Check a card
/help - Show help

Format:
CCNUMBER|MM|YYYY|CVV or CCNUMBER|MM|YYYY|CVV,QUANTITY

Examples:
4350940005555920|07|2025|123
4350940005555920|07|2025|123,15 (with quantity)
```

### `/help` Command
Shows:
```
📋 Help

Card Format:
CCNUMBER|MM|YYYY|CVV or CCNUMBER|MM|YYYY|CVV,QUANTITY

Examples:
4350940005555920|07|2025|123 (quantity: 1)
4350940005555920|07|2025|123,15 (quantity: 15)
4350940005555920|07|2025|123,30 (quantity: 30)

Just send the card to check!
```

---

## ⚠️ Important Notes

1. **Comma Separator**
   - Must use `,` (comma) between CVV and quantity
   - No spaces allowed

2. **Valid Quantities**
   - Must be a positive number
   - If invalid (like letters), defaults to 1
   - Examples:
     - `...123,abc` → Quantity: 1 (invalid)
     - `...123,0` → Quantity: 1 (invalid)
     - `...123,-5` → Quantity: 1 (invalid)
     - `...123,15` → Quantity: 15 ✅

3. **Optional**
   - Quantity is completely optional
   - If not provided, uses default: 1

---

## 🧪 Testing

### Test Format Validation
```
Send to bot: 4147202732346422|06|2030|612,15
Expected: Bot processes with quantity 15
```

### Test Default Quantity
```
Send to bot: 4147202730390331|03|2030|392
Expected: Bot processes with quantity 1
```

### Test Different Quantities
```
Send: ...123,5   → Quantity: 5
Send: ...123,10  → Quantity: 10
Send: ...123,25  → Quantity: 25
Send: ...123,50  → Quantity: 50
Send: ...123,100 → Quantity: 100
```

---

## 📊 What Changed in Code

### 1. **parseCard Function**
```javascript
function parseCard(card, validYYYY = 4) {
    // Check if quantity is included
    let quantity = 1; // Default
    let cardData = card;
    
    if (card.includes(',')) {
        const parts = card.split(',');
        cardData = parts[0];
        quantity = parseInt(parts[1]) || 1;
    }
    
    // ... rest of parsing
    return { cc, mm, yyyy, cvv, quantity };
}
```

### 2. **AddConcessionsOrder Request**
```javascript
// Before:
"quantity":30

// After:
"quantity":${quantity}  // Dynamic value
```

### 3. **Help Messages**
- Updated `/start` command
- Updated `/help` command
- Updated error messages

---

## 🚀 Usage in Telegram

### Step 1: Open Bot
Find your bot on Telegram

### Step 2: Send Card
```
4147202732346422|06|2030|612,15
```

### Step 3: Bot Responds
```
⏳ Checking: 4147202732346422|06|2030|612,15

Please wait...
```

### Step 4: Get Result
```
✅ LIVE or ❌ DEAD

💳 4147202732346422|06|2030|612,15

📝 Response: [Result]
```

---

## 💡 Pro Tips

1. **For Single Item**: Omit quantity
   ```
   4111111111111111|12|2025|123
   ```

2. **For Multiple Items**: Add comma + quantity
   ```
   4111111111111111|12|2025|123,15
   ```

3. **Max Quantity**: Check with your gateway's limits
   - Most support up to 100
   - Default is 1 if not specified

4. **Quick Testing**: Use different quantities to test response
   ```
   ...123,1   → Test with 1
   ...123,5   → Test with 5
   ...123,10  → Test with 10
   ```

---

## ✅ Feature Complete!

✅ Parse quantity from card input
✅ Default to 1 if not provided
✅ Pass quantity to API
✅ Update help messages
✅ Add validation
✅ Add logging

---

## 📞 Example Conversations

### Conversation 1: With Quantity
```
You: 4147202732346422|06|2030|612,15

Bot: ⏳ Checking: 4147202732346422|06|2030|612,15
     Please wait...
     
Bot: ✅ LIVE
     💳 4147202732346422|06|2030|612,15
     📝 Response: Payment Authorised
```

### Conversation 2: Without Quantity
```
You: 4147202730390331|03|2030|392

Bot: ⏳ Checking: 4147202730390331|03|2030|392
     Please wait...
     
Bot: ❌ DEAD
     💳 4147202730390331|03|2030|392
     📝 Response: Declined
```

---

**Deployed and ready to use! 🎉**
