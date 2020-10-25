import io
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
sql = "INSERT INTO products (name, category, image, barcode, components, price) VALUES (%s, %s, %s, %s, %s, %s)"
url = 'http://www.google.com'
driver = webdriver.Firefox()
with driver as driver:
    def newCategory(url):      
        arrayofLinks = []
        number_of_lines = len(open('NotAddedProducts.txt').readlines())
        with io.open('NotAddedProducts.txt', "r") as file:
            arrayofLinks = file.readlines()
        for item in arrayofLinks:
            link = item.split(',')[2].replace(' "link": "', '').replace('\\n"}', '')
            number_of_lines -= 1
            driver.get(link)
            skladniki = 'null'
            kategoria = 'Pieczywo'
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
                zdjecie = driver.find_element_by_css_selector('#wybrany_rysunek .main-product-img').get_attribute('src')
            except Exception:
                print('Nie znaleziono zadnego zdjecia')
            try:
                nazwa = driver.find_element_by_css_selector('#naglowek h1').get_attribute('textContent')
                kod_kreskowy = driver.find_element_by_css_selector('div p.icon_value[itemprop="sku"]').get_attribute('textContent')
                cena = driver.find_element_by_css_selector('div#wybrany_cena span:nth-child(2)').get_attribute('textContent')
            except Exception as e:
                print('Wykryto wyjatek:', e, end="")
            try:
                skladniki = driver.find_element_by_css_selector('div#ingredients .dlugi_opis_tresc:nth-child(2)').get_attribute('textContent')
                if 'awartość tłuszczu' in skladniki:
                    skladniki = ''
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
