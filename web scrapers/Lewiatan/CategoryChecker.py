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
sql_category = "SELECT category FROM products WHERE barcode = %s"

url = 'http://www.eskleplewiatan.pl/cat-pl-37-Slodycze.html'
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
                # arrayofLinks.append(product.find_element_by_css_selector('.photo a').get_attribute('href'))
        number_of_lines = len(open('links.txt').readlines())
        with io.open('links.txt', "r") as file:
            arrayofLinks = file.readlines()
        for link in arrayofLinks:
            number_of_lines -= 1
            driver.get(link)
            skladniki = 'null'
            kategoria = 'Słodycze'
            zdjecie = 'null'
            nazwa = 'null'
            kod_kreskowy = 'null'
            time.sleep(1)
            if (((number_of_lines) % 100) == 0):
                print('Pozostalo', number_of_lines, 'produktow')
            elif (((number_of_lines) % 50) == 0):
                print('Pozostalo', number_of_lines, 'produktow')
            elif (((number_of_lines) % 10) == 0 and number_of_lines < 50):
                print('Pozostalo', number_of_lines, 'produktow')
            try:
                zdjecie = driver.find_element_by_css_selector('.main-photo img').get_attribute('src')
            except Exception:
                    try:
                        zdjecie = driver.find_element_by_css_selector('#karta_galeria a img').get_attribute('src')
                    except Exception:
                        print('Nie znaleziono zadnego zdjecia')
                        continue
            try:
                nazwa = driver.find_element_by_css_selector('h1.title').get_attribute('textContent')
                kod_kreskowy = driver.find_element_by_css_selector('.meta-info div:nth-child(3)').get_attribute('textContent').replace('Kod kreskowy:', '')
                cena = driver.find_element_by_css_selector('.cena .price .wartosc.nobr')
                pola_opisu = driver.find_elements_by_css_selector('.desc-col *')
            except Exception as e:
                print('Wykryto wyjatek:', e, end="")
                continue
            cena = cena.get_attribute('textContent').replace(' zł', '')
            isFound = False
            skladniki = ''
            for pole in pola_opisu:
                if isFound == True:
                    if (pole.get_attribute('class') == 'text'):
                        skladniki = pole.get_attribute('textContent')
                        break
                if (pole.get_attribute('textContent') == 'Składniki'):
                    isFound = True
            if (skladniki == ''):
                skladniki = 'null'
            if (kod_kreskowy.replace(' ', '') == ''):
                kod_kreskowy = 'null'
            # print(zdjecie, nazwa, kod_kreskowy, skladniki, cena)
            if 'NAZWA_TYMCZASOWA' in nazwa:
                print('Jest i owe zjawisko!')
                break
            Product = {
                'kategoria': kategoria,
                'zdjecie': zdjecie,
                'nazwa': nazwa,
                'kod_kreskowy': kod_kreskowy,
                'skladniki': skladniki,
                'cena': cena
            }
            val_kk = (kod_kreskowy, )
            db.execute(sql_category, val_kk)
            cg = db.fetchone()[0]
            if (cg == 'Inne'):
                with io.open('withoutCategory.txt', "a", encoding="utf-8") as file:
                    file.write(json.dumps(Product))
                    file.write('\n')
                val_update = (kategoria, kod_kreskowy)
                db.execute(sql_update, val_update)
            else:
                if (skladniki == 'null'):
                    skladniki = ''
                if (kod_kreskowy == 'null'):
                    kod_kreskowy = ''
                try:
                    val = (nazwa, kategoria, zdjecie, kod_kreskowy, skladniki, cena)
                    db.execute(sql, val)
                    with io.open('new-products.txt', "a", encoding="utf-8") as file:
                        file.write(json.dumps(Product))
                        file.write('\n')
                except mysql.connector.IntegrityError:
                    pass
            mydb.commit()
        print('Koniec!')
        driver.quit()
    newCategory(url)
