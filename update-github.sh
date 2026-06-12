#!/bin/bash
# ============================================
# Samiur Rahman - Portfolio GitHub Updater
# Run this script anytime you make changes
# to push updates to GitHub automatically
# ============================================

echo "🚀 Uploading your portfolio changes to GitHub..."
echo "================================================"

cd "/run/media/samiur/My doc 100 GB/My Portfolio Website/My portfolio larabel"

# Add all changed files
git add .

# Create commit with timestamp
TIMESTAMP=$(date +"%Y-%m-%d %H:%M")
git commit -m "✏️ Portfolio updated - $TIMESTAMP"

# Push to GitHub
git push origin main

echo ""
echo "================================================"
echo "✅ Done! Your portfolio is live at:"
echo "   👉 https://samiur2025.github.io"
echo "   👉 https://github.com/samiur2025/samiur2025.github.io"
echo "================================================"
