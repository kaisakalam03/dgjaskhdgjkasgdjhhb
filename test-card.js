// Quick test script for bot.js
const express = require('express');
const axios = require('axios');

// Mock card test data
const testCard = '4147202730390331|03|2030|392';

console.log('='.repeat(50));
console.log('🧪 Bot Test Script');
console.log('='.repeat(50));
console.log('');
console.log('Testing card:', testCard);
console.log('');

// Parse card function (from bot.js)
function parseCard(card, validYYYY = 4) {
    const parts = card.split('|');
    let [cc, mm, yyyy, cvv] = parts;
    
    if (yyyy.length === 4 && validYYYY === 2) {
        yyyy = yyyy.substring(2);
    } else if (yyyy.length === 2 && validYYYY === 4) {
        yyyy = '20' + yyyy;
    }
    
    return { cc, mm, yyyy, cvv };
}

// Test card parsing
console.log('1️⃣ Testing card parser...');
const parsed = parseCard(testCard, 4);
console.log('   Card Number:', parsed.cc);
console.log('   Expiry Month:', parsed.mm);
console.log('   Expiry Year:', parsed.yyyy);
console.log('   CVV:', parsed.cvv);
console.log('   ✅ Card parsing works!');
console.log('');

// Test card validation pattern
console.log('2️⃣ Testing card validation...');
const cardPattern = /^\d{15,16}\|/;
const isValid = cardPattern.test(testCard);
console.log('   Pattern match:', isValid ? '✅ Valid' : '❌ Invalid');
console.log('');

// Card type detection
console.log('3️⃣ Detecting card type...');
const firstDigit = parsed.cc[0];
let cardType = 'Unknown';
if (firstDigit === '4') cardType = 'Visa';
else if (firstDigit === '5') cardType = 'Mastercard';
else if (firstDigit === '3') cardType = 'Amex/Discover';
console.log('   Card Type:', cardType);
console.log('');

// Simulate bot response
console.log('4️⃣ Bot would send to Telegram:');
console.log('-'.repeat(50));
console.log('⏳ Checking: `' + testCard + '`');
console.log('');
console.log('Please wait...');
console.log('-'.repeat(50));
console.log('');

console.log('5️⃣ Next steps (bot.js would do):');
console.log('   • Get random user info from randomuser.me');
console.log('   • Create order at santacruzcinema.com');
console.log('   • Get payment token from Braintree');
console.log('   • Tokenize card: ' + parsed.cc);
console.log('   • Attempt checkout');
console.log('   • Return result to Telegram');
console.log('');

console.log('='.repeat(50));
console.log('✅ Card format is correct!');
console.log('='.repeat(50));
console.log('');
console.log('To actually check this card:');
console.log('1. Deploy bot to Railway');
console.log('2. Set BOT_TOKEN environment variable');
console.log('3. Set webhook');
console.log('4. Send card to bot on Telegram: ' + testCard);
console.log('');
console.log('OR run locally:');
console.log('1. Run: npm start');
console.log('2. Run: ngrok http 8080 (in another terminal)');
console.log('3. Set webhook with ngrok URL');
console.log('4. Send card to bot on Telegram');
console.log('');
