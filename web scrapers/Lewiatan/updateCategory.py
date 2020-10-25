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
sql = "UPDATE products SET category = %s WHERE barcode = %s"
sql_nazwa = "UPDATE products SET category = %s WHERE name = %s"
with io.open('failed.txt', "w") as file:
    file.write('')

url = 'http://www.eskleplewiatan.pl/cat-pl-128-Wedliny.html'
driver = webdriver.Firefox()
with driver as driver:
    failed = 0
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
            nazwa = 'null'
            kod_kreskowy = 'null'
            number_of_lines -= 1
            driver.get(link)
            # time.sleep(1)
            if (((number_of_lines) % 100) == 0):
                print('Pozostalo', number_of_lines, 'produktow')
            elif (((number_of_lines) % 50) == 0):
                print('Pozostalo', number_of_lines, 'produktow')
            elif (((number_of_lines) % 10) == 0 and number_of_lines < 50):
                print('Pozostalo', number_of_lines, 'produktow')
            try:
                nazwa = driver.find_element_by_css_selector('h1.title').get_attribute('textContent')
                kod_kreskowy = driver.find_element_by_css_selector('.meta-info div:nth-child(3)').get_attribute('textContent').replace('Kod kreskowy:', '')
                # kategoria = driver.find_element_by_css_selector('.breadcrumbs a:nth-child(3)').get_attribute('textContent')
                kategoria = 'Wędliny'
            except Exception as e:
                print('Wykryto wyjatek:', e, end="")
                with io.open('failed.txt', "a") as file:
                    file.write(link)
                continue
            if (kod_kreskowy.replace(' ', '') == ''):
                kod_kreskowy = 'null'

            # print(zdjecie, nazwa, kod_kreskowy, skladniki, cena)
            if 'NAZWA_TYMCZASOWA' in nazwa:
                break
            Product = {
                'kategoria': kategoria,
                'nazwa': nazwa,
                'kod_kreskowy': kod_kreskowy,
            }
            with io.open('products.txt', "a", encoding="utf-8") as file:
                file.write(json.dumps(Product))
                file.write('\n')
            if (kod_kreskowy == 'null'):
                val = (kategoria, nazwa)
                db.execute(sql_nazwa, val)
            else:                
                val = (kategoria, kod_kreskowy)
                db.execute(sql, val)
            mydb.commit()
            
        driver.get('http://localhost:5000/')
        print('Czekam 30 sekund!')
        time.sleep(20)
        print('Pozostalo 10 sekund')
        time.sleep(5)
        print('Pozostalo 5 sekund')
        time.sleep(5)
        url = driver.find_element_by_class_name('url').get_attribute('value')
        if (url == 'koniec' or url == ''):
            print('Koniec!')
            driver.quit()
        else:
            newCategory(url)
    newCategory(url)
