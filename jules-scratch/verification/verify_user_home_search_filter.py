from playwright.sync_api import sync_playwright

def run(playwright):
    browser = playwright.chromium.launch()
    page = browser.new_page()
    page.goto("http://localhost:8000")
    page.fill("input[name='email']", "ihtsham@vu.com")
    page.fill("input[name='password']", "pw")
    page.click("button[type='submit']")
    page.wait_for_load_state("networkidle")
    page.goto("http://localhost:8000/user/home.php")
    page.fill("input[name='search']", "The Lord of the Rings")
    page.click("button:has-text('Select Genre')")
    page.check("input[value='Fantasy']")
    page.click("#genreForm button:has-text('Done')")
    page.wait_for_load_state("networkidle")
    page.screenshot(path="jules-scratch/verification/user_home_search_filter.png")
    browser.close()

with sync_playwright() as playwright:
    run(playwright)