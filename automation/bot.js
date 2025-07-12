import puppeteer from 'puppeteer-extra';
import StealthPlugin from 'puppeteer-extra-plugin-stealth';
import inquirer from 'inquirer';
import fs from 'fs';
import path from 'path';
import WebSocket from 'ws';
import {
  CapMonsterCloudClientFactory,
  ClientOptions,
  RecaptchaV2Request,
  HCaptchaRequest,
  TurnstileRequest
} from '@zennolab_com/capmonstercloud-client';

let bannedText = 'You have been banned from this chat. You cannot enter.';

// Attempt to load the ban message from the English language file so the bot
// stays in sync with the installed chat version.
try {
  const langFile = path.join(
    path.dirname(new URL(import.meta.url).pathname),
    '..',
    'codychat8.0',
    'codychat',
    'system',
    'language',
    'English',
    'language.php'
  );
  const text = fs.readFileSync(langFile, 'utf8');
  const match = text.match(/\$lang\['ban_text'\]\s*=\s*'([^']+)'/);
  if (match) bannedText = match[1];
} catch {
  // If the file isn't found just keep the default text
}

puppeteer.use(StealthPlugin());

const defaultProxy =
  'pcSAhEGN2N-res-any:PC_8jVAtII8AYs7ieB3E@proxy-us.proxy-cheap.com:5959';
let proxy = process.env.PROXY_URI || defaultProxy;
let [proxyCred, proxyServer] = proxy.split('@');
let [proxyUser, proxyPass] = proxyCred.split(':');

const defaultCaptchaKey = 'b1b1c099a0d6402b4d4725de8926fc4f';

const randomString = (len) => {
  const chars = 'abcdefghijklmnopqrstuvwxyz';
  return Array.from({ length: len }, () => chars[Math.floor(Math.random() * chars.length)]).join('');
};

const randomIp = () =>
  Array.from({ length: 4 }, () => Math.floor(Math.random() * 256)).join('.');

const inputDelay = 30;

const waitTime = async (page, ms) => {
  if (typeof page.waitForTimeout === 'function') {
    await page.waitForTimeout(ms);
  } else if (typeof page.waitFor === 'function') {
    await page.waitFor(ms);
  } else {
    await new Promise((r) => setTimeout(r, ms));
  }
};

const checkBanned = (page) =>
  page.evaluate((text) => document.body && document.body.innerText.includes(text), bannedText);

const triggerModal = async (page, mode) => {
  const action = mode === 'guest' ? 'getGuestLogin' : 'getRegistration';
  for (let i = 0; i < 5; i++) {
    const hasAction = await page.evaluate(fn => typeof window[fn] === 'function', action);
    if (hasAction) {
      console.log(`[+] Triggering ${mode} modal`);
      await page.evaluate(fn => window[fn](), action);
      return true;
    }
    const clicked = await page.evaluate(fn => {
      const btn = document.querySelector(`button[onclick="${fn}();"]`);
      if (btn) { btn.click(); return true; }
      return false;
    }, action);
    if (clicked) {
      console.log(`[+] Triggered ${mode} modal via button`);
      return true;
    }
    await waitTime(page, 1000);
  }
  return false;
};

const openModalWithWait = async (page, mode) => {
  const form = mode === 'guest' ? '#guest_form_box' : '#registration_form_box';
  for (let i = 0; i < 6; i++) {
    await triggerModal(page, mode);
    try {
      await page.waitForSelector(form, { timeout: 5000 });
      return true;
    } catch (e) {
      console.log('[!] Modal not ready, retrying...');
    }
  }
  return false;
};
let cmcClient;

const detectCaptcha = async (page) => {
  return await page.evaluate(() => {
    const result = { type: null, siteKey: null };
    const findKey = (selector) => {
      const el = document.querySelector(selector);
      return el ? el.getAttribute('data-sitekey') : null;
    };
    if (window.recaptKey) {
      result.type = 'recaptcha';
      result.siteKey = window.recaptKey;
      return result;
    }
    const rk = findKey('.g-recaptcha[data-sitekey]');
    if (rk) { result.type = 'recaptcha'; result.siteKey = rk; return result; }
    const hk = findKey('.h-captcha[data-sitekey]');
    if (hk) { result.type = 'hcaptcha'; result.siteKey = hk; return result; }
    const tk = findKey('.cf-turnstile[data-sitekey]');
    if (tk) { result.type = 'turnstile'; result.siteKey = tk; return result; }
    return result;
  });
};

const solveCaptcha = async ({ type, siteKey, site }) => {
  console.log(`[+] Solving ${type} CAPTCHA with sitekey: ${siteKey}`);
  if (type === 'hcaptcha') {
    const req = new HCaptchaRequest({ websiteURL: site, websiteKey: siteKey });
    const res = await cmcClient.Solve(req);
    return res.solution.gRecaptchaResponse;
  }
  if (type === 'turnstile') {
    const req = new TurnstileRequest({ websiteURL: site, siteKey });
    const res = await cmcClient.Solve(req);
    return res.solution.token;
  }
  const req = new RecaptchaV2Request({ websiteURL: site, websiteKey: siteKey });
  const res = await cmcClient.Solve(req);
  return res.solution.gRecaptchaResponse;
};

const injectCaptchaToken = async (page, token, type) => {
  await page.evaluate((t, tp) => {
    const setVal = (sel) => { const el = document.querySelector(sel); if (el) el.value = t; };
    if (tp === 'turnstile') {
      setVal('input[name="cf-turnstile-response"]');
      setVal('#cf-turnstile-response');
    } else if (tp === 'hcaptcha') {
      setVal('#h-captcha-response');
      setVal('textarea[name="h-captcha-response"]');
      setVal('#g-recaptcha-response');
    } else {
      setVal('#g-recaptcha-response');
      setVal('textarea[name="g-recaptcha-response"]');
    }
  }, token, type);
};

const navigateWithRetry = async (page, url, options) => {
  for (let attempt = 0; attempt < 2; attempt++) {
    try {
      await page.goto(url, options);
      return;
    } catch (err) {
      if (err.name === 'TimeoutError') {
        console.log('[!] Navigation timeout, retrying...');
        if (attempt === 1) throw err;
      } else {
        throw err;
      }
    }
  }
};

const waitForNavigationSafe = async (page, options) => {
  try {
    await page.waitForNavigation(options);
  } catch (err) {
    if (err.name === 'TimeoutError') {
      console.log('[!] Navigation timeout after action, continuing...');
    } else {
      throw err;
    }
  }
};

const runWithConcurrency = async (tasks, limit) => {
  const queue = tasks.slice();
  const workers = [];
  for (let i = 0; i < Math.min(limit, queue.length); i++) {
    workers.push(
      (async function worker() {
        while (queue.length) {
          const job = queue.shift();
          try {
            await job();
          } catch (err) {
            console.error('[!] Worker error:', err.message);
          }
        }
      })()
    );
  }
  await Promise.all(workers);
};

const runUntilSuccess = async (options) => {
  while (true) {
    const result = await registerOnce(options);
    if (result === 'banned') {
      console.log('[#] Restarting session after ban...');
      continue;
    }
    break;
  }
};

const registerOnce = async (opts) => {
  const {
    site,
    cf_clearance,
    mode,
    skipCaptcha,
    sendMessages,
    messageText,
    messageInterval,
    emailDomain,
    outputFile,
    headless,
    ipSpoof,
    useWebSocket,
    wsUrl
  } = opts;
  const browser = await puppeteer.launch({
    headless,
    args: [
      `--proxy-server=${proxyServer}`,
      '--no-sandbox',
      '--disable-setuid-sandbox',
      '--disable-extensions'
    ]
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 1920, height: 1080 });
  await page.authenticate({ username: proxyUser, password: proxyPass });
  if (ipSpoof) {
    const fakeIp = randomIp();
    await page.setExtraHTTPHeaders({
      'X-Forwarded-For': fakeIp,
      'CF-Connecting-IP': fakeIp
    });
  }

  try {
    if (cf_clearance) {
      await page.setCookie({
        name: 'cf_clearance',
        value: cf_clearance,
        domain: new URL(site).hostname,
        path: '/',
        httpOnly: true,
        secure: true
      });
    }

    await page.setUserAgent(
      `Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/${
        Math.floor(Math.random() * 30) + 90}.0.0.0 Safari/537.36`
    );

    console.log(`[+] Navigating to ${site}`);
    await navigateWithRetry(page, site, { waitUntil: 'networkidle2', timeout: 60000 });

    if (await checkBanned(page)) {
      console.log('[!] Banned message detected on load');
      await browser.close();
      return 'banned';
    }

    const opened = await openModalWithWait(page, mode);
    if (!opened) {
      console.log('[!] Could not open modal, aborting.');
      await browser.close();
      return;
    }

    let username = randomString(6);

    const email = `${randomString(8)}@${emailDomain}`;
    const password = 'password';
    if (mode === 'guest') {
      console.log(`[+] Filling guest username: ${username}`);
      await page.type('#guest_username', username, { delay: inputDelay });
      try {
        await page.select('#guest_gender', '1');
        await page.select('#guest_age', '18');
      } catch (err) {
        console.log('[!] Could not select gender/age, skipping...');
      }
    } else {
      console.log(`[+] Filling account form: ${username}, ${email}, ${password}`);
      await page.type('#reg_username', username, { delay: inputDelay });
      await page.type('#reg_password', password, { delay: inputDelay });
      await page.type('#reg_email', email, { delay: inputDelay });
      try {
        await page.select('#login_select_gender', '1');
        await page.select('#login_select_age', '18');
      } catch (err) {
        console.log('[!] Could not select gender/age, skipping...');
      }
    }


    if (!skipCaptcha) {
      const capt = await detectCaptcha(page);
      if (!capt.siteKey) {
        console.log('[!] No CAPTCHA sitekey found. Aborting.');
        await browser.close();
        return;
      }
      const token = await solveCaptcha({ type: capt.type, siteKey: capt.siteKey, site });
      await injectCaptchaToken(page, token, capt.type);
    } else {
      console.log('[+] Skipping CAPTCHA solving');
    }

    if (mode === 'guest') {
      const nav = waitForNavigationSafe(page, { waitUntil: 'networkidle2', timeout: 60000 });
      await page.evaluate(() => {
        if (typeof sendGuestLogin === 'function') {
          sendGuestLogin();
        } else {
          const btn = document.querySelector('button[onclick="sendGuestLogin();"]');
          if (btn) btn.click();
        }
      });
      await nav;
      console.log('[+] Submitted guest registration');
      await waitTime(page, 1000);
      if (await checkBanned(page)) {
        console.log('[!] Banned after guest registration');
        await browser.close();
        return 'banned';
      }
      if (outputFile) {
        fs.appendFileSync(outputFile, `${username}\n`);
      }
    } else {
      const nav = waitForNavigationSafe(page, { waitUntil: 'networkidle2', timeout: 60000 });
      await page.click('#register_button');
      await nav;
      console.log('[+] Submitted account registration');
      await waitTime(page, 1000);
      if (await checkBanned(page)) {
        console.log('[!] Banned after account registration');
        await browser.close();
        return 'banned';
      }
      if (outputFile) {
        fs.appendFileSync(outputFile, `${username},${email},${password}\n`);
      }
    }

    if (sendMessages) {
      if (useWebSocket) {
        console.log(`[+] Connecting WebSocket: ${wsUrl}`);
        const cookies = await page.cookies();
        const cookieHeader = cookies.map(c => `${c.name}=${c.value}`).join('; ');
        const ws = new WebSocket(wsUrl, { headers: { Cookie: cookieHeader } });
        ws.on('open', () => {
          console.log('[+] WebSocket connected');
          ws._spamTimer = setInterval(() => ws.send(messageText), messageInterval);
        });
        ws.on('message', (data) => {
          const text = data.toString();
          if (text.includes(bannedText)) {
            console.log('[!] Banned message via WebSocket');
            clearInterval(ws._spamTimer);
            ws.close();
            runUntilSuccess({ ...opts });
          }
        });
        ws.on('close', async () => {
          try { await browser.close(); } catch {}
        });
        return;
      }

      console.log(`[#] Waiting for chat to be ready to send messages`);
      try {
        await page.waitForFunction(
          () => typeof processChatPost === 'function',
          { timeout: 30000 }
        );
      } catch (e) {
        console.log('[!] processChatPost not available, attempting anyway');
      }

      console.log(`[+] Sending messages every ${messageInterval / 1000}s: "${messageText}"`);
      await page.evaluate((msg, interval) => {
        if (typeof processChatPost === 'function') {
          window._spamTimer = setInterval(() => processChatPost(msg), interval);
        }
      }, messageText, messageInterval);
      page
        .waitForFunction(
          (text) => document.body && document.body.innerText.includes(text),
          { polling: 2000, timeout: 0 },
          bannedText
        )
        .then(async () => {
          console.log('[!] Banned while sending messages');
          try { await browser.close(); } catch (e) {}
          console.log('[#] Launching a new session after ban...');
          runUntilSuccess({ ...opts });
        })
        .catch(() => {});
      return;
    } else {
      await waitTime(page, 5000);
    }
  } catch (err) {
    console.error('[!] Registration error:', err.message);
  } finally {
    if (!sendMessages) {
      try { await browser.close(); } catch (e) {}
    }
  }
};

const runBot = async () => {
  const answers = await inquirer.prompt([
    {
      type: 'input',
      name: 'site',
      message: 'Enter full site URL (e.g. https://osints.store/):'
    },
    {
      type: 'input',
      name: 'cf_clearance',
      message: 'Enter your cf_clearance cookie value:'
    },
    {
      type: 'list',
      name: 'mode',
      message: 'Choose registration mode:',
      choices: ['account', 'guest'],
      default: 'account'
    },
    {
      type: 'confirm',
      name: 'skipCaptcha',
      message: 'Skip solving reCAPTCHA?',
      default: false
    },
    {
      type: 'confirm',
      name: 'sendMessages',
      message: 'Send chat messages after registration?',
      default: false
    },
    {
      type: 'input',
      name: 'messageText',
      message: 'Message text to send:',
      default: 'lol',
      when: (ans) => ans.sendMessages
    },
    {
      type: 'input',
      name: 'messageInterval',
      message: 'Message interval in seconds:',
      default: '2.2',
      when: (ans) => ans.sendMessages,
      filter: (v) => {
        const num = parseFloat(v);
        return isNaN(num) ? 2200 : num * 1000;
      }
    },
    {
      type: 'input',
      name: 'emailDomain',
      message: 'Email domain for new accounts:',
      default: 'example.com',
      when: (ans) => ans.mode === 'account'
    },
    {
      type: 'confirm',
      name: 'saveCredentials',
      message: 'Save created credentials to file?',
      default: false
    },
    {
      type: 'input',
      name: 'outputFile',
      message: 'Output file path:',
      default: 'accounts.txt',
      when: (ans) => ans.saveCredentials
    },
    {
      type: 'number',
      name: 'accountCount',
      message: 'Number of accounts to register:',
      default: 1,
      filter: (v) => parseInt(v, 10) || 1
    },
    {
      type: 'number',
      name: 'concurrency',
      message: 'Max concurrent browsers:',
      default: 2,
      filter: (v) => parseInt(v, 10) || 1
    },
    {
      type: 'confirm',
      name: 'headlessFirst',
      message: 'Run first account headless as well?',
      default: false
    },
    {
      type: 'input',
      name: 'proxyUri',
      message: 'Proxy URI (user:pass@host:port):',
      default: process.env.PROXY_URI || defaultProxy
    },
    {
      type: 'input',
      name: 'captchaKey',
      message: 'CapMonster API key:',
      default: process.env.CAPMONSTER_KEY || defaultCaptchaKey
    },
    {
      type: 'confirm',
      name: 'ipSpoof',
      message: 'Spoof IP headers for non-CF sites?',
      default: false
    },
    {
      type: 'confirm',
      name: 'useWebSocket',
      message: 'Use WebSocket for sending messages?',
      default: false,
      when: (ans) => ans.sendMessages
    },
    {
      type: 'input',
      name: 'wsUrl',
      message: 'WebSocket URL:',
      default: (ans) => {
        const url = new URL(ans.site || 'http://localhost');
        url.protocol = url.protocol.startsWith('https') ? 'wss:' : 'ws:';
        url.pathname = '/ws';
        return url.toString();
      },
      when: (ans) => ans.useWebSocket
    }
  ]);

  const config = {
    site: answers.site.trim(),
    cf_clearance: answers.cf_clearance.trim(),
    mode: answers.mode,
    skipCaptcha: answers.skipCaptcha,
    sendMessages: answers.sendMessages,
    messageText: answers.messageText || 'lol',
    messageInterval: answers.messageInterval || 2200,
    emailDomain: answers.emailDomain || 'example.com',
    outputFile: answers.outputFile && answers.outputFile.trim(),
    ipSpoof: answers.ipSpoof && !answers.cf_clearance.trim(),
    useWebSocket: answers.useWebSocket,
    wsUrl: answers.wsUrl
  };

  proxy = answers.proxyUri || proxy;
  [proxyCred, proxyServer] = proxy.split('@');
  [proxyUser, proxyPass] = proxyCred.split(':');

  cmcClient = CapMonsterCloudClientFactory.Create(
    new ClientOptions({ clientKey: answers.captchaKey || defaultCaptchaKey })
  );

  const count = answers.accountCount || 1;
  const limit = answers.concurrency || 1;

  const jobFns = [];
  for (let i = 0; i < count; i++) {
    const headless = i > 0 || answers.headlessFirst;
    jobFns.push(() => {
      console.log(`[+] Starting registration ${i + 1}/${count} (headless: ${headless})`);
      return runUntilSuccess({ ...config, headless });
    });
  }

  await runWithConcurrency(jobFns, limit);
};

runBot();
