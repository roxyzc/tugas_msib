import puppeteer from "puppeteer";
import { setTimeout } from "node:timers/promises";

const BASE_URL = "https://github.com/";

const app = {
  browser: null,
  page: null,
  initialize: async () => {
    app.browser = await puppeteer.launch({ headless: false });
    app.page = await app.browser.newPage();
    await app.page.goto(BASE_URL);
  },
  login: async () => {
    const loginButtonClicked = await app.page.evaluate(() => {
      const loginButton = Array.from(document.querySelectorAll("a")).find(
        (el) => el.textContent.includes("Sign in")
      );
      if (loginButton) {
        loginButton.click();
        return true;
      }
      return false;
    });

    if (loginButtonClicked) {
      await app.page.waitForNavigation({ waitUntil: "networkidle2" });
      console.log("Navigation to login page successful.");

      await app.page.type('input[name="login"]', "roxyzc", { delay: 200 });
      await app.page.type('input[name="password"]', "password", {
        delay: 250,
      });
      await app.page.click('input[type="submit"][value="Sign in"]');
    } else {
      console.error("Login button not found.");
    }
  },
  moveToProfile: async (name) => {
    await app.page.click(`button[type="button"][data-login="${name}"]`);
    await setTimeout(2000);
    await app.page.goto(`https://github.com/${name}`);
  },
  scrollToDown: async () => {
    await app.page.evaluate(async () => {
      const distance = 100;
      const delay = 100;
      const totalHeight = document.body.scrollHeight;
      let scrolled = 0;

      while (scrolled < totalHeight) {
        window.scrollBy(0, distance);
        scrolled += distance;
        await new Promise((resolve) => setTimeout(resolve, delay));
      }
    });
  },
  scrollToTop: async () => {
    await app.page.evaluate(async () => {
      const distance = 100;
      const delay = 100;
      const totalHeight = document.body.scrollHeight;
      let scrolled = window.scrollY;

      while (scrolled > 0) {
        window.scrollBy(0, -distance);
        scrolled -= distance;

        if (scrolled < 0) {
          scrolled = 0;
        }

        await new Promise((resolve) => setTimeout(resolve, delay));
      }
    });
  },
};

(async () => {
  await app.initialize();
  await setTimeout(2000);
  await app.login();
  await setTimeout(2000);
  await app.scrollToDown();
  await setTimeout(2000);
  await app.scrollToTop();
  await setTimeout(2000);
  await app.moveToProfile("roxyzc");
})();
