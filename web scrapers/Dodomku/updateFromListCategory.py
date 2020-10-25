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

url = 'http://www.google.pl'
driver = webdriver.Firefox()
with driver as driver:
    def newCategory(url):      
        driver.get(url)
        arrayofLinks = []
        number_of_lines = len(open('WithoutCategory.txt').readlines())
        with io.open('WithoutCategory.txt', "r") as file:
            arrayofLinks = file.readlines()
        for item in arrayofLinks:
            link = item.split(',')[2].replace(' "link": "', '').replace('\\n"}', '')
            nazwa = 'null'
            kod_kreskowy = 'null'
            number_of_lines -= 1
            kategoria = 'Słodycze'
            driver.get(link)
            if (((number_of_lines) % 100) == 0):
                print('Pozostalo', number_of_lines, 'produktow')
            elif (((number_of_lines) % 50) == 0):
                print('Pozostalo', number_of_lines, 'produktow')
            elif (((number_of_lines) % 10) == 0 and number_of_lines < 50):
                print('Pozostalo', number_of_lines+1, 'produktow')
            try:
                nazwa = driver.find_element_by_css_selector('#naglowek h1').get_attribute('textContent')
                kod_kreskowy = driver.find_element_by_css_selector('div p.icon_value[itemprop="sku"]').get_attribute('textContent')
            except Exception as e:
                print('Wykryto wyjatek:', e, end="")
                with io.open('failed.txt', "a") as file:
                    file.write(link)
                continue
            if (kod_kreskowy.replace(' ', '') == ''):
                kod_kreskowy = 'null'
            Product = {
                'kategoria': kategoria,
                'nazwa': nazwa,
                'kod_kreskowy': kod_kreskowy,
            }
            if (kod_kreskowy == 'null'):
                val = (kategoria, nazwa)
                db.execute(sql_nazwa, val)
            else:                
                val = (kategoria, kod_kreskowy)
                db.execute(sql, val)
            mydb.commit()
            print('Pomyslnie dodano produkt.')
            print(Product)
            
        print('Koniec!')
        driver.quit()
    newCategory(url)
