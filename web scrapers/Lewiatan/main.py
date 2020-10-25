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

# units = [' g', ' ml', ' kg', ' l']

db = mydb.cursor()
sql = "INSERT INTO products (name, category, image, barcode, components, price) VALUES (%s, %s, %s, %s, %s, %s)"
sql_update = "UPDATE products SET category = %s WHERE barcode = %s AND category = 'Inne'"
with io.open('failed.txt', "w") as file:
    file.write('')

# url = 'http://www.eskleplewiatan.pl/cat-pl-32-Owoce-i-warzywa.html?per_page=100&sort=prod_id+ASC&o=&pricemin=&pricemax=&filtr_producent='
url = 'http://www.eskleplewiatan.pl/cat-pl-37-Slodycze.html'
driver = webdriver.Firefox()
with driver as driver:
    failed = 0
    def newCategory(url):      
        with io.open('links.txt', "w") as file:
            file.write('')
        driver.get(url)
        # products = driver.find_elements_by_css_selector(".lista_produktow .product .photo a")
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
            # time.sleep(1)
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
                        with io.open('failed.txt', "a") as file:
                            file.write(link)
                        continue
            try:
                nazwa = driver.find_element_by_css_selector('h1.title').get_attribute('textContent')
                # for unit in units:   
                #     if (unit in nazwa):
                #         nazwa = ''
                #         nowa_nazwa = nazwa.split(' ')
                #         waga = nowa_nazwa[-2:]
                #         waga = waga[0] + ' ' + waga[1]
                #         nowa_nazwa = nowa_nazwa[:-2]
                #         for p in nowa_nazwa:
                #             nazwa += p + ' '
                #         nazwa = nazwa.strip()
                #         print('Znaleziono w', nazwa, 'jednostke:', unit, 'WAGA:', waga)
                #         break
                kod_kreskowy = driver.find_element_by_css_selector('.meta-info div:nth-child(3)').get_attribute('textContent').replace('Kod kreskowy:', '')
                cena = driver.find_element_by_css_selector('.cena .price .wartosc.nobr')
                pola_opisu = driver.find_elements_by_css_selector('.desc-col *')
                # kategoria = driver.find_element_by_css_selector('.breadcrumbs a:nth-child(2)').get_attribute('textContent')
            except Exception as e:
                print('Wykryto wyjatek:', e, end="")
                with io.open('failed.txt', "a") as file:
                    file.write(link)
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
                break
            Product = {
                'kategoria': kategoria,
                'zdjecie': zdjecie,
                'nazwa': nazwa,
                'kod_kreskowy': kod_kreskowy,
                'skladniki': skladniki,
                'cena': cena
            }
            with io.open('products.txt', "a", encoding="utf-8") as file:
                file.write(json.dumps(Product))
                file.write('\n')
            val = (nazwa, kategoria, zdjecie, kod_kreskowy, skladniki , cena)
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

        driver.get('http://localhost:5000/')
        print('Czekam 30 sekund!')
        time.sleep(20)
        print('Pozostalo 10 sekund')
        time.sleep(5)
        print('Pozostalo 5 sekund')
        time.sleep(5)
        url = driver.find_element_by_class_name('url').get_attribute('value')
        if (url == 'koniec' or url == ''):
            # jsonToFile = json.dumps(arrayOfProducts)
            # with io.open('products-database.json', 'a', encoding="utf-8") as f:
            #     f.write(jsonToFile)
            print('Koniec!')
            driver.quit()
        else:
            newCategory(url)
    newCategory(url)
