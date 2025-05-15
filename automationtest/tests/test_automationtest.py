import string
import random

from playwright.sync_api import Page, expect
from userdata import UserData


class Product:
    def __init__(self, name, price):
        self.name = name
        self.price = price


def generate_random_data():
    username_length = 10
    username = ''.join(random.choice(string.ascii_lowercase + string.digits) for _ in range(username_length))
    return f"fel_{username}@test.com", username


email, user = generate_random_data()
userdata = UserData("Keresztnév",
                    "Utónév",
                    email,
                    "+3601123423",
                    user,
                    "jelszo12",
                    "Valamilyen út 2.",
                    "Szeged",
                    "97",
                    "8491",
                    "1434")
vasarlas = 2
products = []

def test_order_product(page: Page):
    print("Felhasználói adatok:", userdata)
    register_account(page)
    check_account_data(page)
    order_and_check_shirt_products(page)
    check_order(page)


def login_account(page: Page):
    page.goto("https://automationteststore.com/")
    page.get_by_role("link", name="Login or register").click()
    page.locator("#loginFrm_loginname").click()
    page.locator("#loginFrm_loginname").fill(userdata.loginname)
    page.locator("#loginFrm_password").click()
    page.locator("#loginFrm_password").fill(userdata.password)
    page.get_by_role("button", name=" Login").click()


def register_account(page: Page):
    page.goto("https://automationteststore.com/")
    page.get_by_role("link", name="  Account").click()
    page.get_by_role("button", name=" Continue").click()
    page.locator("#AccountFrm_firstname").click()
    page.locator("#AccountFrm_firstname").fill(userdata.firstname)
    page.locator("#AccountFrm_lastname").fill(userdata.lastname)
    page.locator("#AccountFrm_email").fill(userdata.email)
    page.locator("#AccountFrm_telephone").fill(userdata.telephone)
    page.locator("#AccountFrm_loginname").fill(userdata.loginname)
    page.locator("#AccountFrm_password").fill(userdata.password)
    page.locator("#AccountFrm_confirm").fill(userdata.password)
    page.locator("#AccountFrm_address_1").fill(userdata.address_1)
    page.locator("#AccountFrm_city").fill(userdata.city)
    page.locator("#AccountFrm_country_id").select_option(userdata.country_id)
    page.locator("#AccountFrm_postcode").fill(userdata.postcode)
    page.locator("#AccountFrm_zone_id").select_option(userdata.zone_id)
    page.get_by_text("No", exact=True).click()
    page.get_by_role("checkbox", name="I have read and agree to the").check()
    page.get_by_role("button", name=" Continue").click()
    element = page.locator(".alert")
    expect(element).not_to_be_visible()


def check_account_data(page: Page):
    page.goto("https://automationteststore.com/")
    page.get_by_text("Welcome back").click()

    #Account details
    edit = page.locator(".myaccountbox").get_by_role("link", name="Edit account details")
    expect(edit).to_be_visible()
    edit.click()
    firstname = page.locator("#AccountFrm_firstname")
    lastname = page.locator("#AccountFrm_lastname")
    email = page.locator("#AccountFrm_email")
    telephone = page.locator("#AccountFrm_telephone")
    fax = page.locator("#AccountFrm_fax")
    expect(firstname).to_have_value(userdata.firstname)
    expect(lastname).to_have_value(userdata.lastname)
    expect(email).to_have_value(userdata.email)
    expect(telephone).to_have_value(userdata.telephone)
    expect(fax).to_be_visible()

    #Address book
    page.locator(".myaccountbox").get_by_role("link", name="Manage Address Book").click()
    page.get_by_role("button", name="Edit").click()
    address_1 = page.locator("#AddressFrm_address_1")
    city = page.locator("#AddressFrm_city")
    country_id = page.locator("#AddressFrm_country_id")
    postcode = page.locator("#AddressFrm_postcode")
    zone_id = page.locator("#AddressFrm_zone_id")
    expect(address_1).to_have_value(userdata.address_1)
    expect(city).to_have_value(userdata.city)
    expect(country_id).to_have_value(userdata.country_id)
    expect(postcode).to_have_value(userdata.postcode)
    expect(zone_id).to_have_value(userdata.zone_id)


def order_and_check_shirt_products(page: Page):

    page.goto("https://automationteststore.com/")
    for i in range(vasarlas):
        page.get_by_role("link", name="Apparel & Accessories").hover()
        page.get_by_role("link", name="T-shirts").click()
        page.locator("#sort").select_option("p.price-DESC")
        #page.goto("https://automationteststore.com/index.php?rt=product/category&path=68_70&sort=p.price-DESC&limit=20")
        element = page.get_by_role("link", name="").nth(i)
        expect(element).to_be_visible()
        element.click()
        productname = page.get_by_role("heading").locator(".bgnone").text_content().strip()
        price = page.locator(".productpageprice").text_content().strip()
        product = Product(productname, price)
        products.append(product)
        page.get_by_role("link", name="Add to Cart").click()

    for i in range(vasarlas):
        productname = page.get_by_role("cell",
                                       name=products[i].name).get_by_role("link")
        price = page.get_by_role("cell",
                                 name=products[i].price).first
        expect(productname).to_contain_text(products[i].name)
        expect(price).to_contain_text(products[i].price)
    page.locator("#cart_checkout2").click()
    page.get_by_role("button", name="Confirm Order").click()
    confirm = page.locator("#maincontainer div").nth(3)
    data = confirm.text_content()
    page.get_by_role("link", name="Continue").click()


def check_order(page: Page):
    page.goto("http://automationteststore.com/")
    page.get_by_text("Welcome back").hover()
    page.locator("#customer_menu_top").get_by_role("link", name="   Order history").click()
    content = page.locator(".content > div").first
    content.locator("#button_edit").click()
    for i in range(vasarlas):
        productname = page.get_by_role("cell",
                                       name=products[i].name).get_by_role("link")
        price = page.get_by_role("cell",
                                 name=products[i].price).first
        expect(productname).to_contain_text(products[i].name)
        expect(price).to_contain_text(products[i].price)
    pass

def clear_orders(page: Page):
    page.goto("http://automationteststore.com/")
    page.get_by_role("link", name="Cart").click()
    page.get_by_role("link", name="").click()
    page.get_by_role("link", name="").click()
    pass


def logout(page: Page):
    page.get_by_role("link", name="Welcome back").hover()
    page.get_by_role("link", name="   Not").click()
