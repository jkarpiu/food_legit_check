import io
import time
# import http.cookiejar as cookielib
# import urllib
import pyperclip
import mysql.connector
from selenium import webdriver

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="selenium"
)
# cj = cookielib.CookieJar()
# c = cookielib.Cookie(version=1,name="PHPSESSID",value="7nh07fpsg416lm70ne6psrevbb", port=None, port_specified=False, domain="sklep.stokrotka.pl", domain_specified=False, domain_initial_dot=False, path="/", path_specified=True, secure=False, expires=None, discard=True, comment=None, comment_url=None, rest={'HttpOnly': None}, rfc2109=False)
# cj.set_cookie(c)

print('Pamiętaj o kategorii!')
time.sleep(5)

pyperclip.copy('7nh07fpsg416lm70ne6psrevbb')

db = mydb.cursor()
sql = "INSERT INTO products (name, category, image, barcode, components, price) VALUES (%s, %s, %s, %s, %s, %s)"
url = 'https://sklep.stokrotka.pl/'
driver = webdriver.Firefox()
with driver as driver:
    def newCategory(url):      
        driver.get(url)
        arrayofLinks = []
        number_of_lines = len(open('NotAddedProducts.txt').readlines())
        with io.open('NotAddedProducts.txt', "r") as file:
            arrayofLinks = file.readlines()
        time.sleep(10)
        for item in arrayofLinks:
            link = item.split(',')[2].replace(' "link": "', '').replace('\\n"}', '')
            # link = item
            number_of_lines -= 1
            driver.get(link)
            skladniki = 'null'
            kategoria = 'Przetwory'
            zdjecie = 'null'
            nazwa = 'null'
            kod_kreskowy = 'null'
            # time.sleep(1)
            if (((number_of_lines) % 100) == 0):
                print('Pozostalo', number_of_lines, 'produktow')
            elif (((number_of_lines) % 50) == 0):
                print('Pozostalo', number_of_lines, 'produktow')
            elif (((number_of_lines) % 10) == 0 and number_of_lines < 50):
                print('Pozostalo', number_of_lines, 'produktow')
            try:
                zdjecie = driver.find_element_by_css_selector('.product_fotos a.center_foto img').get_attribute('src')
            except Exception:
                print('Nie znaleziono zadnego zdjecia')
            try:
                nazwa = driver.find_element_by_css_selector('.product_name h1').get_attribute('textContent')
                cena = driver.find_element_by_css_selector('.product_price_place span.price span[data-currency="PLN"]').get_attribute('textContent')
                if (driver.find_element_by_css_selector('.product_parms li span.name').get_attribute('textContent') == 'Ean:'):
                    kod_kreskowy = driver.find_element_by_css_selector('.product_parms li span.value').get_attribute('textContent')
                else:
                    kod_kreskowy = driver.find_element_by_css_selector('.product_parms li:nth-child(2) span.value').get_attribute('textContent')
            except Exception as e:
                print('Wykryto wyjatek:', e, end="")
                with io.open('failed-addProducts.txt', "a") as file:
                    file.write(link)
                continue
            try:
                skladniki = driver.find_element_by_css_selector('.desc_item div.itemHeader div.itemContent').get_attribute('textContent')
            except Exception:
                skladniki = ''
                pass
            if (kod_kreskowy.replace(' ', '') == ''):
                kod_kreskowy = 'null'
            val = (nazwa, kategoria, zdjecie, kod_kreskowy, skladniki , cena)
            try:
                db.execute(sql, val)
            except mysql.connector.IntegrityError:
                print('Rekord istnieje w bazie')
                print(nazwa, kod_kreskowy)
                pass
            mydb.commit()
        driver.quit()
    newCategory(url)
