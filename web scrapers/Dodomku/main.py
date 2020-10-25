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
sql = "INSERT INTO products (name, category, image, barcode, components, price) VALUES (%s, %s, %s, %s, %s, %s)"
sql_update = "UPDATE products SET category = %s WHERE barcode = %s AND category = 'Inne'"
sql_img = "UPDATE products SET image = %s WHERE barcode = %s AND image = 'https://dodomku.pl/gfx/loading_grey_spinner.gif'"

with io.open('failed.txt', "w") as file:
    file.write('')
with io.open('duplicates.txt', "w", encoding="utf-8") as file:
    file.write('')

url = 'https://dodomku.pl/przyprawy_sypkie_mieszanki_3193.html'
driver = webdriver.Firefox()
with driver as driver:
    failed = 0
    def newCategory(url):      
        with io.open('links.txt', "w") as file:
            file.write('')
        driver.get(url)
        products = driver.find_elements_by_css_selector(".parametry.product-image div a:first-child")
        arrayofLinks = []
        for product in products:
            with io.open('links.txt', "a") as file:
                file.write(product.get_attribute('href') + '\n')
        number_of_lines = len(open('links.txt').readlines())
        with io.open('links.txt', "r") as file:
            arrayofLinks = file.readlines()
        for link in arrayofLinks:
            number_of_lines -= 1
            driver.get(link)
            skladniki = 'null'
            kategoria = 'Produkty sypkie i makarony'
            zdjecie = 'null'
            nazwa = 'null'
            kod_kreskowy = 'null'
            if (((number_of_lines) % 100) == 0):
                print('Pozostalo', number_of_lines, 'produktow')
            elif (((number_of_lines) % 50) == 0):
                print('Pozostalo', number_of_lines, 'produktow')
            elif (((number_of_lines) % 10) == 0 and number_of_lines < 50):
                print('Pozostalo', number_of_lines, 'produktow')
            time.sleep(1)
            try:
                zdjecie = driver.find_element_by_css_selector('#wybrany_rysunek .main-product-img').get_attribute('src')
            except Exception:
                print('Nie znaleziono zadnego zdjecia')
                with io.open('failed.txt', "a") as file:
                    file.write(link)
                continue
            try:
                nazwa = driver.find_element_by_css_selector('#naglowek h1').get_attribute('textContent')
                kod_kreskowy = driver.find_element_by_css_selector('div p.icon_value[itemprop="sku"]').get_attribute('textContent')
                cena = driver.find_element_by_css_selector('div#wybrany_cena span:nth-child(2)').get_attribute('textContent')
            except Exception as e:
                print('Wykryto wyjatek:', e, end="")
                with io.open('failed.txt', "a") as file:
                    file.write(link)
                continue
            try:
                skladniki = driver.find_element_by_css_selector('div#ingredients .dlugi_opis_tresc:nth-child(2)').get_attribute('textContent')
                if 'Zawartość tłuszczu' in skladniki:
                    skladniki = ''
            except Exception:
                skladniki = ''
                pass
            if (kod_kreskowy.replace(' ', '') == ''):
                kod_kreskowy = 'null'
            # print(zdjecie, nazwa, kod_kreskowy, skladniki, cena)
            Product = {
                'kategoria': kategoria,
                'zdjecie': zdjecie,
                'nazwa': nazwa,
                'kod_kreskowy': kod_kreskowy,
                'skladniki': skladniki,
                'cena': cena
            }
            if kod_kreskowy == 'null':
                kod_kreskowy = ''            
            if skladniki == 'null':
                skladniki = ''
            val = (nazwa, kategoria, zdjecie, kod_kreskowy, skladniki, cena)
            try:
                db.execute(sql, val)
                with io.open('new-products.txt', "a", encoding="utf-8") as file:
                    file.write(json.dumps(Product))
                    file.write('\n')
            except mysql.connector.IntegrityError:
                # print('Produkt nie zostal dodany - produkt juz istnieje w bazie!')
                # with io.open('duplicates.txt', "a", encoding="utf-8") as file:
                #     file.write(json.dumps(Product))
                #     file.write('\n')
                if kod_kreskowy == '':
                    kod_kreskowy = 'null'            
                if skladniki == '':
                    skladniki = 'null'
                with io.open('products.txt', "a", encoding="utf-8") as file:
                    file.write(json.dumps(Product))
                    file.write('\n')
                val_update = (kategoria, kod_kreskowy)
                db.execute(sql_update, val_update)
                pass
            mydb.commit()

            val_img = (zdjecie, kod_kreskowy)
            db.execute(sql_img, val_img)
            mydb.commit()
            
        # driver.get('http://localhost:5000/')
        # print('Czekam 30 sekund!')
        # time.sleep(20)
        # print('Pozostalo 10 sekund')
        # time.sleep(5)
        # print('Pozostalo 5 sekund')
        # time.sleep(5)
        # url = driver.find_element_by_class_name('url').get_attribute('value')
        # if (url == 'koniec' or url == ''):
            # jsonToFile = json.dumps(arrayOfProducts)
            # with io.open('products-database.json', 'a', encoding="utf-8") as f:
            #     f.write(jsonToFile)
        print('Koniec!')
        driver.quit()
        # else:
        #     newCategory(url)
    newCategory(url)
