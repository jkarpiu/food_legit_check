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
sql_category = "SELECT category FROM products WHERE barcode = %s"
sql_category_name = "SELECT category FROM products WHERE name = %s"

url = 'http://www.eskleplewiatan.pl/cat-pl-14-Zywnosc-dla-dzieci.html'
driver = webdriver.Firefox()
with driver as driver:
    def newCategory(url):      
        with io.open('links.txt', "w") as file:
            file.write('')
        driver.get(url)
        products = driver.find_elements_by_css_selector(".lista_produktow .product")
        arrayofLinks = []
        for product in products:
            title = product.find_element_by_css_selector('h2').get_attribute('textContent')
            if ('NAZWA_TYMCZASOWA' not in title):
                with io.open('links.txt', "a") as file:
                    file.write(product.find_element_by_css_selector('.photo a').get_attribute('href') + '\n')
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
                nazwa = driver.find_element_by_css_selector('h1.title').get_attribute('textContent')
                kod_kreskowy = driver.find_element_by_css_selector('.meta-info div:nth-child(3)').get_attribute('textContent').replace('Kod kreskowy:', '')
            except Exception as e:
                print('Wykryto wyjatek:', e, end="")
                continue
            if (kod_kreskowy.replace(' ', '') == ''):
                kod_kreskowy = 'null'
            Product = {
                'kategoria': 'Brak',
                'kod_kreskowy': kod_kreskowy,
                'link': link,
            }
            if (driver.find_element_by_css_selector('h1').get_attribute('textContent') == 'Not Found'):
                print('Not found!')
                continue
            if (kod_kreskowy == 'null'):
                val = (nazwa,)
                db.execute(sql_category_name, val)
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
                cg = cg[0]
            # print(cg)
            if (cg == 'Inne'):
                with io.open('withoutCategory.txt', "a", encoding="utf-8") as file:
                    file.write(json.dumps(Product))
                    file.write('\n')
        print('Koniec!')
        driver.quit()
    newCategory(url)
