import io
import json
import time
import mysql.connector
from selenium import webdriver

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="selenium"
)

db = mydb.cursor()
sql_category = "SELECT category, image FROM products WHERE barcode = %s"
sql_category_name = "SELECT category, image FROM products WHERE name = %s"

url = 'https://sklep.stokrotka.pl/'
driver = webdriver.Firefox()
with driver as driver:
    driver.get(url)
    arrayofLinks = []
    number_of_lines = len(open('links.txt').readlines())
    with io.open('links.txt', "r") as file:
        arrayofLinks = file.readlines()
    for link in arrayofLinks:
        number_of_lines -= 1
        driver.get(link)
        nazwa = 'null'
        kod_kreskowy = 'null'
        if (((number_of_lines) % 100) == 0):
            print('Pozostalo', number_of_lines, 'produktow')
        elif (((number_of_lines) % 50) == 0):
            print('Pozostalo', number_of_lines, 'produktow')
        elif (((number_of_lines) % 10) == 0 and number_of_lines < 50):
            print('Pozostalo', number_of_lines, 'produktow')
        try:
            nazwa = driver.find_element_by_css_selector('.product_name h1').get_attribute('textContent')
            if (driver.find_element_by_css_selector('.product_parms li span.name').get_attribute('textContent') == 'Ean:'):
                kod_kreskowy = driver.find_element_by_css_selector('.product_parms li span.value').get_attribute('textContent')
            else:
                kod_kreskowy = driver.find_element_by_css_selector('.product_parms li:nth-child(2) span.value').get_attribute('textContent')
        except Exception as e:
            print('Wykryto wyjatek:', e, end="")
            with io.open('failed-checker.txt', "a") as file:
                    file.write(link)
            continue
        if (kod_kreskowy.replace(' ', '') == ''):
            kod_kreskowy = 'null'
        Product = {
            'kategoria': 'Brak',
            'kod_kreskowy': kod_kreskowy,
            'link': link,
        }
        if (kod_kreskowy == 'null'):
            val = (nazwa,)
            db.execute(sql_category_name, val)
            cg = db.fetchone()
        else:
            val = (kod_kreskowy,)
            db.execute(sql_category, val)
            cg = db.fetchone()
        if (cg == None):
            with io.open('NotAddedProducts.txt', "a", encoding="utf-8") as file:
                file.write(json.dumps(Product))
                file.write('\n')
            continue
        else:
            catg = cg[0]
            img = cg[1]
        # print(cg)
        if (catg == 'Inne'):
            with io.open('withoutCategory.txt', "a", encoding="utf-8") as file:
                file.write(json.dumps(Product))
                file.write('\n')
        if ('templates/szablon_pit/grafika/brak_zdjecia_srednie.gif' in img):
            with io.open('withoutImage.txt', "a", encoding="utf-8") as file:
                file.write(json.dumps(Product))
                file.write('\n')
    print('Koniec!')
    driver.quit()
