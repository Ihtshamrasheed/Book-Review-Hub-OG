from playwright.sync_api import sync_playwright

def run(playwright):
    browser = playwright.chromium.launch()
    page = browser.new_page()
    page.goto("http://localhost:8000")
    page.fill("input[name='email']", "ali@vu.com")
    page.fill("input[name='password']", "pw")
    page.click("button[type='submit']")
    page.wait_for_load_state("networkidle")
    page.screenshot(path="jules-scratch/verification/admin_dashboard.png")
    browser.close()

with sync_playwright() as playwright:
    run(playwright)