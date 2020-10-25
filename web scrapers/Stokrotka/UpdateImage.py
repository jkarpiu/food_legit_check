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
sql = "UPDATE products SET image = %s WHERE barcode = %s"
sql_nazwa = "UPDATE products SET image = %s WHERE name = %s"

url = 'https://sklep.stokrotka.pl/'
driver = webdriver.Firefox()
with driver as driver:
    def newImage(url):      
        driver.get(url)
        arrayofLinks = []
        number_of_lines = len(open('withoutImage.txt').readlines())
        with io.open('withoutImage.txt', "r") as file:
            arrayofLinks = file.readlines()
        for item in arrayofLinks:
            link = item.split(',')[2].replace(' "link": "', '').replace('\\n"}', '')
            nazwa = 'null'
            kod_kreskowy = 'null'
            number_of_lines -= 1
            driver.get(link)
            if (((number_of_lines) % 100) == 0):
                print('Pozostalo', number_of_lines, 'produktow')
            elif (((number_of_lines) % 50) == 0):
                print('Pozostalo', number_of_lines, 'produktow')
            elif (((number_of_lines) % 10) == 0 and number_of_lines < 50):
                print('Pozostalo', number_of_lines+2, 'produktow')
            try:
                zdjecie = driver.find_element_by_css_selector('.product_fotos a.center_foto img').get_attribute('src')
                nazwa = driver.find_element_by_css_selector('.product_name h1').get_attribute('textContent')
                if (driver.find_element_by_css_selector('.product_parms li span.name').get_attribute('textContent') == 'Ean:'):
                    kod_kreskowy = driver.find_element_by_css_selector('.product_parms li span.value').get_attribute('textContent')
                else:
                    kod_kreskowy = driver.find_element_by_css_selector('.product_parms li:nth-child(2) span.value').get_attribute('textContent')
            except Exception as e:
                print('Wykryto wyjatek:', e, end="")
                with io.open('failed-image.txt', "a") as file:
                    file.write(link)
                continue
            if (kod_kreskowy.replace(' ', '') == ''):
                kod_kreskowy = 'null'
            Product = {
                'zdjecie': zdjecie,
                'nazwa': nazwa,
                'kod_kreskowy': kod_kreskowy,
            }
            if (kod_kreskowy == 'null'):
                val = (zdjecie, nazwa)
                db.execute(sql_nazwa, val)
            else:                
                val = (zdjecie, kod_kreskowy)
                db.execute(sql, val)
            mydb.commit()
            print('Pomyslnie zaktualizowano produkt.')
            print(Product)
            
        print('Koniec!')
        driver.quit()
    newImage(url)
