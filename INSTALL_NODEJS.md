# Installing Node.js and Building Assets

## Step 1: Install Node.js

1. **Download Node.js:**
   - Go to: https://nodejs.org/
   - Download the **LTS (Long Term Support)** version (recommended)
   - Choose the Windows Installer (.msi) for your system (64-bit)

2. **Run the Installer:**
   - Double-click the downloaded `.msi` file
   - Follow the installation wizard
   - **Important:** Make sure to check "Add to PATH" during installation (usually checked by default)
   - Click "Install" and wait for completion

3. **Verify Installation:**
   - Close and reopen your terminal/PowerShell
   - Run these commands to verify:
     ```bash
     node --version
     npm --version
     ```
   - You should see version numbers (e.g., `v20.x.x` and `10.x.x`)

## Step 2: Build Assets

Once Node.js is installed, come back here and I'll help you run:
```bash
npm install
npm run build
```

Or you can run them yourself:
1. Open a terminal in your project directory
2. Run: `npm install` (this installs all dependencies)
3. Run: `npm run build` (this builds the assets and creates the manifest.json)

## Troubleshooting

**If `node` command is not recognized after installation:**
- Close and reopen your terminal/PowerShell completely
- Restart your computer if needed
- Check if Node.js was added to PATH:
  - Open System Properties → Environment Variables
  - Check if `C:\Program Files\nodejs\` is in your PATH

**If you get permission errors:**
- Run PowerShell as Administrator
- Or use Command Prompt as Administrator

